<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Ensure $current_page is defined
$current_page = basename($_SERVER['PHP_SELF']);
?>

<section class="main">
    <aside class="sidebar">
        <ul class="sidebar--items">
            <li>
                <a href="index.php" <?php echo ($current_page == 'index.php') ? 'id="active--link"' : ''; ?>>
                    <span class="icon icon-1"><i class="fas fa-th-large"></i></span>
                    <span class="sidebar--item">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="Apointment.php" <?php echo ($current_page == 'Apointment.php') ? 'id="active--link"' : ''; ?>>
                    <span class="icon icon-1"><i class="fas fa-th-large"></i></span>
                    <span class="sidebar--item">Apointment</span>
                </a>
            </li>

            <!-- Inventory Dropdown -->
            <li>
                <button class="dropdown-btn <?php echo (in_array($current_page, ['raw-material.php', 'fix-assets.php'])) ? 'active' : ''; ?>">
                    <span class="icon icon-2"><i class="fas fa-warehouse"></i></span>
                    <span class="sidebar--item">Inventory</span>
                </button>
                <ul class="sub-menu">
                    <li>
                        <a href="raw-material.php" <?php echo ($current_page == 'raw-material.php') ? 'id="active--link"' : ''; ?>>
                            <span class="icon icon-3"><i class="fas fa-boxes"></i></span>
                            <span class="sidebar--item">Raw Material</span>
                        </a>
                    </li>
                    <li>
                        <a href="fix-assets.php" <?php echo ($current_page == 'fix-assets.php') ? 'id="active--link"' : ''; ?>>
                            <span class="icon icon-4"><i class="fas fa-toolbox"></i></span>
                            <span class="sidebar--item">Fix Assets</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Other sidebar items -->
            <li>
                <a href="pointofsale.php" <?php echo ($current_page == 'pointofsale.php') ? 'id="active--link"' : ''; ?>>
                    <span class="icon icon-4"><i class="fas fa-calendar-check"></i></span>
                    <span class="sidebar--item">Point of Sale</span>
                </a>
            </li>



        </ul>
        <ul class="sidebar--bottom-items">
            <li>
                <a href="logout.php" <?php echo ($current_page == 'logout.php') ? 'id="active--link"' : ''; ?>>
                    <span class="icon icon-8"><i class="fas fa-sign-out-alt"></i></span>
                    <span class="sidebar--item">Logout</span>
                </a>
            </li>
        </ul>
    </aside>
</section>