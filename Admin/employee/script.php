<script>
    const config = {
        apiUrl: 'http://localhost/workclock/api',
        apiKey: 'local_test_key',
        companyId: '1',
        employee: {
            id: 'EM1001',
            name: 'John Doe',
            initials: 'JD',
            department: 'Development'
        },
        refreshRate: 60000,
        locationRefreshRate: 300000,
        maxRetries: 3,
        toastDuration: 3000,
        debug: true,
        minLocationAccuracy: 50 // meters - minimum required accuracy for check-in/out
    };

    // State Management
    const appState = {
        isCheckedIn: false,
        lastCheckin: null,
        currentPosition: null,
        locationAddress: null,
        locationAccuracy: null,
        apiConnected: false,
        activeTab: 'today',
        offlineQueue: JSON.parse(localStorage.getItem('offlineQueue') || '[]'),
        connectionRetries: 0,
        history: [],
        sessionHours: 0,
        weeklyHours: 0,
        isProcessing: false,
        timerInterval: null
    };

    // DOM Elements
    const elements = {
        timeStatusCard: document.getElementById('time-status-card'),
        statusBadge: document.getElementById('status-badge'),
        currentTimeEl: document.getElementById('current-time'),
        currentDateEl: document.getElementById('current-date'),
        sessionTimerEl: document.getElementById('session-timer'),
        timeInBtn: document.getElementById('time-in-btn'),
        timeOutBtn: document.getElementById('time-out-btn'),
        locationText: document.getElementById('location-text'),
        locationInfo: document.getElementById('location-info'),
        refreshLocation: document.getElementById('refresh-location'),
        mapContainer: document.getElementById('map-container'),
        mapPlaceholder: document.getElementById('map-placeholder'),
        historyList: document.getElementById('history-list'),
        emptyHistory: document.getElementById('empty-history'),
        historyTabs: document.querySelectorAll('.history-tab'),
        hoursToday: document.getElementById('hours-today'),
        hoursWeek: document.getElementById('hours-week'),
        apiStatus: document.getElementById('api-status'),
        apiIndicator: document.getElementById('api-indicator'),
        apiStatusText: document.getElementById('api-status-text'),
        toastContainer: document.getElementById('toast-container'),
        avatarBtn: document.getElementById('avatar-btn'),
        dropdownMenu: document.getElementById('dropdown-menu'),
        notificationIcon: document.getElementById('notification-icon'),
        viewReports: document.getElementById('view-reports')
    };

    // Utility Functions
    const utils = {
        formatTime: (date) => {
            return date.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });
        },

        formatDate: (date) => {
            return date.toLocaleDateString('en-US', {
                weekday: 'long',
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
        },

        calculateHours: (startTime, endTime) => {
            const diff = Math.abs(endTime - startTime) / 36e5;
            return parseFloat(diff.toFixed(1));
        },

        storeWithExpiry: (key, value, ttl) => {
            const now = new Date();
            const item = {
                value: value,
                expiry: now.getTime() + ttl,
            };
            localStorage.setItem(key, JSON.stringify(item));
        },

        getWithExpiry: (key) => {
            const itemStr = localStorage.getItem(key);
            if (!itemStr) return null;

            const item = JSON.parse(itemStr);
            const now = new Date();
            if (now.getTime() > item.expiry) {
                localStorage.removeItem(key);
                return null;
            }
            return item.value;
        },

        formatAddress: (address) => {
            if (!address) return 'Unknown location';
            return `${address.street || ''}, ${address.city || ''}`;
        },

        throttle: (func, limit) => {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        },

        debounce: (func, delay) => {
            let debounceTimer;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(context, args), delay);
            };
        },

        calculateDistance: (lat1, lon1, lat2, lon2) => {
            const R = 6371; // Earth's radius in km
            const dLat = (lat2 - lat1) * (Math.PI / 180);
            const dLon = (lon2 - lon1) * (Math.PI / 180);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c; // Distance in km
        },

        formatDuration: (milliseconds) => {
            const totalSeconds = Math.floor(milliseconds / 1000);
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
    };

    // API Service
    const apiService = {
        baseUrl: config.apiUrl,
        apiKey: config.apiKey,
        companyId: config.companyId,

        init: function() {
            return this.testConnection();
        },

        request: async function(endpoint, method = 'GET', data = null) {
            if (!this.baseUrl || !this.apiKey) {
                throw new Error('API not configured. Please check settings.');
            }

            const url = `${this.baseUrl}/${endpoint}`;
            const options = {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.apiKey}`,
                    'X-Company-ID': this.companyId
                },
                credentials: 'include',
            };

            if (data && (method === 'POST' || method === 'PUT')) {
                options.body = JSON.stringify(data);
            }

            try {
                const response = await fetch(url, options);

                if (response.status === 429) {
                    const retryAfter = response.headers.get('Retry-After') || 5;
                    await new Promise(resolve => setTimeout(resolve, retryAfter * 1000));
                    return this.request(endpoint, method, data);
                }

                if (!response.ok) {
                    throw new Error(`API Error: ${response.status} ${response.statusText}`);
                }

                appState.apiConnected = true;
                appState.connectionRetries = 0;
                uiController.updateApiStatus(true);

                return await response.json();
            } catch (error) {
                appState.connectionRetries++;

                if (appState.connectionRetries <= config.maxRetries) {
                    const backoffTime = Math.pow(2, appState.connectionRetries) * 1000;
                    await new Promise(resolve => setTimeout(resolve, backoffTime));
                    return this.request(endpoint, method, data);
                }

                appState.apiConnected = false;
                uiController.updateApiStatus(false);

                if (method !== 'GET' && data) {
                    this.queueOfflineRequest(endpoint, method, data);
                }

                throw error;
            }
        },

        testConnection: async function() {
            try {
                await this.request('status');
                appState.apiConnected = true;
                uiController.updateApiStatus(true);
                return true;
            } catch (error) {
                appState.apiConnected = false;
                uiController.updateApiStatus(false);
                console.error('API Connection Error:', error);
                return false;
            }
        },

        queueOfflineRequest: function(endpoint, method, data) {
            appState.offlineQueue.push({
                endpoint,
                method,
                data,
                timestamp: new Date().getTime()
            });
            localStorage.setItem('offlineQueue', JSON.stringify(appState.offlineQueue));
            uiController.showToast('Request Queued', 'This action will be processed when connection is restored.', 'info');
        },

        processOfflineQueue: async function() {
            if (appState.offlineQueue.length === 0) return;

            const queue = [...appState.offlineQueue];
            appState.offlineQueue = [];
            localStorage.setItem('offlineQueue', JSON.stringify(appState.offlineQueue));

            let successCount = 0;

            for (const item of queue) {
                try {
                    await this.request(item.endpoint, item.method, item.data);
                    successCount++;
                } catch (error) {
                    this.queueOfflineRequest(item.endpoint, item.method, item.data);
                }
            }

            if (successCount > 0) {
                uiController.showToast(
                    'Sync Complete',
                    `Successfully processed ${successCount} offline ${successCount === 1 ? 'request' : 'requests'}.`,
                    'success'
                );

                timeController.fetchHistory();
            }
        },

        checkIn: async function(location) {
            return this.request('time/check-in', 'POST', {
                employeeId: config.employee.id,
                timestamp: new Date().toISOString(),
                location: location
            });
        },

        checkOut: async function(location) {
            return this.request('time/check-out', 'POST', {
                employeeId: config.employee.id,
                timestamp: new Date().toISOString(),
                location: location
            });
        },

        getTimeHistory: async function(period = 'today') {
            return this.request(`time/history/${config.employee.id}?period=${period}`);
        },

        getTimeStats: async function() {
            return this.request(`time/stats/${config.employee.id}`);
        },

        getAddressFromCoords: async function(lat, lng) {
            const cacheKey = `geocode_${lat.toFixed(4)}_${lng.toFixed(4)}`;
            const cachedAddress = utils.getWithExpiry(cacheKey);

            if (cachedAddress) {
                return cachedAddress;
            }

            try {
                const result = await this.request(`geocode?lat=${lat}&lng=${lng}`);
                utils.storeWithExpiry(cacheKey, result, 24 * 60 * 60 * 1000);
                return result;
            } catch (error) {
                console.error('Geocoding error:', error);
                return null;
            }
        }
    };

    // Time Controller
    const timeController = {
        clockInterval: null,

        init: function() {
            this.updateClock();
            this.clockInterval = setInterval(this.updateClock.bind(this), 1000);
            this.fetchStatus();
            this.fetchHistory();
            this.fetchStats();

            elements.timeInBtn.addEventListener('click', this.handleTimeIn.bind(this));
            elements.timeOutBtn.addEventListener('click', this.handleTimeOut.bind(this));

            elements.historyTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    this.changeHistoryTab(tab.getAttribute('data-tab'));
                });
            });
        },

        updateClock: function() {
            const now = new Date();
            elements.currentTimeEl.textContent = utils.formatTime(now);
            elements.currentDateEl.textContent = utils.formatDate(now);

            // Update session timer if checked in
            if (appState.isCheckedIn && appState.lastCheckin) {
                this.updateSessionTimer();
            }
        },

        updateSessionTimer: function() {
            if (!appState.isCheckedIn || !appState.lastCheckin) {
                elements.sessionTimerEl.style.display = 'none';
                return;
            }

            const now = new Date();
            const duration = now - appState.lastCheckin;
            elements.sessionTimerEl.textContent = utils.formatDuration(duration);
            elements.sessionTimerEl.style.display = 'block';
        },

        fetchStatus: async function() {
            try {
                if (!appState.apiConnected) return;

                const statusData = await apiService.request(`time/status/${config.employee.id}`);

                if (statusData.isCheckedIn) {
                    appState.isCheckedIn = true;
                    appState.lastCheckin = new Date(statusData.lastCheckinTime);
                    this.updateUIForCheckedIn();
                    locationController.startWatchingPosition();
                    locationController.startAccuracyMonitor();
                } else {
                    appState.isCheckedIn = false;
                    appState.lastCheckin = null;
                    this.updateUIForCheckedOut();
                    locationController.stopWatchingPosition();
                    locationController.stopAccuracyMonitor();
                }
            } catch (error) {
                console.error('Error fetching status:', error);
            }
        },

        fetchHistory: async function() {
            try {
                if (!appState.apiConnected) return;

                const period = appState.activeTab;
                const historyData = await apiService.getTimeHistory(period);

                appState.history = historyData.entries || [];
                this.renderHistory();
            } catch (error) {
                console.error('Error fetching history:', error);
            }
        },

        fetchStats: async function() {
            try {
                if (!appState.apiConnected) return;

                const statsData = await apiService.getTimeStats();

                appState.sessionHours = statsData.today || 0;
                appState.weeklyHours = statsData.week || 0;

                elements.hoursToday.textContent = `${appState.sessionHours.toFixed(1)}h`;
                elements.hoursWeek.textContent = `${appState.weeklyHours.toFixed(1)}h`;
            } catch (error) {
                console.error('Error fetching stats:', error);
            }
        },

        handleTimeIn: async function() {
            if (appState.isProcessing) return;

            try {
                appState.isProcessing = true;
                uiController.setButtonLoading(elements.timeInBtn, true);

                const location = await locationController.getCurrentPosition();

                if (!location) {
                    throw new Error('Unable to determine your location. Please try again.');
                }

                // Check location accuracy
                if (location.coords.accuracy > config.minLocationAccuracy) {
                    throw new Error(`Location accuracy is too low (${Math.round(location.coords.accuracy)}m). 
                            Please move to an area with better GPS signal.`);
                }

                await apiService.checkIn({
                    latitude: location.coords.latitude,
                    longitude: location.coords.longitude,
                    accuracy: location.coords.accuracy,
                    address: appState.locationAddress
                });

                appState.isCheckedIn = true;
                appState.lastCheckin = new Date();

                this.updateUIForCheckedIn();
                this.fetchHistory();
                locationController.startWatchingPosition();
                locationController.startAccuracyMonitor();

                uiController.showToast('Checked In', 'You have successfully checked in.', 'success');
            } catch (error) {
                console.error('Check-in error:', error);
                uiController.showToast('Check-in Failed', error.message, 'error');
            } finally {
                appState.isProcessing = false;
                uiController.setButtonLoading(elements.timeInBtn, false);
            }
        },

        handleTimeOut: async function() {
            if (appState.isProcessing) return;

            try {
                appState.isProcessing = true;
                uiController.setButtonLoading(elements.timeOutBtn, true);

                const location = await locationController.getCurrentPosition();

                if (!location) {
                    throw new Error('Unable to determine your location. Please try again.');
                }

                // Check location accuracy
                if (location.coords.accuracy > config.minLocationAccuracy) {
                    throw new Error(`Location accuracy is too low (${Math.round(location.coords.accuracy)}m). 
                            Please move to an area with better GPS signal.`);
                }

                let sessionHours = 0;
                if (appState.lastCheckin) {
                    sessionHours = utils.calculateHours(appState.lastCheckin, new Date());
                }

                await apiService.checkOut({
                    latitude: location.coords.latitude,
                    longitude: location.coords.longitude,
                    accuracy: location.coords.accuracy,
                    address: appState.locationAddress,
                    hours: sessionHours
                });

                appState.isCheckedIn = false;
                appState.lastCheckin = null;

                this.updateUIForCheckedOut();
                this.fetchHistory();
                this.fetchStats();
                locationController.stopWatchingPosition();
                locationController.stopAccuracyMonitor();

                uiController.showToast('Checked Out', `You worked ${sessionHours.toFixed(1)} hours this session.`, 'success');
            } catch (error) {
                console.error('Check-out error:', error);
                uiController.showToast('Check-out Failed', error.message, 'error');
            } finally {
                appState.isProcessing = false;
                uiController.setButtonLoading(elements.timeOutBtn, false);
            }
        },

        updateUIForCheckedIn: function() {
            elements.timeStatusCard.classList.remove('checked-out');
            elements.timeStatusCard.classList.add('checked-in');

            elements.statusBadge.classList.remove('checked-out');
            elements.statusBadge.classList.add('checked-in');
            elements.statusBadge.innerHTML = '<i class="fas fa-circle"></i> CHECKED IN';

            elements.timeInBtn.disabled = true;
            elements.timeOutBtn.disabled = false;

            // Show and start updating the session timer
            elements.sessionTimerEl.style.display = 'block';
            this.updateSessionTimer();
        },

        updateUIForCheckedOut: function() {
            elements.timeStatusCard.classList.remove('checked-in');
            elements.timeStatusCard.classList.add('checked-out');

            elements.statusBadge.classList.remove('checked-in');
            elements.statusBadge.classList.add('checked-out');
            elements.statusBadge.innerHTML = '<i class="fas fa-circle"></i> CHECKED OUT';

            elements.timeInBtn.disabled = false;
            elements.timeOutBtn.disabled = true;

            // Hide the session timer
            elements.sessionTimerEl.style.display = 'none';
        },

        changeHistoryTab: function(tabName) {
            appState.activeTab = tabName;

            elements.historyTabs.forEach(tab => {
                if (tab.getAttribute('data-tab') === tabName) {
                    tab.classList.add('active');
                } else {
                    tab.classList.remove('active');
                }
            });

            this.fetchHistory();
        },

        renderHistory: function() {
            const historyList = elements.historyList;

            while (historyList.firstChild) {
                historyList.removeChild(historyList.firstChild);
            }

            if (!appState.history || appState.history.length === 0) {
                historyList.appendChild(elements.emptyHistory);
                return;
            }

            elements.emptyHistory.remove();

            const sortedHistory = [...appState.history].sort((a, b) => {
                return new Date(b.timestamp) - new Date(a.timestamp);
            });

            sortedHistory.forEach(entry => {
                const historyItem = document.createElement('div');
                historyItem.className = 'history-item';

                const entryTime = new Date(entry.timestamp);
                const formattedTime = utils.formatTime(entryTime);
                const formattedDate = entryTime.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric'
                });

                historyItem.innerHTML = `
                        <div class="history-info">
                            <div class="history-time">
                                ${formattedTime}
                                <span class="history-date">${formattedDate}</span>
                            </div>
                            <div class="history-location">${entry.location.address || 'Unknown location'}</div>
                        </div>
                        <div class="history-type ${entry.type.toLowerCase()}">
                            <i class="fas fa-${entry.type === 'IN' ? 'sign-in-alt' : 'sign-out-alt'}"></i>
                            ${entry.type}
                        </div>
                    `;

                historyList.appendChild(historyItem);
            });
        }
    };

    // Location Controller
    const locationController = {
        watchId: null,
        accuracyInterval: null,

        init: function() {
            this.checkLocationPermission();
            elements.refreshLocation.addEventListener('click', this.updateLocation.bind(this));
        },

        checkLocationPermission: async function() {
            try {
                const result = await navigator.permissions.query({
                    name: 'geolocation'
                });

                if (result.state === 'granted') {
                    this.updateLocation();
                } else if (result.state === 'prompt') {
                    elements.locationText.textContent = 'Please allow location access';
                } else {
                    elements.locationText.textContent = 'Location access denied';
                    elements.locationInfo.classList.add('error-state');
                }

                result.addEventListener('change', () => {
                    this.checkLocationPermission();
                });
            } catch (error) {
                console.error('Error checking location permission:', error);
                elements.locationText.textContent = 'Unable to access location services';
                elements.locationInfo.classList.add('error-state');
            }
        },

        updateLocation: async function() {
            elements.locationText.textContent = 'Updating location...';
            elements.refreshLocation.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            elements.locationInfo.classList.remove('error-state');

            try {
                const position = await this.getCurrentPosition();

                if (!position) {
                    throw new Error('Unable to determine your location');
                }

                appState.currentPosition = position;
                const accuracy = Math.round(position.coords.accuracy);
                appState.locationAccuracy = accuracy;

                // Visual feedback based on accuracy
                let accuracyClass = 'low-accuracy';
                if (accuracy < 20) accuracyClass = 'high-accuracy';
                else if (accuracy < 100) accuracyClass = 'medium-accuracy';

                if (appState.apiConnected) {
                    const address = await apiService.getAddressFromCoords(
                        position.coords.latitude,
                        position.coords.longitude
                    );

                    appState.locationAddress = address;
                    elements.locationText.innerHTML = `
                            ${utils.formatAddress(address)}
                            <span class="accuracy-badge ${accuracyClass}">±${accuracy}m</span>
                        `;
                } else {
                    elements.locationText.innerHTML = `
                            ${position.coords.latitude.toFixed(6)}, ${position.coords.longitude.toFixed(6)}
                            <span class="accuracy-badge ${accuracyClass}">±${accuracy}m</span>
                        `;
                }

                // Update map placeholder with accuracy information
                elements.mapPlaceholder.innerHTML = `
                        <i class="fas fa-map-pin ${accuracyClass}"></i>
                        <div>${position.coords.latitude.toFixed(6)}, ${position.coords.longitude.toFixed(6)}</div>
                        <small class="accuracy-info">Accuracy: ±${accuracy}m</small>
                    `;

            } catch (error) {
                console.error('Location error:', error);
                elements.locationText.textContent = error.message;
                elements.locationInfo.classList.add('error-state');
            } finally {
                elements.refreshLocation.innerHTML = 'Refresh <i class="fas fa-sync-alt"></i>';
            }
        },

        getCurrentPosition: function() {
            return new Promise((resolve, reject) => {
                if (!navigator.geolocation) {
                    reject(new Error('Geolocation is not supported by your browser'));
                    return;
                }

                // First try with high accuracy and longer timeout
                navigator.geolocation.getCurrentPosition(
                    position => {
                        // If accuracy is poor (over 100m), try again with different settings
                        if (position.coords.accuracy > 100) {
                            navigator.geolocation.getCurrentPosition(
                                betterPosition => resolve(betterPosition),
                                error => resolve(position), // Fall back to original position if second attempt fails
                                {
                                    enableHighAccuracy: true,
                                    timeout: 15000,
                                    maximumAge: 0 // Force fresh reading
                                }
                            );
                        } else {
                            resolve(position);
                        }
                    },
                    error => {
                        // If high accuracy fails, try with less strict requirements
                        navigator.geolocation.getCurrentPosition(
                            position => resolve(position),
                            error => {
                                let errorMessage = 'Could not determine your location';
                                switch (error.code) {
                                    case error.PERMISSION_DENIED:
                                        errorMessage = 'Location access was denied. Please enable it in your browser settings.';
                                        break;
                                    case error.POSITION_UNAVAILABLE:
                                        errorMessage = 'Location information is unavailable. Try moving to an area with better signal.';
                                        break;
                                    case error.TIMEOUT:
                                        errorMessage = 'Location request timed out. Please check your internet connection.';
                                        break;
                                }
                                reject(new Error(errorMessage));
                            }, {
                                enableHighAccuracy: false,
                                timeout: 20000,
                                maximumAge: 300000 // Accept positions up to 5 minutes old
                            }
                        );
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 60000
                    }
                );
            });
        },

        startWatchingPosition: function() {
            if (this.watchId) return;

            this.watchId = navigator.geolocation.watchPosition(
                this.handlePositionUpdate.bind(this),
                this.handlePositionError.bind(this), {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 60000
                });
        },

        stopWatchingPosition: function() {
            if (this.watchId) {
                navigator.geolocation.clearWatch(this.watchId);
                this.watchId = null;
            }
        },

        startAccuracyMonitor: function() {
            if (this.accuracyInterval) return;

            this.accuracyInterval = setInterval(() => {
                if (appState.currentPosition) {
                    const accuracy = Math.round(appState.currentPosition.coords.accuracy);
                    const accuracyBadge = document.querySelector('.accuracy-badge');
                    const mapPin = document.querySelector('.map-placeholder i');

                    if (accuracyBadge) {
                        accuracyBadge.textContent = `±${accuracy}m`;
                        // Update class based on accuracy
                        accuracyBadge.className = `accuracy-badge ${accuracy < 20 ? 'high-accuracy' :
                                accuracy < 100 ? 'medium-accuracy' : 'low-accuracy'
                                }`;
                    }

                    if (mapPin) {
                        mapPin.className = `fas fa-map-pin ${accuracy < 20 ? 'high-accuracy' :
                                accuracy < 100 ? 'medium-accuracy' : 'low-accuracy'
                                }`;
                    }
                }
            }, 5000); // Update every 5 seconds
        },

        stopAccuracyMonitor: function() {
            if (this.accuracyInterval) {
                clearInterval(this.accuracyInterval);
                this.accuracyInterval = null;
            }
        },

        handlePositionUpdate: function(position) {
            if (!appState.currentPosition || utils.calculateDistance(
                    appState.currentPosition.coords.latitude,
                    appState.currentPosition.coords.longitude,
                    position.coords.latitude,
                    position.coords.longitude
                ) > 0.1) { // Only update if moved more than 100m
                appState.currentPosition = position;
                this.updateLocation();
            }
        },

        handlePositionError: function(error) {
            console.error('Watch position error:', error);
        }
    };

    // UI Controller
    const uiController = {
        init: function() {
            this.setupAvatarInitials();
            this.setupDropdownMenu();

            this.updateApiStatus(appState.apiConnected);

            elements.viewReports.addEventListener('click', this.handleViewReports.bind(this));
            elements.notificationIcon.addEventListener('click', this.handleNotifications.bind(this));

            this.registerServiceWorker();

            window.addEventListener('online', this.handleOnline.bind(this));
            window.addEventListener('offline', this.handleOffline.bind(this));

            if (!navigator.onLine) {
                this.handleOffline();
            }
        },

        setupDropdownMenu: function() {
            // Toggle dropdown when clicking avatar
            elements.avatarBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                elements.dropdownMenu.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', () => {
                elements.dropdownMenu.classList.remove('show');
            });
        },

        setupAvatarInitials: function() {
            const nameParts = config.employee.name.split(' ');
            let initials = '';

            if (nameParts.length > 0) {
                initials += nameParts[0].charAt(0).toUpperCase();
            }

            if (nameParts.length > 1) {
                initials += nameParts[nameParts.length - 1].charAt(0).toUpperCase();
            }

            elements.avatarBtn.textContent = initials || 'ME';
        },

        updateApiStatus: function(connected) {
            if (connected) {
                elements.apiIndicator.classList.remove('disconnected');
                elements.apiIndicator.classList.add('connected');
                elements.apiStatusText.textContent = 'API connected';
            } else {
                elements.apiIndicator.classList.remove('connected');
                elements.apiIndicator.classList.add('disconnected');
                elements.apiStatusText.textContent = 'API not connected';
            }
        },

        showToast: function(title, message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;

            let iconClass;
            switch (type) {
                case 'success':
                    iconClass = 'fas fa-check-circle';
                    break;
                case 'error':
                    iconClass = 'fas fa-exclamation-circle';
                    break;
                default:
                    iconClass = 'fas fa-info-circle';
            }

            toast.innerHTML = `
                    <div class="toast-icon"><i class="${iconClass}"></i></div>
                    <div class="toast-content">
                        <div class="toast-title">${title}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                    <div class="toast-close"><i class="fas fa-times"></i></div>
                `;

            const closeBtn = toast.querySelector('.toast-close');
            closeBtn.addEventListener('click', () => {
                toast.remove();
            });

            setTimeout(() => {
                toast.remove();
            }, config.toastDuration);

            elements.toastContainer.appendChild(toast);
        },

        setButtonLoading: function(button, isLoading) {
            if (isLoading) {
                button.innerHTML = `<span class="loading"></span> ${button.textContent.trim()}`;
                button.disabled = true;
            } else {
                const icon = button.id === 'time-in-btn' ? 'fas fa-sign-in-alt' : 'fas fa-sign-out-alt';
                button.innerHTML = `<i class="${icon}"></i> ${button.textContent.trim()}`;
                button.disabled = false;
            }
        },

        handleViewReports: function() {
            if (!appState.apiConnected) {
                this.showToast('Offline', 'Reports are only available when connected to the API', 'error');
                return;
            }

            this.showToast('Reports', 'Opening reports dashboard...', 'info');
        },

        handleNotifications: function() {
            this.showToast('Notifications', 'Showing your notifications', 'info');
        },

        handleOnline: function() {
            this.showToast('Back Online', 'Connection restored, syncing data...', 'success');

            apiService.testConnection().then(connected => {
                if (connected && appState.offlineQueue.length > 0) {
                    apiService.processOfflineQueue();
                }
            });
        },

        handleOffline: function() {
            this.showToast('Offline Mode', 'Working offline - changes will sync when connection is restored', 'error');
            this.updateApiStatus(false);
        },

        registerServiceWorker: function() {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js').then(
                    registration => {
                        console.log('ServiceWorker registration successful');
                    },
                    err => {
                        console.log('ServiceWorker registration failed: ', err);
                    }
                );
            }
        }
    };

    // Initialize the application
    document.addEventListener('DOMContentLoaded', async () => {
        await apiService.init();

        timeController.init();
        locationController.init();
        uiController.init();

        if (appState.apiConnected && appState.offlineQueue.length > 0) {
            apiService.processOfflineQueue();
        }

        if (appState.isCheckedIn) {
            locationController.startWatchingPosition();
            locationController.startAccuracyMonitor();
        }

        if (config.debug) {
            console.log('App initialized with config:', config);
            console.log('Initial state:', appState);
        }
    });

    if (typeof module !== 'undefined' && module.exports) {
        module.exports = {
            config,
            appState,
            utils,
            apiService,
            timeController,
            locationController,
            uiController
        };
    }
</script>