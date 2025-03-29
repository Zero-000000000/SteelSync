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
</script>