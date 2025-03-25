<script>
    // Enhanced Mobile Navigation JavaScript
    const mobileToggle = document.getElementById('mobileToggle');
    const mainNav = document.getElementById('mainNav');
    const navOverlay = document.getElementById('navOverlay');
    const dropdowns = document.querySelectorAll('.dropdown');

    // Smooth opening and closing animations
    function openMobileMenu() {
        mobileToggle.classList.add('active');
        mainNav.classList.add('active');
        navOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        mobileToggle.classList.remove('active');

        // Add exiting classes for smooth animation
        mainNav.classList.add('exiting');
        navOverlay.classList.add('exiting');

        // Remove classes after animation completes
        setTimeout(() => {
            mainNav.classList.remove('active');
            mainNav.classList.remove('exiting');
            navOverlay.classList.remove('active');
            navOverlay.classList.remove('exiting');
            document.body.style.overflow = '';
        }, 300);
    }

    mobileToggle.addEventListener('click', () => {
        if (mainNav.classList.contains('active')) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    });

    navOverlay.addEventListener('click', closeMobileMenu);

    // Enhanced dropdown handling with animations
    document.querySelectorAll('.dropdown-toggle').forEach(item => {
        item.addEventListener('click', (e) => {
            if (window.innerWidth <= 991) {
                e.preventDefault();
                const parent = item.parentElement;

                // Close all other dropdowns with animation
                dropdowns.forEach(dropdown => {
                    if (dropdown !== parent && dropdown.classList.contains('active')) {
                        dropdown.classList.remove('active');
                    }
                });

                // Toggle current dropdown with animation
                parent.classList.toggle('active');
            }
        });
    });

    // Close mobile menu when clicking a non-dropdown link
    document.querySelectorAll('.nav-link:not(.dropdown-toggle)').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 991) {
                closeMobileMenu();
            }
        });
    });

    // Improved resize handling
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (window.innerWidth > 991) {
                // Reset mobile menu when window is resized to desktop
                mobileToggle.classList.remove('active');
                mainNav.classList.remove('active');
                navOverlay.classList.remove('active');
                document.body.style.overflow = '';

                // Reset all opened dropdowns
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }
        }, 100);
    });
</script>