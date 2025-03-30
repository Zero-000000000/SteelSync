<?php
session_start();

// Redirect to login if no user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: /steelsync/admin/login.php");
    exit();
}

// Verify the user has the correct role
if ($_SESSION["role"] !== 'employee') {
    // Redirect to appropriate page or show error
    header("Location: /steelsync/admin/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkClock Pro | Employee Time Tracking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-grey: #2d3748;
            --secondary-grey: #4a5568;
            --light-grey: #f7fafc;
            --bg-grey: #edf2f7;
            --border-grey: #e2e8f0;
            --primary-orange: #ed8936;
            --secondary-orange: #f6ad55;
            --accent-orange: #dd6b20;
            --success-green: #48bb78;
            --error-red: #f56565;
            --info-blue: #4299e1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: var(--bg-grey);
            color: var(--primary-grey);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .app-container {
            max-width: 480px;
            margin: 0 auto;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* Header styles */
        .header {
            background-color: white;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-grey);
            display: flex;
            align-items: center;
        }

        .logo-icon {
            color: var(--primary-orange);
            margin-right: 0.5rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification-icon {
            color: var(--secondary-grey);
            font-size: 1.25rem;
            position: relative;
            cursor: pointer;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--primary-orange);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background-color: var(--primary-orange);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            position: relative;
        }

        /* Dropdown menu */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            min-width: 160px;
            z-index: 1000;
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            color: var(--secondary-grey);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
        }

        .dropdown-item:hover {
            background-color: var(--bg-grey);
            color: var(--primary-orange);
        }

        .dropdown-item i {
            margin-right: 0.5rem;
            width: 1.25rem;
            text-align: center;
        }

        /* Main content styles */
        .main-content {
            flex: 1;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.07);
        }

        /* Time card styles */
        .time-card {
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .time-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            transition: background-color 0.3s ease;
        }

        .time-card.checked-in::after {
            background-color: var(--success-green);
        }

        .time-card.checked-out::after {
            background-color: var(--primary-orange);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .status-badge i {
            margin-right: 0.5rem;
        }

        .status-badge.checked-in {
            background-color: rgba(72, 187, 120, 0.1);
            color: var(--success-green);
        }

        .status-badge.checked-out {
            background-color: rgba(237, 137, 54, 0.1);
            color: var(--primary-orange);
        }

        .current-time {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--primary-grey);
        }

        .current-date {
            color: var(--secondary-grey);
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .session-timer {
            font-size: 1.25rem;
            color: var(--success-green);
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: none;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .btn {
            padding: 1rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            outline: none;
        }

        .btn i {
            margin-right: 0.5rem;
        }

        .btn-time-in {
            background-color: var(--primary-orange);
            color: white;
        }

        .btn-time-in:hover:not(:disabled) {
            background-color: var(--accent-orange);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-time-out {
            background-color: white;
            color: var(--primary-grey);
            border: 2px solid var(--bg-grey);
        }

        .btn-time-out:hover:not(:disabled) {
            background-color: var(--bg-grey);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Location card styles */
        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-grey);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title-text {
            display: flex;
            align-items: center;
        }

        .section-title-text i {
            margin-right: 0.5rem;
            color: var(--primary-orange);
        }

        .section-actions {
            font-size: 0.875rem;
            font-weight: normal;
            color: var(--primary-orange);
            cursor: pointer;
        }

        .section-actions i {
            margin-left: 0.25rem;
        }

        .location-card {
            padding: 1.5rem;
        }

        .location-info {
            display: flex;
            align-items: center;
            color: var(--secondary-grey);
            margin-top: 0.5rem;
        }

        .location-info i {
            margin-right: 0.75rem;
            color: var(--primary-orange);
            font-size: 1.25rem;
        }

        .accuracy-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            background-color: rgba(66, 153, 225, 0.1);
            color: var(--info-blue);
            margin-left: 0.5rem;
        }

        .high-accuracy {
            color: var(--success-green);
        }

        .medium-accuracy {
            color: var(--primary-orange);
        }

        .low-accuracy {
            color: var(--error-red);
        }

        .map-container {
            width: 100%;
            height: 150px;
            background-color: var(--bg-grey);
            border-radius: 0.75rem;
            margin-top: 1rem;
            position: relative;
            overflow: hidden;
        }

        .map-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 0.5rem;
            color: var(--secondary-grey);
        }

        .map-placeholder i {
            font-size: 2rem;
            color: var(--border-grey);
        }

        .accuracy-info {
            font-size: 0.75rem;
            color: var(--secondary-grey);
            margin-top: 0.25rem;
        }

        /* History card styles */
        .history-card {
            padding: 1.5rem;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-box {
            background-color: var(--bg-grey);
            padding: 1rem;
            border-radius: 0.75rem;
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-grey);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--secondary-grey);
            text-transform: uppercase;
        }

        .history-tabs {
            display: flex;
            border-bottom: 2px solid var(--border-grey);
            margin-bottom: 1rem;
        }

        .history-tab {
            padding: 0.75rem 1rem;
            font-weight: 600;
            color: var(--secondary-grey);
            cursor: pointer;
            position: relative;
        }

        .history-tab.active {
            color: var(--primary-orange);
        }

        .history-tab.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary-orange);
        }

        .history-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            border-radius: 0.75rem;
            background-color: var(--bg-grey);
            transition: transform 0.2s ease;
        }

        .history-item:hover {
            transform: translateY(-2px);
        }

        .history-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .history-time {
            font-weight: 600;
            color: var(--primary-grey);
            display: flex;
            align-items: center;
        }

        .history-date {
            font-size: 0.75rem;
            color: var(--secondary-grey);
            margin-left: 0.5rem;
        }

        .history-location {
            font-size: 0.875rem;
            color: var(--secondary-grey);
        }

        .history-type {
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .history-type.in {
            color: var(--success-green);
        }

        .history-type.out {
            color: var(--primary-orange);
        }

        .history-type i {
            margin-right: 0.5rem;
        }

        .empty-history {
            text-align: center;
            padding: 2rem 0;
            color: var(--secondary-grey);
        }

        .empty-history i {
            font-size: 2.5rem;
            color: var(--border-grey);
            margin-bottom: 1rem;
        }

        /* Toast notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            max-width: 300px;
            z-index: 9999;
        }

        .toast {
            background-color: white;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            animation: slideIn 0.3s ease, fadeOut 0.5s ease 2.5s forwards;
            position: relative;
            overflow: hidden;
        }

        .toast::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 100%;
            background-color: var(--primary-orange);
            animation: shrink 3s linear forwards;
        }

        .toast.success::after {
            background-color: var(--success-green);
        }

        .toast.error::after {
            background-color: var(--error-red);
        }

        .toast-icon {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .toast-message {
            font-size: 0.875rem;
            color: var(--secondary-grey);
        }

        .toast-close {
            color: var(--secondary-grey);
            cursor: pointer;
            padding: 0.25rem;
            margin-left: 0.5rem;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @keyframes shrink {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        /* Loading indicators */
        .loading {
            display: inline-flex;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid rgba(237, 137, 54, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary-orange);
            animation: spin 1s ease-in-out infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Error state */
        .error-state {
            color: var(--error-red);
            display: flex;
            align-items: center;
        }

        .error-state i {
            margin-right: 0.5rem;
        }

        /* Footer */
        .footer {
            background-color: white;
            padding: 1rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--secondary-grey);
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.05);
        }

        .footer span {
            color: var(--primary-orange);
            font-weight: 600;
        }

        /* API connection indicator */
        .api-status {
            display: flex;
            align-items: center;
            font-size: 0.75rem;
            margin-top: 0.5rem;
            justify-content: center;
        }

        .api-status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .api-status-indicator.connected {
            background-color: var(--success-green);
        }

        .api-status-indicator.disconnected {
            background-color: var(--error-red);
        }

        /* Responsive */
        @media (max-width: 480px) {

            .header,
            .main-content,
            .footer {
                padding: 1rem;
            }

            .time-card {
                padding: 1.5rem;
            }

            .current-time {
                font-size: 2.5rem;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="app-container">
        <header class="header">
            <div class="logo">
                <i class="fas fa-clock logo-icon"></i>
                Intellitect System
            </div>
            <div class="user-menu">
                <div class="notification-icon" id="notification-icon">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">2</span>
                </div>
                <div class="avatar" id="avatar-btn">EM</div>
                <div class="dropdown-menu" id="dropdown-menu">
                    <a href="../logout.php" class="dropdown-item">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="card time-card checked-out" id="time-status-card">
                <div class="status-badge checked-out" id="status-badge">
                    <i class="fas fa-circle"></i>
                    CHECKED OUT
                </div>

                <div class="current-time" id="current-time">--:--</div>
                <div class="current-date" id="current-date">--</div>
                <div class="session-timer" id="session-timer"></div>

                <div class="action-buttons">
                    <button class="btn btn-time-in" id="time-in-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        TIME IN
                    </button>
                    <button class="btn btn-time-out" id="time-out-btn" disabled>
                        <i class="fas fa-sign-out-alt"></i>
                        TIME OUT
                    </button>
                </div>
            </div>

            <div class="card location-card">
                <div class="section-title">
                    <div class="section-title-text">
                        <i class="fas fa-map-marker-alt"></i>
                        Current Location
                    </div>
                    <div class="section-actions" id="refresh-location">
                        Refresh <i class="fas fa-sync-alt"></i>
                    </div>
                </div>
                <div class="location-info" id="location-info">
                    <i class="fas fa-crosshairs"></i>
                    <span id="location-text">Detecting your location...</span>
                </div>
                <div class="map-container" id="map-container">
                    <div class="map-placeholder" id="map-placeholder">
                        <i class="fas fa-map-marked-alt"></i>
                        <div>Map will appear here</div>
                    </div>
                </div>
            </div>

            <div class="card history-card">
                <div class="section-title">
                    <div class="section-title-text">
                        <i class="fas fa-chart-bar"></i>
                        Activity Summary
                    </div>
                    <div class="section-actions" id="view-reports">
                        Reports <i class="fas fa-external-link-alt"></i>
                    </div>
                </div>

                <div class="stats-container">
                    <div class="stat-box">
                        <div class="stat-value" id="hours-today">0.0h</div>
                        <div class="stat-label">Today</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value" id="hours-week">0.0h</div>
                        <div class="stat-label">This Week</div>
                    </div>
                </div>

                <div class="history-tabs">
                    <div class="history-tab active" data-tab="today">Today</div>
                    <div class="history-tab" data-tab="week">This Week</div>
                </div>

                <div class="history-list" id="history-list">
                    <div class="empty-history" id="empty-history">
                        <i class="far fa-calendar"></i>
                        <p>No activity recorded today</p>
                    </div>
                </div>
            </div>
        </main>

        <footer class="footer">
            © 2025 <span>Intellitect System</span> | Employee Attendance Tracking
            <div class="api-status" id="api-status">
                <div class="api-status-indicator disconnected" id="api-indicator"></div>
                <span id="api-status-text">API not connected</span>
            </div>
        </footer>

        <!-- Toast container -->
        <div class="toast-container" id="toast-container"></div>
    </div>

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
</body>

</html>