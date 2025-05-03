<section class="header">
    <div class="logo">
        <i class="ri-menu-line icon icon-0 menu"></i>
        <img src="../images/logo.png" alt="Intellitech Systems" class="logo-image">
        <h3>Intellitech Systems</h3>
    </div>
    <div class="header-right">
        <div class="notification--profile">
            <div class="picon bell has-notification">
                <i class="ri-notification-2-line"></i>
            </div>
            <div class="profile" id="profileBtn">
                <img src="../images/super_admin/profile.png" alt="profile pic">
            </div>
            <!-- Enhanced Profile Dropdown Menu -->
            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-item" id="accountSettingsBtn">
                    <i class="ri-user-settings-line"></i>
                    <span>Account Settings</span>
                </div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-item" id="logoutBtn">
                    <i class="ri-logout-box-r-line"></i>
                    <span>Logout</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Account Settings Modal -->
<div id="accountSettingsModal" class="account-modal">
    <div class="account-modal-content">
        <div class="account-modal-header">
            <h2>Account Settings</h2>
            <span class="account-modal-close">&times;</span>
        </div>

        <!-- Modern Tabs -->
        <div class="account-tabs">
            <div class="account-tab account-tab-active" data-tab="username">Change Username</div>
            <div class="account-tab" data-tab="password">Change Password</div>
        </div>

        <!-- Tab Contents with Floating Labels -->
        <div id="username-content" class="account-tab-content account-tab-content-active">
            <form id="usernameForm">
                <div class="account-form-group">
                    <label for="currentUsername">Current Username</label>
                    <input type="text" id="currentUsername" disabled value="admin.user">
                </div>
                <div class="account-form-group floating-label">
                    <input type="text" id="newUsername" placeholder=" " required>
                    <label for="newUsername">New Username</label>
                </div>
                <div class="account-form-group floating-label account-password-toggle">
                    <input type="password" id="currentPasswordUsername" placeholder=" " required>
                    <label for="currentPasswordUsername">Current Password</label>
                    <i class="ri-eye-line" id="toggleCurrentPasswordUsername"></i>
                </div>
                <div id="usernameMessage" class="account-message"></div>
                <div class="account-form-actions">
                    <button type="button" class="account-btn account-btn-secondary" id="cancelChanges">Cancel</button>
                    <button type="submit" class="account-btn account-btn-primary">
                        <span class="btn-text">Save Changes</span>
                    </button>
                </div>
            </form>
        </div>

        <div id="password-content" class="account-tab-content">
            <form id="passwordForm">
                <div class="account-form-group floating-label account-password-toggle">
                    <input type="password" id="currentPassword" placeholder=" " required>
                    <label for="currentPassword">Current Password</label>
                    <i class="ri-eye-line" id="toggleCurrentPassword"></i>
                </div>
                <div class="account-form-group floating-label account-password-toggle">
                    <input type="password" id="newPassword" placeholder=" " required>
                    <label for="newPassword">New Password</label>
                    <i class="ri-eye-line" id="toggleNewPassword"></i>
                </div>
                <div class="account-form-group floating-label account-password-toggle">
                    <input type="password" id="confirmPassword" placeholder=" " required>
                    <label for="confirmPassword">Confirm New Password</label>
                    <i class="ri-eye-line" id="toggleConfirmPassword"></i>
                </div>
                <div id="passwordMessage" class="account-message"></div>
                <div class="account-form-actions">
                    <button type="button" class="account-btn account-btn-secondary" id="cancelChangesPassword">Cancel</button>
                    <button type="submit" class="account-btn account-btn-primary">
                        <span class="btn-text">Save Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Enhanced Profile Dropdown with better animations
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    let dropdownTimeout;

    profileBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        clearTimeout(dropdownTimeout);
        profileDropdown.classList.toggle('active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!profileBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.classList.remove('active');
        }
    });

    // Hover effects for dropdown items
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            clearTimeout(dropdownTimeout);
        });

        item.addEventListener('click', (e) => {
            e.stopPropagation();
            // Add ripple effect
            const ripple = document.createElement('span');
            ripple.classList.add('ripple-effect');
            item.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);

            // Close dropdown after click
            setTimeout(() => {
                profileDropdown.classList.remove('active');
            }, 200);
        });
    });

    // Modal Animation and Tab Handling
    const modal = document.getElementById('accountSettingsModal');
    const accountSettingsBtn = document.getElementById('accountSettingsBtn');
    const closeBtn = document.querySelector('.account-modal-close');
    const cancelBtn = document.getElementById('cancelChanges');
    const cancelPasswordBtn = document.getElementById('cancelChangesPassword');

    // Show modal with enhanced animation
    function showModal() {
        modal.style.display = 'block';
        // Trigger reflow
        void modal.offsetWidth;
        modal.classList.add('visible');

        // Reset to first tab
        document.querySelectorAll('.account-tab').forEach((tab, index) => {
            if (index === 0) {
                tab.classList.add('account-tab-active');
            } else {
                tab.classList.remove('account-tab-active');
            }
        });

        document.querySelectorAll('.account-tab-content').forEach((content, index) => {
            if (index === 0) {
                content.classList.add('account-tab-content-active');
                content.style.opacity = '1';
                content.style.transform = 'translateY(0)';
            } else {
                content.classList.remove('account-tab-content-active');
                content.style.opacity = '0';
                content.style.transform = 'translateY(10px)';
            }
        });
    }

    // Hide modal with smooth animation
    function hideModal() {
        modal.classList.remove('visible');
        setTimeout(() => {
            modal.style.display = 'none';
            resetForms();
        }, 300);
    }

    accountSettingsBtn.addEventListener('click', function(e) {
        e.preventDefault();
        showModal();
        profileDropdown.classList.remove('active');
    });

    closeBtn.addEventListener('click', hideModal);
    cancelBtn.addEventListener('click', hideModal);
    cancelPasswordBtn.addEventListener('click', hideModal);

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            hideModal();
        }
    });

    // Enhanced Tab Switching with better animations
    const tabs = document.querySelectorAll('.account-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            if (tab.classList.contains('account-tab-active')) return;

            // Animate out current active tab
            const activeTab = document.querySelector('.account-tab-active');
            const activeContent = document.querySelector('.account-tab-content-active');

            activeTab.classList.remove('account-tab-active');
            activeContent.style.opacity = '0';
            activeContent.style.transform = 'translateY(10px)';

            setTimeout(() => {
                activeContent.classList.remove('account-tab-content-active');

                // Activate new tab
                tabs.forEach(t => t.classList.remove('account-tab-active'));
                tab.classList.add('account-tab-active');

                const tabId = tab.getAttribute('data-tab') + '-content';
                const newActiveContent = document.getElementById(tabId);
                newActiveContent.classList.add('account-tab-content-active');

                setTimeout(() => {
                    newActiveContent.style.opacity = '1';
                    newActiveContent.style.transform = 'translateY(0)';
                }, 50);
            }, 300);
        });
    });

    // Enhanced password toggle with better UX
    function setupPasswordToggle(inputId, iconId) {
        const toggleIcon = document.getElementById(iconId);
        const input = document.getElementById(inputId);

        toggleIcon.addEventListener('click', function(e) {
            e.preventDefault();
            togglePasswordVisibility(inputId, this);
        });

        // Add focus effect
        input.addEventListener('focus', function() {
            this.parentNode.querySelector('label').style.color = '#FF8C00';
        });

        input.addEventListener('blur', function() {
            this.parentNode.querySelector('label').style.color = '#555';
        });
    }

    setupPasswordToggle('currentPasswordUsername', 'toggleCurrentPasswordUsername');
    setupPasswordToggle('currentPassword', 'toggleCurrentPassword');
    setupPasswordToggle('newPassword', 'toggleNewPassword');
    setupPasswordToggle('confirmPassword', 'toggleConfirmPassword');

    function togglePasswordVisibility(inputId, icon) {
        const input = document.getElementById(inputId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('ri-eye-line', 'ri-eye-off-line');

            // Add temporary focus effect
            input.style.boxShadow = '0 0 0 3px rgba(255, 140, 0, 0.2)';
            setTimeout(() => {
                input.style.boxShadow = '';
            }, 500);
        } else {
            input.type = 'password';
            icon.classList.replace('ri-eye-off-line', 'ri-eye-line');
        }
    }

    // Enhanced form submission with loading states
    document.getElementById('usernameForm').addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm(this, 'usernameMessage');
    });

    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm(this, 'passwordMessage');
    });

    function submitForm(form, messageId) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const btnText = submitBtn.querySelector('.btn-text');
        const originalText = btnText.textContent;
        const messageElement = document.getElementById(messageId);

        // Clear previous messages
        messageElement.className = 'account-message';

        // Validate form
        let isValid = true;
        const inputs = form.querySelectorAll('input[required]');

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                shakeElement(input);
                input.style.borderColor = '#e53e3e';

                setTimeout(() => {
                    input.style.borderColor = '';
                }, 2000);
            }
        });

        if (!isValid) {
            messageElement.textContent = 'Please fill in all required fields.';
            messageElement.classList.add('account-message-error', 'visible');
            return;
        }

        // Password match validation for password form
        if (form.id === 'passwordForm') {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword !== confirmPassword) {
                messageElement.textContent = 'New passwords do not match.';
                messageElement.classList.add('account-message-error', 'visible');

                pulseElement(document.getElementById('newPassword'));
                pulseElement(document.getElementById('confirmPassword'));
                return;
            }
        }

        // Show loading state
        btnText.innerHTML = '<div class="spinner"></div> Processing...';
        submitBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
            // Success state
            submitBtn.disabled = false;
            btnText.textContent = 'Success!';
            submitBtn.style.backgroundColor = '#48bb78';

            messageElement.textContent = form.id === 'usernameForm' ?
                'Username successfully updated!' :
                'Password successfully changed!';
            messageElement.classList.add('account-message-success', 'visible');

            // Reset after delay
            setTimeout(() => {
                btnText.textContent = originalText;
                submitBtn.style.backgroundColor = '#FF8C00';
                hideModal();
            }, 1500);
        }, 1500);
    }

    // Animation helpers
    function shakeElement(element) {
        element.style.animation = 'shake 0.5s cubic-bezier(.36,.07,.19,.97) both';
        element.addEventListener('animationend', () => {
            element.style.animation = '';
        }, {
            once: true
        });
    }

    function pulseElement(element) {
        element.style.animation = 'pulse-border 0.5s cubic-bezier(.36,.07,.19,.97) both';
        element.addEventListener('animationend', () => {
            element.style.animation = '';
        }, {
            once: true
        });
    }

    // Reset forms with animations
    function resetForms() {
        // Reset username form
        document.getElementById('newUsername').value = '';
        document.getElementById('currentPasswordUsername').value = '';
        document.getElementById('usernameMessage').className = 'account-message';

        // Reset password form
        document.getElementById('currentPassword').value = '';
        document.getElementById('newPassword').value = '';
        document.getElementById('confirmPassword').value = '';
        document.getElementById('passwordMessage').className = 'account-message';

        // Reset all password fields and icons
        document.querySelectorAll('.account-password-toggle i').forEach(icon => {
            icon.classList.replace('ri-eye-off-line', 'ri-eye-line');
        });

        document.getElementById('currentPasswordUsername').type = 'password';
        document.getElementById('currentPassword').type = 'password';
        document.getElementById('newPassword').type = 'password';
        document.getElementById('confirmPassword').type = 'password';

        // Reset button styles
        document.querySelectorAll('.account-btn-primary').forEach(btn => {
            const btnText = btn.querySelector('.btn-text');
            if (btnText) {
                btnText.innerHTML = 'Save Changes';
            }
            btn.style.backgroundColor = '#FF8C00';
            btn.disabled = false;
        });
    }

    // Add ripple effect to buttons
    document.querySelectorAll('.account-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const rect = button.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
</script>