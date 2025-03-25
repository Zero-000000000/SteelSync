<?php include 'includes/style.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intellitech Systems</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #ff6600;
            --primary-dark: #e55c00;
            --primary-light: #ff8533;
            --primary-lightest: #fff0e6;
            --secondary-color: #144e8c;
            --light-gray: #f5f5f5;
            --dark-gray: #333333;
            --medium-gray: #4d4d4d;
            --border-color: #e0e0e0;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }



        * {
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Arial', sans-serif;
            background-color: var(--bg-light);
            line-height: 1.6;
            color: var(--text-dark);
        }

        /* Accessibility focus styles
           a:focus,
        button:focus,
        input:focus,
        select:focus,
        textarea:focus,
        [tabindex]:focus {
            outline: 3px solid var(--primary-light);
            outline-offset: 2px;
        }
             */


        /* Skip to content link for accessibility */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 0;

            color: white;
            padding: 8px;
            z-index: 10000;
            transition: top 0.3s;
        }

        .skip-link:focus {
            top: 0;
        }

        /* Main content styles */
        .main-content {
            padding: 20px;
            margin-top: 0;
        }



        /* About Section Styles */
        .about-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 50px;
            padding-bottom: 30px;
            padding-left: 30px;

        }

        .about-content {
            padding-top: 30px;
            flex: 1;
            padding-right: 40px;
        }

        .about-heading {
            margin-bottom: 20px;
            font-size: 28px;
            position: relative;
            padding-bottom: 10px;
            color: var(--dark-gray);
        }

        .about-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--primary-color);
        }

        .about-heading strong {
            font-style: italic;
            color: var(--primary-color);
        }

        .company-description {
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 15px;
            color: #555;
        }

        .services-description {
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 25px;
            color: #555;
        }

        .services-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
        }

        .service-tag {
            background-color: var(--primary-lightest);
            color: var(--primary-dark);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .service-tag i {
            font-size: 12px;
        }

        .logo-container {
            flex: 0 0 40%;
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            border-radius: var(--border-radius);
            background-color: #fff;
            box-shadow: var(--box-shadow);
        }

        .logo {
            max-width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.02);
        }

        .btn-learn-more {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 3px 8px rgba(255, 102, 0, 0.3);
        }

        .btn-learn-more:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 102, 0, 0.4);
        }

        /* Section Divider */
        .section-divider {
            margin: 40px 0;
            text-align: center;
            position: relative;
        }

        .section-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: var(--border-color);
            z-index: 1;
        }

        .section-divider span {
            position: relative;
            z-index: 2;
            background-color: white;
            padding: 0 20px;
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
        }

        /* Documents Section Styles */
        .documents-section {
            display: flex;
            justify-content: space-between;
            gap: 30px;
        }

        .documents-heading {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .documents-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--primary-color);
        }

        .document-listing {
            flex: 1;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 25px;
            border: 1px solid var(--border-color);
        }

        .document-items {
            list-style: none;
        }

        .document-item {
            background-color: var(--light-gray);
            margin-bottom: 10px;
            padding: 14px 20px;
            font-size: 15px;
            color: var(--dark-gray);
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: var(--transition);
            border-left: 3px solid transparent;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .document-item:hover {
            background-color: #e9ecef;
            transform: translateX(5px);
            border-left: 3px solid var(--primary-color);
        }

        .document-item.active {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            box-shadow: 0 3px 8px rgba(255, 102, 0, 0.3);
            border-left: 3px solid var(--primary-dark);
        }

        .document-item.active:hover {
            background-color: var(--primary-dark);
        }

        .document-item span {
            flex-grow: 1;
        }

        .document-item::after {
            content: "\f054";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 12px;
            margin-left: 10px;
        }

        .document-preview {
            flex: 1;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 25px;
            background-color: white;
            border: 1px solid var(--border-color);
        }

        .preview-heading {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            color: var(--primary-color);
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .preview-content {
            background-color: var(--light-gray);
            height: 500px;
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
            border: 1px solid var(--border-color);
        }

        .preview-content:hover {
            box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.15);
        }

        .preview-content img {
            max-width: 100%;
            max-height: 100%;
            transition: transform 0.3s ease;
            display: block;
        }

        .preview-content img:hover {
            transform: scale(1.02);
        }

        .preview-button-container {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .preview-button {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 3px 8px rgba(255, 102, 0, 0.3);
        }

        .preview-button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 102, 0, 0.4);
        }

        .download-button {
            background-color: var(--secondary-color);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 3px 8px rgba(20, 78, 140, 0.3);
        }

        .download-button:hover {
            background-color: #0d3b6b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(20, 78, 140, 0.4);
        }



        /* Loading spinner */
        .loading-spinner {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 5px solid var(--light-gray);
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .document-info {
            margin-top: 15px;
            margin-bottom: 15px;
            background-color: var(--primary-lightest);
            border-radius: var(--border-radius);
            padding: 15px;
            font-size: 14px;
            color: var(--medium-gray);
            border-left: 3px solid var(--primary-color);
        }

        .document-info p {
            margin-bottom: 5px;
        }

        .document-info strong {
            color: var(--primary-dark);
        }

        .section {
            margin-bottom: 40px;
        }

        h1 {
            color: #FF6B35;
            font-size: 32px;
            margin-bottom: 20px;
            text-align: center;
        }

        .content {
            margin-bottom: 15px;
            padding-left: 150px;
            padding-right: 150px;
            text-align: center;
        }

        /* Responsive design */
        @media (max-width: 992px) {
            .container {
                padding: 20px;
            }

            .about-section {
                flex-direction: column;
                text-align: center;
            }

            .about-content {
                padding-right: 0;
                margin-bottom: 30px;
            }

            .about-heading::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .services-list {
                justify-content: center;
            }

            .logo-container {
                flex: 0 0 100%;
                max-width: 300px;
                margin: 0 auto;
            }

            .documents-section {
                flex-direction: column;
            }

            .document-listing,
            .document-preview {
                flex: 0 0 100%;
            }

            .document-listing {
                margin-bottom: 30px;
            }

            .documents-heading::after {
                left: 0;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }

            .container {
                padding: 15px;
            }

            .about-heading {
                font-size: 24px;
            }

            .company-description,
            .services-description {
                font-size: 15px;
            }

            .btn-learn-more {
                width: 100%;
                justify-content: center;
            }

            .documents-heading {
                font-size: 20px;
            }

            .document-item {
                padding: 12px 15px;
                font-size: 14px;
            }

            .preview-content {
                height: 250px;
            }

            .preview-button-container {
                flex-direction: column;
            }

            .preview-button,
            .download-button {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .about-heading {
                font-size: 22px;
            }

            .service-tag {
                font-size: 12px;
            }

            .preview-heading {
                font-size: 18px;
            }

            .preview-content {
                height: 200px;
            }

            .close-modal {
                top: 10px;
                right: 10px;
                width: 30px;
                height: 30px;
                font-size: 20px;
            }
        }
    </style>
</head>

<body>


    <div class="main-content" id="main-content">
        <div class="container">
            <div class="about-section">
                <div class="about-content">
                    <h2 class="about-heading">ABOUT <strong>Intellitech Systems</strong></h2>
                    <p class="company-description">
                        Intellitech Systems is a pioneering provider of cutting-edge security and automation solutions,
                        committed to enhancing safety and convenience for residential and commercial spaces.
                    </p>
                    <p class="services-description">
                        Our company specializes in a range of advanced technologies to make your home and business
                        smarter, safer, and more efficient.
                    </p>

                    <div class="services-list">
                        <span class="service-tag"><i class="fas fa-robot"></i> Gate Automation</span>
                        <span class="service-tag"><i class="fas fa-hammer"></i> Gate Fabrication</span>
                        <span class="service-tag"><i class="fas fa-warehouse"></i> Sectional Garage Door</span>
                        <span class="service-tag"><i class="fas fa-door-open"></i> Roll Up Door</span>
                        <span class="service-tag"><i class="fas fa-bolt"></i> Smart Electric Fence</span>
                        <span class="service-tag"><i class="fas fa-home"></i> Smart Curtain</span>
                    </div>

                    <a href="#" class="btn-learn-more">
                        LEARN MORE <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="logo-container">
                    <img src="/images/Group 70.png" alt="Intellitech Systems Logo" class="logo">
                </div>
            </div>
            <div class="section">
                <h1>Mission</h1>
                <p class="content">
                    Our mission at Intellitech Systems is to empower individuals
                    and businesses with state-of-the-art security and automation solutions.
                    We aim to provide peace of mind by leveraging innovative technologies
                    that enhances safety, efficiency, and convenience in everyday environments.
                </p>
            </div>

            <div class="section">
                <h1>Vision</h1>
                <p class="content">
                    We envision a future where security and automation seamlessly integrate
                    into people's lives, creating safer and more connected communities.
                    M&A Technology and Fabricmarks strives to be a leader in the industry,
                    continuously innovating and adapting to the evolving needs of our customers.
                    Through our commitment to excellence and customer satisfaction,
                    we aspire to set new benchmarks is security and automation solutions
                    regionally and beyond.
                </p>
            </div>
            <div class="section-divider">
                <span>LEGAL DOCUMENTS</span>
            </div>

            <div class="documents-section">
                <div class="document-listing">
                    <h3 class="documents-heading">Company Documents</h3>
                    <ul class="document-items">
                        <li class="document-item active" data-document="environmental-permit" tabindex="0" role="button"
                            aria-pressed="true"><span>1. ENVIRONMENTAL MANAGEMENT PERMIT</span></li>
                        <li class="document-item" data-document="business-name" tabindex="0" role="button"
                            aria-pressed="false"><span>2. CERTIFICATE OF BUSINESS NAME REGISTRATION</span></li>
                        <li class="document-item" data-document="authority-print" tabindex="0" role="button"
                            aria-pressed="false"><span>3. AUTHORITY TO PRINT</span></li>
                        <li class="document-item" data-document="registration" tabindex="0" role="button"
                            aria-pressed="false"><span>4. CERTIFICATE OF REGISTRATION</span></li>
                        <li class="document-item" data-document="business-permit" tabindex="0" role="button"
                            aria-pressed="false"><span>5. BUSINESS PERMIT AND LICENSING OFFICE</span></li>
                        <li class="document-item" data-document="sanitary-permit" tabindex="0" role="button"
                            aria-pressed="false"><span>6. SANITARY PERMIT TO OPERATE</span></li>
                    </ul>
                </div>
                <div class="document-preview">
                    <h4 class="preview-heading" id="document-title">Environmental Management Permit</h4>
                    <div class="preview-content">
                        <div class="loading-spinner" id="loading-spinner"></div>
                        <img src="environmental-permit.jpg" alt="Environmental Management Permit" id="preview-image">
                    </div>

                    <div class="document-info">
                        <p><strong>Document Type:</strong> <span id="doc-type">Environmental Permit</span></p>
                        <p><strong>Issued Date:</strong> <span id="doc-date">January 15, 2025</span></p>
                        <p><strong>Valid Until:</strong> <span id="doc-validity">January 15, 2026</span></p>
                    </div>

                    <div class="preview-button-container">
                        <a href="#" class="preview-button" id="view-document">
                            <i class="fas fa-search-plus"></i> VIEW DOCUMENT
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

    <?php include "includes/main.php"; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const documentItems = document.querySelectorAll('.document-item');
            const previewHeading = document.querySelector('.preview-heading');
            const previewImage = document.getElementById('preview-image');
            const modal = document.getElementById('document-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalImage = document.getElementById('modal-image');
            const viewButton = document.getElementById('view-document');
            const closeModal = document.getElementById('close-modal');
            const loadingSpinner = document.getElementById('loading-spinner');
            const zoomIn = document.getElementById('zoom-in');
            const zoomOut = document.getElementById('zoom-out');
            const zoomReset = document.getElementById('zoom-reset');
            const docType = document.getElementById('doc-type');
            const docDate = document.getElementById('doc-date');
            const docValidity = document.getElementById('doc-validity');

            // Current zoom level
            let currentZoom = 1;

            // Document data (in a real application, this would come from a database)
            const documents = {
                'environmental-permit': {
                    title: 'Environmental Management Permit',
                    image: '/images/image.png',
                    type: 'Environmental Permit',
                    date: 'January 15, 2025',
                    validity: 'January 15, 2026'
                },
                'business-name': {
                    title: 'Certificate of Business Name Registration',
                    image: '/images/image.png',
                    type: 'Business Registration',
                    date: 'December 3, 2024',
                    validity: 'December 3, 2029'
                },
                'authority-print': {
                    title: 'Authority to Print',
                    image: '/images/image.png',
                    type: 'Printing Authority',
                    date: 'November 12, 2024',
                    validity: 'November 12, 2025'
                },
                'registration': {
                    title: 'Certificate of Registration',
                    image: '/images/image.png',
                    type: 'Business Registration',
                    date: 'October 24, 2024',
                    validity: 'Permanent'
                },
                'business-permit': {
                    title: 'Business Permit and Licensing Office',
                    image: '/images/image.png',
                    type: 'Business Permit',
                    date: 'January 2, 2025',
                    validity: 'December 31, 2025'
                },
                'sanitary-permit': {
                    title: 'Sanitary Permit to Operate',
                    image: '/images/image.png',
                    type: 'Health and Safety',
                    date: 'February 8, 2025',
                    validity: 'February 8, 2026'
                }
            };

            // Function to update document preview
            function updatePreview(docId) {
                const document = documents[docId];

                // Show loading spinner
                loadingSpinner.style.display = 'block';
                previewImage.style.opacity = '0';

                // Update preview with animation
                previewHeading.textContent = document.title;
                docType.textContent = document.type;
                docDate.textContent = document.date;
                docValidity.textContent = document.validity;

                // Simulate loading delay for better UX
                setTimeout(() => {
                    previewImage.src = document.image;
                    previewImage.alt = document.title;

                    // Hide loading spinner when image is loaded
                    previewImage.onload = function() {
                        loadingSpinner.style.display = 'none';
                        previewImage.style.opacity = '1';
                    };
                }, 400);
            }

            // Handle document item clicks
            documentItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove active class and aria-pressed from all items
                    documentItems.forEach(el => {
                        el.classList.remove('active');
                        el.setAttribute('aria-pressed', 'false');
                    });

                    // Add active class to clicked item
                    this.classList.add('active');
                    this.setAttribute('aria-pressed', 'true');

                    // Get document data and update preview
                    const docId = this.getAttribute('data-document');
                    updatePreview(docId);
                });

                // Keyboard accessibility
                item.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });


        });
    </script>
</body>

</html>