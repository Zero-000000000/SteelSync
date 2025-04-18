<?php include 'includes/style.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intellitech Systems</title>
    <link href="css/about.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>


    <div class="main-content" id="main-content">
        <div class="container">
            <div class="about-section">
                <div class="about-content">
                    <h2 class="about-heading">ABOUT <strong>Intellitech Systems</strong></h2>
                    <p class="company-description">
                        Intellitech Systems was founded on March 22, 2022, by engineer and businessman Richard Bartolome, who
                        brought his extensive experience in gate fabrication and automation to the company. Officially registered on
                        April 27, 2022, the company was established with a vision to exceed previous industry standards through innovation and quality service.
                    </p>
                    <p class="services-description">
                        Under Mr. Bartolome’s leadership, Intellitech quickly earned a reputation for excellence, combining advanced technology
                        with strong customer service. Despite challenges, the company has grown significantly and continues to be a trusted name
                        in the industry, committed to delivering modern, reliable solutions.
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
                    <img src="images/Group 70.png" alt="Intellitech Systems Logo" class="logo">
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
                        <img src="images/image.png" alt="Environmental Management Permit" id="preview-image">
                    </div>

                    <div class="document-info">
                        <p><strong>Document Type:</strong> <span id="doc-type">Environmental Permit</span></p>
                        <p><strong>Issued Date:</strong> <span id="doc-date">January 15, 2025</span></p>
                        <p><strong>Valid Until:</strong> <span id="doc-validity">January 15, 2026</span></p>
                    </div>

                    <div class="preview-button-container">
                        <a href="images/image.png" target="_blank" class="preview-button" id="view-document">
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


            let currentZoom = 1;

            // demo need dataa base
            const documents = {
                'environmental-permit': {
                    title: 'Environmental Management Permit',
                    image: 'images/image.png',
                    type: 'Environmental Permit',
                    date: 'January 15, 2025',
                    validity: 'January 15, 2026'
                },
                'business-name': {
                    title: 'Certificate of Business Name Registration',
                    image: 'images/image.png',
                    type: 'Business Registration',
                    date: 'December 3, 2024',
                    validity: 'December 3, 2029'
                },
                'authority-print': {
                    title: 'Authority to Print',
                    image: 'images/image.png',
                    type: 'Printing Authority',
                    date: 'November 12, 2024',
                    validity: 'November 12, 2025'
                },
                'registration': {
                    title: 'Certificate of Registration',
                    image: 'images/image.png',
                    type: 'Business Registration',
                    date: 'October 24, 2024',
                    validity: 'Permanent'
                },
                'business-permit': {
                    title: 'Business Permit and Licensing Office',
                    image: 'images/image.png',
                    type: 'Business Permit',
                    date: 'January 2, 2025',
                    validity: 'December 31, 2025'
                },
                'sanitary-permit': {
                    title: 'Sanitary Permit to Operate',
                    image: 'images/image.png',
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