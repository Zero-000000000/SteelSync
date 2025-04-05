<?php
session_start();

// Redirect to login if no user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: /steelsync/admin/login.php");
    exit();
}

// Verify the user has the correct role
if ($_SESSION["role"] !== 'hr_admin') {
    // Redirect to appropriate page or show error
    header("Location: /steelsync/admin/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hradmin123</title>
</head>

<body>
    <a href="logout.php">
        <span class="icon icon-8"><i class="fas fa-sign-out-alt"></i></span>
        <span class="sidebar--item">Logout</span>
    </a>
</body>

</html>