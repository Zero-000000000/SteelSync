<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    @import url('https://fonts.cdnfonts.com/css/calluna');
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif !important;
        line-height: 1.6 !important;
        color: #1A1A1A !important;
    }

    .container {
        margin: 0 auto !important;
        padding: 0 20px !important;
        width: 100% !important;
        max-width: 1300px !important;
    }

    /* Header & Navigation Styles */
    .header {
        background-color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        width: 100%;
        z-index: 1001 !important;
    }

    .nav-container {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        height: 70px !important;
    }

    .logo {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        font-size: 22px !important;
        color: #1A1A1A !important;
        text-decoration: none !important;
        font-family: 'Calluna', serif !important;
        font-weight: 400 !important;
        letter-spacing: 0.5px !important;
    }

    .logo i {
        color: #FF6B00 !important;
        font-size: 24px !important;
    }


    .nav-item.dropdown {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #ffffff;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        border-radius: 10px;
        min-width: 250px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 1002;
        padding: 10px;
        display: block !important;
    }

    .nav-item.dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        text-decoration: none;
        color: #333333;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin-bottom: 2px;
        white-space: nowrap;
    }

    .dropdown-item:hover {
        background-color: #f4f4f4;
        color: #FF6B00 !important;
        /* Force orange text on hover */
    }

    /* This ensures the text stays orange on hover even if other styles try to override it */
    .dropdown-item:hover .dropdown-item-text {
        color: #FF6B00 !important;
    }

    .dropdown-item i {
        width: 20px;
        margin-right: 12px;
        color: #FF6B00;
        transition: all 0.3s ease;
    }


    .nav {
        display: flex !important;
        align-items: center !important;
        gap: 5px !important;
    }

    .nav-item {
        list-style: none !important;
        position: relative !important;
    }

    .nav-link {
        display: block !important;
        padding: 25px 16px !important;
        text-decoration: none !important;
        color: #333333 !important;
        font-weight: 500 !important;
        transition: all 0.3s ease;
        position: relative !important;
    }

    .nav-link:hover {
        color: #FF6B00 !important;
    }

    .nav-link.active {
        color: #FF6B00 !important;
    }

    .nav-link.active:after {
        content: '';
        position: absolute !important;
        bottom: 15px;
        left: 16px;
        right: 16px;
        height: 3px;
        background-color: #FF6B00 !important;
        border-radius: 2px !important;
    }

    .dropdown-toggle:after {
        font-weight: 900 !important;
        margin-left: 5px !important;
        transition: all 0.3s ease !important;
    }



    .dropdown-menu {
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        background-color: #ffffff !important;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15) !important;
        border-radius: 10px !important;
        min-width: 250px !important;
        opacity: 0 !important;
        visibility: hidden !important;
        transform: translateY(10px) !important;
        transition: all 0.3s ease !important;
        z-index: 10 !important;
        padding: 10px !important;
    }

    .nav-item:hover .dropdown-menu {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
    }

    .dropdown-item {
        display: flex !important;
        align-items: center !important;
        padding: 12px 15px !important;
        text-decoration: none;
        color: #333333;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin-bottom: 2px;
    }

    .dropdown-item:hover {
        background-color: #f4f4f4;
        color: #FF6B00;
    }

    .dropdown-item i {
        width: 20px !important;
        margin-right: 12px !important;
        color: #FF6B00 !important;
    }

    .mobile-toggle {
        display: none !important;
        background: none !important;
        border: none !important;
        cursor: pointer !important;
        padding: 10px !important;
    }

    .mobile-toggle span {
        display: block !important;
        width: 25px !important;
        height: 3px !important;
        background-color: #333333 !important;
        margin: 5px 0 !important;
        border-radius: 3px !important;
        transition: all 0.3s ease !important;
    }

    /* Button style */
    .btn {
        background-color: #FF6B00 !important;
        color: #ffffff !important;
        border: none !important;
        padding: 10px 18px !important;
        border-radius: 50px !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        box-shadow: 0 4px 12px rgba(255, 107, 0, 0.2) !important;
        margin-left: 15px !important;
        height: 40px;

    }

    .btn:hover {
        background-color: #ff8324 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 15px rgba(255, 107, 0, 0.35);
    }

    .btn i {
        font-size: 14px !important;
    }

    /* Footer Styles */
    .footer {
        background-color: #292929;
        color: #ffffff;
        padding: 60px 0 30px;
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 40px;
        margin-bottom: 40px;
    }

    .footer-column h3 {
        font-size: 1.2rem;
        margin-bottom: 20px;
        color: #ffffff;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-column h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 3px;
        background-color: #FF6B00;
    }

    .footer-links {
        list-style: none;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        color: #bbb;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .footer-links a:hover {
        color: #FF6B00;
    }

    .footer-contact-info {
        list-style: none;
    }

    .footer-contact-info li {
        margin-bottom: 15px;
        display: flex;
        align-items: flex-start;
    }

    .footer-contact-info i {
        margin-right: 10px;
        color: #FF6B00;
    }

    .social-links {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .social-links a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        color: #fff;
        transition: all 0.3s ease;
    }

    .social-links a:hover {
        background-color: #FF6B00;
        transform: translateY(-3px);
    }

    .footer-bottom {
        text-align: center;
        padding-top: 30px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-bottom p {
        color: #bbb;
        font-size: 0.9rem;
    }

    /* Main content placeholder - just to create space between header and footer */
    .main-content {
        min-height: 70vh;
        padding: 50px 0;
    }

    /* Responsive styles */
    @media (max-width: 991px) {

        /* Mobile toggle button styling */
        .mobile-toggle {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 44px;
            height: 44px;
            background-color: rgba(255, 107, 0, 0.1);
            border-radius: 50%;
            z-index: 1001;
            transition: all 0.3s ease;
        }

        .mobile-toggle:hover {
            background-color: rgba(255, 107, 0, 0.2);
        }

        .mobile-toggle span {
            width: 20px;
            height: 2px;
            margin: 2.5px 0;
            border-radius: 2px;
            background-color: #333333;
            transition: transform 0.3s ease, opacity 0.2s ease;
        }

        .mobile-toggle.active {
            background-color: rgba(255, 107, 0, 0.15);
        }

        .mobile-toggle.active span {
            background-color: #FF6B00;
        }

        /* Improved animation for toggle button */
        .mobile-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .mobile-toggle.active span:nth-child(2) {
            opacity: 0;
            transform: translateX(-10px);
        }

        .mobile-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }


        /* Main navigation styling */
        .nav {
            position: fixed;
            top: 0;
            right: -100%;
            width: 85%;
            max-width: 320px;
            height: 100vh;
            background-color: #ffffff;
            flex-direction: column;
            align-items: flex-start;
            gap: 0;
            padding: 80px 20px 30px;
            transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            overflow-y: auto;
            border-radius: 20px 0 0 20px;
        }

        .nav.active {
            right: 0;
            animation: slideIn 0.4s forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(20px);
            }

            to {
                transform: translateX(0);
            }
        }

        .nav:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            border-radius: 20px 0 0 0;
            z-index: -1;
        }

        /* Logo in mobile menu */
        .nav:after {
            content: 'Intellitech System';
            position: absolute;
            top: 22px;
            left: 25px;
            font-family: 'Calluna', serif;
            font-size: 20px;
            font-weight: 400;
            color: #1A1A1A;
        }

        /* Navigation items styling */
        .nav-item {
            width: 100%;
            margin-bottom: 8px;
        }

        .nav-link {
            padding: 12px 16px;
            border-radius: 12px;
            width: 100%;
            display: block;
            border: none;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            background-color: #f4f4f4;
            transform: translateX(3px);
        }

        .nav-link.active {
            background-color: rgba(255, 107, 0, 0.12);
            color: #FF6B00;
            font-weight: 600;
        }

        .nav-link.active:after {
            display: none;
        }

        .dropdown-toggle:after {
            float: right !important;
            margin-top: 5px !important;
        }

        .dropdown-menu {
            z-index: 1000;
            position: static;
            box-shadow: none;
            opacity: 1;
            visibility: visible;
            transform: none;
            display: none;
            padding: 5px 0 5px 15px;
            width: 100%;
            background-color: transparent;
            margin-top: 5px;
            margin-bottom: 5px;
            border-left: 2px solid #FF6B00;
            margin-left: 16px;
        }

        .nav-item.active .dropdown-menu {
            display: block;
            animation: fadeInDown 0.3s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: 10px 14px;
            width: 100%;
            border-radius: 10px;
            margin-bottom: 4px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f4f4f4;
            transform: translateX(3px);
        }

        .dropdown-item i {
            width: 18px;
            margin-right: 10px;
            color: #FF6B00;
            font-size: 14px;
        }

        /* Overlay styling */
        .nav-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
            z-index: 999;
        }

        .nav-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Button styling */
        .nav-item:last-child {
            margin-top: 15px;
            width: 100%;
        }

        .btn {
            margin-left: 0;
            width: 100%;
            justify-content: center;
            padding: 13px 20px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.25);
            transition: all 0.3s ease;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn:hover {
            background-color: #ff8324;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 107, 0, 0.35);
        }

        /* Add smooth exit animation */
        .nav.exiting {
            right: -100%;
            transition: right 0.3s ease-in-out;
        }

        .nav-overlay.exiting {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        /* Footer responsive adjustments */
        .footer-content {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .footer {
            padding: 40px 0 20px;
        }
    }
</style>