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
    
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="css.css/account-manager.css" rel="stylesheet">
    <link href="css.css/style.css" rel="stylesheet">
    <style>

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
                    <tr><td colspan="3">No users found</td></tr>
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

<?php
$conn->close();
?>