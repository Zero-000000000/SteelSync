<?php include 'includes/style.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intellitech Systems</title>
    <link href="css/services.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="services-container">
        <div class="services-header">
            <h1>Our <span>Services</span></h1>
            <p>Innovative Security and Automation Solutions</p>
        </div>
        <div class="services-grid" id="servicesGrid"></div>
    </div>

    <script>
        const services = [{
                image: 'images/gate.jpeg',
                icon: 'fas fa-robot',
                title: 'Gate Automation',
                description: 'Advanced automated gate systems with smart access control and seamless integration.',
                price: 'Price Starts at  ₱90,000',
                link: 'services/gate automation.php'
            },
            {
                image: 'images/metal.jpg',
                icon: 'fas fa-hammer',
                title: 'Gate Fabrication',
                description: 'Custom-designed gates crafted with precision and aesthetic appeal.',
                price: 'Price Starts at  ₱220,000',
                link: 'services/gate_fabrication.php'
            },
            {
                image: 'images/door.jpg',
                icon: 'fas fa-warehouse',
                title: 'Sectional Garage Door',
                description: 'Modern garage doors offering superior insulation and security.',
                price: 'Price Starts at  ₱230,000',
                link: 'services/garage_door.php'
            },
            {
                image: 'images/roll1.jpg',
                icon: 'fas fa-door-open',
                title: 'Roll Up Door',
                description: 'High-performance doors for commercial and industrial applications.',
                price: 'Price Starts at  ₱220,000',
                link: 'services/roll_up_door.php'
            },
            {
                image: 'images/electric.jpeg',
                icon: 'fas fa-bolt',
                title: 'Smart Electric Fence',
                description: 'Cutting-edge perimeter protection with advanced monitoring systems.',
                price: 'Price Starts at ₱70,000',
                link: 'services/electric_fence.php'
            },
            {
                image: 'images/smart.jpg',
                icon: 'fas fa-home',
                title: 'Smart Curtain',
                description: 'Automated curtain systems with intelligent home integration.',
                price: 'Price Starts at  ₱70,000',
                link: 'services/smart_curtain.php'
            }
        ];

        function renderServices() {
            const servicesGrid = document.getElementById('servicesGrid');
            servicesGrid.innerHTML = '';

            services.forEach(service => {
                const serviceCard = document.createElement('div');
                serviceCard.classList.add('service-card');
                serviceCard.innerHTML = `
            <div class="service-image" style="background-image: url('${service.image}')">
                <div class="service-icon">
                    <i class="${service.icon}"></i>
                </div>
            </div>
            <div class="service-content">
                <div class="service-header">
                    <h3 class="service-title">${service.title}</h3>
                    <span class="service-explore">Explore</span>
                </div>
                <p class="service-description">${service.description}</p>
                <div class="service-price">
                    <i class="fa-solid fa-tag"></i> ${service.price}
                </div>
            </div>
        `;
                serviceCard.addEventListener('click', () => {
                    window.location.href = service.link;
                });
                serviceCard.style.cursor = 'pointer';
                servicesGrid.appendChild(serviceCard);
            });
        }
        document.addEventListener('DOMContentLoaded', renderServices);
    </script>
    <?php include 'includes/footer.php'; ?>

    <?php include "includes/main.php"; ?>
</body>

</html>