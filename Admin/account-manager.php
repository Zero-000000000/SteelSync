<?php
session_start();

// Redirect to login if no user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = "localhost";
$dbname = "steelsync";
$dbuser = "root";
$dbpass = "";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users
$users_query = "SELECT * FROM users";
$users_result = $conn->query($users_query);

// Check for query errors
if (!$users_result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Manager</title>


    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="css.css/style.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e81e6d;
            --text-color: #333;
            --background-color: #f4f4f4;
            --white: #ffffff;
        }


        body {
            background-color: var(--background-color);
        }


        .account-manager-container {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 60px;
            right: 0;
            margin: 10px;
            width: calc(100% - 320px);
            padding: 20px;
            overflow-y: auto;

            transition: .3s;
        }

        .account-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .account-header h1 {
            font-size: 1.5rem;
            color: var(--text-color);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-filter {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .search-input-wrapper {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        .search-input {
            padding: 8px 12px 8px 35px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 250px;
            font-size: 0.9rem;
        }

        .add-account-btn {
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-account-btn:hover {
            background-color: #c11559;
        }

        .account-table {
            width: 100%;
            border-collapse: collapse;
        }

        .account-table thead {
            background-color: #f8f9fa;
        }

        .account-table th,
        .account-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .employee-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .employee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .action-icons {

            gap: 10px;
        }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            transition: color 0.3s;
        }

        .action-btn:hover {
            color: var(--primary-color);
        }

        .edit-btn i {
            font-size: 1rem;
        }

        .delete-btn i {
            font-size: 1rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background-color: var(--white);
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            font-size: 1.2rem;
            color: var(--text-color);
        }

        .close-btn {
            background: none;
            border: none;
            color: #888;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .btn-cancel {
            background-color: #f1f3f5;
            color: var(--text-color);
        }

        .btn-save {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .btn-save:hover {
            background-color: #c11559;
        }
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>

    <div class="account-manager-container">
        <div class="account-header">
            <h1>Account Manager</h1>
            <div class="header-actions">
                <div class="search-container">
                    <select class="search-filter">
                        <option>All</option>
                        <option>Managers</option>
                        <option>Employees</option>
                    </select>
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" placeholder="Search" class="search-input">
                    </div>
                </div>
                <button class="add-account-btn" onclick="openModal()">
                    <i class="fas fa-plus"></i> Add Account
                </button>
            </div>
        </div>

        <table class="account-table">
            <thead>
                <tr>
                    <th>Employees Name</th>
                    <th>Position</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($users_result->num_rows > 0): ?>
                    <?php while ($user = $users_result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <div class="employee-info">

                                    <?php echo htmlspecialchars($user['employee_name'] ?? 'N/A'); ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($user['position'] ?? 'N/A'); ?></td>
                            <td class="action-icons">
                                <button class="action-btn edit-btn">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No users found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Account Modal -->
    <div id="addAccountModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Account</h2>
                <button class="close-btn" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addAccountForm" method="POST" action="save_account.php">
                <div class="form-group">
                    <label for="employee_name">Employee Name</label>
                    <input type="text" id="employee_name" name="employee_name" required>
                </div>
                <div class="form-group">
                    <label for="position">Position</label>
                    <input type="text" id="position" name="position" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-save">Save Account</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addAccountModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('addAccountModal').classList.remove('show');
        }
    </script>
    <?php include "includes/script.php"; ?>
</body>

</html>