<?php
session_start();

// Redirect to login if no user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: /steelsync/admin/login.php");
    exit();
}
// Verify the user has the correct role
if ($_SESSION["role"] !== 'super_admin') {
    // Redirect to appropriate page or show error

    header("Location: /steelsync/admin/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Intellitect System</title>

    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="css.css/style.css" rel="stylesheet">

    <style>
        /* Payroll Header - Remains in place */
        .payroll-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .payroll-header h2 {
            font-size: 20px;
            font-weight: bold;
            font-style: italic;
            margin: 0;
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .date-picker {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
        }

        .date-picker i {
            color: #6c757d;
        }

        .download-btn {
            background-color: #f57c00;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .download-btn:hover {
            background-color: #e65100;
        }

        /* Open Payroll Button */
        .open-payroll-btn {
            background-color: #5073fb;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 20px;
        }

        .open-payroll-btn:hover {
            background-color: #3f5bd3;
        }
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>
    <?php include "includes/salarycomputation.php"; ?>

    <div class="main--content">
        <!-- Payroll Header - Stays in place -->
        <div class="payroll-header">
            <h2>PAYROLL</h2>
            <div class="header-controls">
                <div class="date-picker">
                    <i class="fas fa-calendar"></i>
                    <span>Jan 1 2025 - Jan 15 2025</span>
                </div>
                <button class="download-btn">
                    <i class="fas fa-download"></i>
                    <span>Download</span>
                </button>
            </div>
        </div>

        <!-- Button to open payroll modal -->
        <button class="open-payroll-btn" id="openPayrollBtn">
            <i class="fas fa-file-invoice-dollar"></i>
            Payroll modal
        </button>
    </div>

    <?php include "includes/script.php"; ?>

</body>

</html>