<script>
document.addEventListener("DOMContentLoaded", function () {
    let dropdownButtons = document.querySelectorAll(".dropdown-btn");

    dropdownButtons.forEach(function (btn) {
        btn.addEventListener("click", function () {
            this.classList.toggle("active");
            let subMenu = this.nextElementSibling;

            if (subMenu.style.display === "block") {
                subMenu.style.display = "none";
            } else {
                subMenu.style.display = "block";
            }
        });
    });
});
</script>