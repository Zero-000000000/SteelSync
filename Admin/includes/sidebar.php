<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Define role-based permissions
$permissions = [
    'support_admin' => ['dashboard', 'appointment', 'inventory', 'pos'],
    'hr_admin' => ['payroll', 'attendance', 'accountmanager'],
    'super_admin' => ['dashboard', 'appointment', 'inventory', 'pos', 'payroll', 'attendance', 'accountmanager']
];

// Get current user's role
$current_role = $_SESSION["role"] ?? '';
$allowed_pages = $permissions[$current_role] ?? [];

// Ensure $current_page is defined
$current_page = basename($_SERVER['PHP_SELF']);
// Simplify page name for matching (remove .php and special cases)
$page_key = str_replace('.php', '', $current_page);
$page_key = str_replace('-', '', strtolower($page_key));

// Special cases for inventory subpages
if (in_array($page_key, ['rawmaterial', 'fixassets'])) {
    $page_key = 'inventory';
}
?>

<section class="main">
    <aside class="sidebar">
        <ul class="sidebar--items">
            <?php if (in_array('dashboard', $allowed_pages)): ?>
                <li>
                    <a href="index.php" <?php echo ($page_key == 'index') ? 'id="active--link"' : ''; ?>>
                        <span class="icon icon-1"><i class="fas fa-th-large"></i></span>
                        <span class="sidebar--item">Dashboard</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (in_array('appointment', $allowed_pages)): ?>
                <li>
                    <a href="Apointment.php" <?php echo ($page_key == 'apointment') ? 'id="active--link"' : ''; ?>>
                        <span class="icon icon-1"><i class="fas fa-calendar-alt"></i></span>
                        <span class="sidebar--item">Appointment</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (in_array('inventory', $allowed_pages)): ?>
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
            <?php endif; ?>

            <?php if (in_array('pos', $allowed_pages)): ?>
                <li>
                    <a href="pointofsale.php" <?php echo ($page_key == 'pointofsale') ? 'id="active--link"' : ''; ?>>
                        <span class="icon icon-4"><i class="fas fa-cash-register"></i></span>
                        <span class="sidebar--item">Point of Sale</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (in_array('payroll', $allowed_pages)): ?>
                <li>
                    <a href="payroll.php" <?php echo ($page_key == 'payroll') ? 'id="active--link"' : ''; ?>>
                        <span class="icon icon-3"><i class="fas fa-money-check-alt"></i></span>
                        <span class="sidebar--item">Payroll</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (in_array('attendance', $allowed_pages)): ?>
                <li>
                    <a href="attendance.php" <?php echo ($page_key == 'attendance') ? 'id="active--link"' : ''; ?>>
                        <span class="icon icon-4"><i class="fas fa-calendar-check"></i></span>
                        <span class="sidebar--item">Attendance</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>

        <ul class="sidebar--bottom-items">
            <?php if (in_array('accountmanager', $allowed_pages)): ?>
                <li>
                    <a href="account-manager.php" <?php echo ($page_key == 'accountmanager') ? 'id="active--link"' : ''; ?>>
                        <span class="icon icon-7"><i class="fas fa-cog"></i></span>
                        <span class="sidebar--item">Account Manager</span>
                    </a>
                </li>
            <?php endif; ?>

            <li>
                <a href="logout.php">
                    <span class="icon icon-8"><i class="fas fa-sign-out-alt"></i></span>
                    <span class="sidebar--item">Logout</span>
                </a>
            </li>
        </ul>
    </aside>
</section>