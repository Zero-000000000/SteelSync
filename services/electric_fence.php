<?php include '../includes/style.php'; ?>
<?php include '../includes/navbar.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metal and Stainless Steel Fabrication</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #ff6600;
            --secondary-color: #e55c00;
            --accent-color: #ff9800;
            --text-color: #333;
            --light-text: #fff;
            --light-bg: #f5f5f5;
            --dark-bg: #1a2639;
            --border-radius: 8px;
            --box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {

            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
        }

        h1,
        h2,
        h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }



        /* Hero Section */
        .hero {
            padding: 80px 0 40px;
            background-color: #fff;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 15px;
        }

        .hero h1::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 70px;
            height: 4px;
            background-color: var(--accent-color);
        }

        .hero-content {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .hero-image {
            flex: 1;
            max-width: 60%;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            position: relative;
        }

        .hero-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.3));
            z-index: 1;
        }

        .hero-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.5s ease;
        }

        .hero-image:hover img {
            transform: scale(1.03);
        }

        .hero-text {
            flex: 1;
            padding: 20px;
        }

        .hero-text h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: var(--secondary-color);
        }

        .hero-text p {
            font-size: 1.1rem;
            margin-bottom: 20px;
            line-height: 1.8;
        }


        /* More Info Section */
        .more-info {
            padding: 60px 0;
            position: relative;
        }

        .section-divider {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .section-divider hr {
            flex: 1;
            height: 1px;
            background-color: #ddd;
            border: none;
        }

        .section-divider span {
            padding: 0 20px;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            background-color: var(--light-bg);
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background-color: #fff;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--accent-color);
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: var(--secondary-color);
        }

        /* Fabrication Section */
        .fabrication {
            background-image: url('../images/electric1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--light-text);
            padding: 120px 0;
            position: relative;
            margin-bottom: 50px;
            text-align: center;
        }

        .fabrication::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.85));
        }

        .fabrication-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .fabrication h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .fabrication p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .fabrication a {
            color: var(--accent-color);
            text-decoration: underline;
            font-weight: 500;
            transition: var(--transition);
        }

        .fabrication a:hover {
            color: #ffc107;
        }




        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-content {
                flex-direction: column;
            }

            .hero-image {
                max-width: 100%;
                margin-bottom: 30px;
            }

            .work-section {
                flex-direction: column;
            }

            .work-image {
                max-width: 100%;
                margin-bottom: 30px;
            }
        }

        @media (max-width: 768px) {
            .navbar-nav {
                display: none;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .types h2,
            .fabrication h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>


    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Smart Electric Fence</h1>
            <div class="hero-content">
                <div class="hero-image">
                    <img src="../images/electric1.jpg" alt="Metal fabrication workshop with worker welding">
                </div>
                <div class="hero-text">
                    <h2>At Intellitech Systems</h2>
                    <p>We offers advanced A smart fence refers to an advanced, technology-driven barrier system designed to detect, deter, and delay unauthorized intrusions or potential threats.
                    </p>
                    <p>Our team of experts has years of experience in metal fabrication, delivering custom solutions
                        that meet your specific needs and exceed your expectations.</p>

                </div>
            </div>
        </div>
    </section>

    <!-- More Info Section -->
    <section class="more-info" id="services">
        <div class="container">
            <div class="section-divider">
                <hr>
                <span>MORE INFO</span>
                <hr>
            </div>

            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Quality Assurance</h3>
                    <p>Our rigorous quality control process ensures that every project meets or exceeds industry
                        standards, providing you with reliable and durable solutions.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="feature-title">Expert Craftsmanship</h3>
                    <p>Our team consists of highly skilled professionals with extensive knowledge in home
                        automation, home security, and fabrication, ensuring top-quality results.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3 class="feature-title">Custom Solutions</h3>
                    <p>We prioritize personalized solutions, tailoring our services to meet your specific requirements, style, and
                        budget.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fabrication Section -->
    <section class="fabrication">
        <div class="fabrication-content">
            <h2>SMART ELECTRIC FENCE</h2>
            <p>Intellitech Systems advanced equipped with various sensors, such as motion detectors, vibration sensors, infrared detectors, and video surveillance cameras. These sensors can detect any breach attempts, like climbing, cutting, or lifting the fence, and can also help track intruders' movement in real-time.</p>
            <p>For more info kindly visit our page: <a
                    href="https://www.facebook.com/IntellitechSystemOPC">https://www.facebook.com/IntellitechSystemOPC</a>
            </p>

        </div>
    </section>


    <?php include '../includes/footer.php'; ?>

    <?php include "../includes/main.php"; ?>

</body>

</html>