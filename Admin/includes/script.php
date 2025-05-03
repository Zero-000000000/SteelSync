<script>
    let menu = document.querySelector('.menu')
    let sidebar = document.querySelector('.sidebar')
    let mainContent = document.querySelector('.main--content')
    menu.onclick = function() {
        sidebar.classList.toggle('active')
        mainContent.classList.toggle('active')
    }

    // Add this to your main.js file or include it in a <script> tag in your HTML
    document.addEventListener("DOMContentLoaded", function() {
        const dropdownBtn = document.querySelector(".dropdown-btn");

        dropdownBtn.addEventListener("click", function() {
            this.classList.toggle("active");
            const subMenu = this.nextElementSibling;
            if (subMenu.style.display === "block") {
                subMenu.style.display = "none";
            } else {
                subMenu.style.display = "block";
            }
        });
    });

    // Add styles for ripple effect
    document.head.insertAdjacentHTML('beforeend', `
    <style>
        .ripple {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.4);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }
        
        .account-btn-primary .ripple {
            background-color: rgba(255, 255, 255, 0.4);
        }
        
        .account-btn-secondary .ripple {
            background-color: rgba(0, 0, 0, 0.1);
        }
        
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .dropdown-item .ripple-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 140, 0, 0.1), transparent);
            animation: ripple-effect 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-effect {
            to {
                left: 100%;
            }
        }
    </style>
    `);
</script>