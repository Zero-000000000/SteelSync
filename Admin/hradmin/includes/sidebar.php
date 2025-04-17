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
                <a href="hr_admin.php" <?php echo ($current_page == 'index.php') ? 'id="active--link"' : ''; ?>>
                    <span class="icon icon-1"><i class="fas fa-th-large"></i></span>
                    <span class="sidebar--item">Dashboard</span>
                </a>
            </li>




            <!-- Other sidebar items -->

            <li>
                <a href="payroll.php" <?php echo ($current_page == 'payroll.php') ? 'id="active--link"' : ''; ?>>
                    <span class="icon icon-3"><i class="fas fa-money-check-alt"></i></span>
                    <span class="sidebar--item">Payroll</span>
                </a>
            </li>
            <li>
                <a href="attendance.php" <?php echo ($current_page == 'attendance.php') ? 'id="active--link"' : ''; ?>>
                    <span class="icon icon-4"><i class="fas fa-calendar-check"></i></span>
                    <span class="sidebar--item">Attendance</span>
                </a>
            </li>



        </ul>
        <ul class="sidebar--bottom-items">
            <li>
                <a href="account-manager.php" <?php echo ($current_page == 'account-manager.php') ? 'id="active--link"' : ''; ?>>
                    <span class="icon icon-7"><i class="fas fa-cog"></i></span>
                    <span class="sidebar--item">Account Manager</span>
                </a>
            </li>
            <li>
                <a href="logout.php" <?php echo ($current_page == 'logout.php') ? 'id="active--link"' : ''; ?>>
                    <span class="icon icon-8"><i class="fas fa-sign-out-alt"></i></span>
                    <span class="sidebar--item">Logout</span>
                </a>
            </li>
        </ul>
    </aside>
</section>