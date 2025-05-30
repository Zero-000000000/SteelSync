<?php
session_start();

// Redirect to login if no user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Define role-based permissions
$permissions = [
    'support_admin' => ['index.php', 'Apointment.php', 'raw-material.php', 'fix-assets.php', 'pointofsale.php'],
    'hr_admin' => ['payroll.php', 'attendance.php', 'account-manager.php'],
    'super_admin' => ['index.php', 'Apointment.php', 'raw-material.php', 'fix-assets.php', 'pointofsale.php', 'payroll.php', 'attendance.php', 'account-manager.php']
];

// Get current page and user role
$current_page = basename($_SERVER['PHP_SELF']);
$current_role = $_SESSION["role"] ?? '';

// Check if user has permission to access the current page
if (!in_array($current_page, $permissions[$current_role] ?? [])) {
    header("Location: index.php");
    exit();
}

// Additional role-based restrictions for account-manager.php
if ($current_page === 'account-manager.php') {
    // Only allow access to specific roles
    if (!in_array($current_role, ['hr_admin', 'super_admin'])) {
        header("Location: index.php");
        exit();
    }

    // HR Admin can only access employee tab
    if ($current_role === 'hr_admin' && isset($_GET['role']) && $_GET['role'] === 'admin') {
        header("Location: account-manager.php?role=employee");
        exit();
    }
}
