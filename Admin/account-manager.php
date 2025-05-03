<?php
require_once 'includes/auth.php';

// Database connection
$host = "localhost";
$dbname = "steelsync";
$dbuser = "root";
$dbpass = "";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Check permissions before processing
        $allowed = true;

        // HR admin can only add/edit employee accounts
        if ($_SESSION['role'] === 'hr_admin') {
            if ($_POST['action'] === 'add_account' && isset($_POST['role'])) {
                if ($_POST['role'] !== 'employee') {
                    $allowed = false;
                    $_SESSION['error'] = "You don't have permission to add administrator accounts";
                }
            } elseif ($_POST['action'] === 'edit_account' && isset($_POST['id'])) {
                // Get current role of the account being edited
                $id = (int)$_POST['id'];
                $query = "SELECT role FROM users WHERE id = $id";
                $result = $conn->query($query);
                if ($result && $result->num_rows > 0) {
                    $account = $result->fetch_assoc();
                    if ($account['role'] !== 'employee') {
                        $allowed = false;
                        $_SESSION['error'] = "You don't have permission to edit administrator accounts";
                    }
                }
            }
        }

        if ($allowed) {
            switch ($_POST['action']) {
                case 'add_account':
                    addAccount($conn);
                    break;
                case 'edit_account':
                    editAccount($conn);
                    break;
                case 'archive_account':
                    archiveAccount($conn, $_POST['id'], true);
                    break;
                case 'restore_account':
                    archiveAccount($conn, $_POST['id'], false);
                    break;
            }
        } else {
            header("Location: account-manager.php");
            exit();
        }
    }
}

// Function to add a new account
function addAccount($conn)
{
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header("Location: account-manager.php");
        exit();
    }

    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = $conn->real_escape_string($_POST['phoneNumber']);
    $role = $conn->real_escape_string($_POST['role']);
    $positionId = (int)$_POST['position'];
    $gender = $conn->real_escape_string($_POST['gender']);

    // Additional validation
    if (
        empty($firstName) || empty($lastName) || empty($email) || empty($username) ||
        (empty($_POST['password']) && $_POST['action'] === 'add_account')
    ) {
        $_SESSION['error'] = "All required fields must be filled";
        header("Location: account-manager.php");
        exit();
    }

    // Check if username or email already exists
    $checkQuery = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $checkQuery->bind_param("ss", $username, $email);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult->num_rows > 0) {
        $_SESSION['error'] = "Username or email already exists";
        header("Location: account-manager.php");
        exit();
    }

    // Get position name
    $positionQuery = $conn->query("SELECT name FROM positions WHERE id = $positionId");
    $position = $positionQuery->fetch_assoc()['name'];

    // Insert into users table
    $query = "INSERT INTO users (username, password, firstname, lastname, email, phone, gender, role) 
              VALUES ('$username', '$password', '$firstName', '$lastName', '$email', '$phone', '$gender', '$role')";

    if ($conn->query($query)) {
        $userId = $conn->insert_id;

        // Insert into role-specific table
        switch ($role) {
            case 'employee':
                $hireDate = date('Y-m-d');
                $conn->query("INSERT INTO employee (user_id, position, hire_date) VALUES ($userId, '$position', '$hireDate')");
                break;
            case 'hr_admin':
                $conn->query("INSERT INTO hr_admin (user_id, position) VALUES ($userId, '$position')");
                break;
            case 'support_admin':
                $conn->query("INSERT INTO support_admin (user_id, position) VALUES ($userId, '$position')");
                break;
            case 'super_admin':
                $conn->query("INSERT INTO super_admin (user_id) VALUES ($userId)");
                break;
        }

        $_SESSION['success'] = "Account added successfully!";
    } else {
        $_SESSION['error'] = "Error adding account: " . $conn->error;
    }

    header("Location: account-manager.php");
    exit();
}

// Function to edit an account
function editAccount($conn)
{
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header("Location: account-manager.php");
        exit();
    }

    $id = (int)$_POST['id'];
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $phone = $conn->real_escape_string($_POST['phoneNumber']);
    $role = $conn->real_escape_string($_POST['role']);
    $positionId = (int)$_POST['position'];
    $gender = $conn->real_escape_string($_POST['gender']);

    // Get position name
    $positionQuery = $conn->query("SELECT name FROM positions WHERE id = $positionId");
    $position = $positionQuery->fetch_assoc()['name'];

    // Update users table
    $query = "UPDATE users SET 
              username = '$username',
              firstname = '$firstName',
              lastname = '$lastName',
              email = '$email',
              phone = '$phone',
              gender = '$gender',
              role = '$role'
              WHERE id = $id";

    if ($conn->query($query)) {
        // Update password if provided
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $conn->query("UPDATE users SET password = '$password' WHERE id = $id");
        }

        // First, delete any existing role-specific records to handle role changes
        $conn->query("DELETE FROM employee WHERE user_id = $id");
        $conn->query("DELETE FROM hr_admin WHERE user_id = $id");
        $conn->query("DELETE FROM support_admin WHERE user_id = $id");
        $conn->query("DELETE FROM super_admin WHERE user_id = $id");

        // Insert into the appropriate role-specific table
        switch ($role) {
            case 'employee':
                $hireDate = date('Y-m-d');
                $conn->query("INSERT INTO employee (user_id, position, hire_date) VALUES ($id, '$position', '$hireDate')");
                break;
            case 'hr_admin':
                $conn->query("INSERT INTO hr_admin (user_id, position) VALUES ($id, '$position')");
                break;
            case 'support_admin':
                $conn->query("INSERT INTO support_admin (user_id, position) VALUES ($id, '$position')");
                break;
            case 'super_admin':
                $conn->query("INSERT INTO super_admin (user_id) VALUES ($id)");
                break;
        }

        $_SESSION['success'] = "Account updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating account: " . $conn->error;
    }

    header("Location: account-manager.php");
    exit();
}

// Function to archive/restore an account
function archiveAccount($conn, $id, $archive)
{
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header("Location: account-manager.php");
        exit();
    }

    $id = (int)$id;
    $currentTime = date('Y-m-d H:i:s');
    $archivedBy = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

    try {
        // Start transaction
        $conn->begin_transaction();

        if ($archive) {
            // Archive the account
            $query = "UPDATE users SET 
                      archived = TRUE, 
                      archived_at = ?, 
                      archived_by = ?
                      WHERE id = ?";
            $message = "Account archived successfully!";
        } else {
            // Restore the account
            $query = "UPDATE users SET 
                      archived = FALSE, 
                      archived_at = NULL, 
                      archived_by = NULL
                      WHERE id = ?";
            $message = "Account restored successfully!";
        }

        // Prepare the statement
        $stmt = $conn->prepare($query);

        if ($archive) {
            $stmt->bind_param("sii", $currentTime, $archivedBy, $id);
        } else {
            $stmt->bind_param("i", $id);
        }

        // Execute the query
        if ($stmt->execute()) {
            $conn->commit();
            $_SESSION['success'] = $message;
        } else {
            throw new Exception("Database error: " . $stmt->error);
        }
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = "Error updating account status: " . $e->getMessage();
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }

    header("Location: account-manager.php");
    exit();
}

// Get all accounts for display
function getAccounts($conn, $role, $filter = 'all', $search = '')
{
    $accounts = [];

    // Base where clause
    if ($role === 'admin') {
        $where = "WHERE (u.role = 'hr_admin' OR u.role = 'support_admin' OR u.role = 'super_admin')";
    } else {
        $where = "WHERE u.role = '$role'";
    }

    // Apply filters
    if ($filter === 'archived') {
        $where .= " AND u.archived = TRUE";
    } elseif ($filter === 'active') {
        $where .= " AND u.archived = FALSE";
    } elseif ($filter !== 'all') {
        // Check if filter is a position
        $positionQuery = $conn->query("SELECT id FROM positions WHERE name = '$filter'");
        if ($positionQuery->num_rows > 0) {
            $positionId = $positionQuery->fetch_assoc()['id'];
            $where .= " AND p.id = $positionId";
        }
    }

    // Apply search
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $where .= " AND (u.firstname LIKE '%$search%' OR u.lastname LIKE '%$search%' OR CONCAT(u.firstname, ' ', u.lastname) LIKE '%$search%')";
    }

    $query = "SELECT u.id, u.firstname, u.lastname, u.email, u.phone, u.role, u.archived, 
                     CASE
                         WHEN u.role = 'employee' THEN (SELECT position FROM employee WHERE user_id = u.id)
                         WHEN u.role = 'hr_admin' THEN (SELECT position FROM hr_admin WHERE user_id = u.id)
                         WHEN u.role = 'support_admin' THEN (SELECT position FROM support_admin WHERE user_id = u.id)
                         WHEN u.role = 'super_admin' THEN 'Super Admin'
                     END AS position,
                     p.id AS position_id
              FROM users u
              LEFT JOIN positions p ON 
                  (u.role = 'employee' AND EXISTS (SELECT 1 FROM employee e WHERE e.user_id = u.id AND e.position = p.name)) OR
                  (u.role = 'hr_admin' AND EXISTS (SELECT 1 FROM hr_admin h WHERE h.user_id = u.id AND h.position = p.name)) OR
                  (u.role = 'support_admin' AND EXISTS (SELECT 1 FROM support_admin s WHERE s.user_id = u.id AND s.position = p.name))
              $where
              ORDER BY u.archived, u.lastname, u.firstname";

    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $accounts[] = $row;
        }
    } else {
        error_log("Database query error: " . $conn->error);
    }

    return $accounts;
}

// Get all positions for a role
function getPositions($conn, $role)
{
    $positions = [];

    // For admin tab, get positions for both admin types
    if ($role === 'admin') {
        $query = "SELECT id, name FROM positions WHERE role = 'hr_admin' OR role = 'support_admin' ORDER BY name";
    } else {
        $query = "SELECT id, name FROM positions WHERE role = '$role' ORDER BY name";
    }

    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $positions[] = $row;
        }
    }

    return $positions;
}

// Get account details for editing
function getAccountDetails($conn, $id)
{
    $id = (int)$id;
    $query = "SELECT u.*, 
                     CASE
                         WHEN u.role = 'employee' THEN (SELECT position FROM employee WHERE user_id = u.id)
                         WHEN u.role = 'hr_admin' THEN (SELECT position FROM hr_admin WHERE user_id = u.id)
                         WHEN u.role = 'support_admin' THEN (SELECT position FROM support_admin WHERE user_id = u.id)
                         WHEN u.role = 'super_admin' THEN 'Super Admin'
                     END AS position_name,
                     p.id AS position_id,
                     u.role AS role_type
              FROM users u
              LEFT JOIN positions p ON 
                  (u.role = 'employee' AND EXISTS (SELECT 1 FROM employee e WHERE e.user_id = u.id AND e.position = p.name)) OR
                  (u.role = 'hr_admin' AND EXISTS (SELECT 1 FROM hr_admin h WHERE h.user_id = u.id AND h.position = p.name)) OR
                  (u.role = 'support_admin' AND EXISTS (SELECT 1 FROM support_admin s WHERE s.user_id = u.id AND s.position = p.name))
              WHERE u.id = $id";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        error_log("Account details not found for ID: $id");
    }

    return null;
}

// Set default active role - HR Admin can only see employee tab
$activeRole = 'employee';
if ($_SESSION['role'] === 'super_admin') {
    $activeRole = isset($_GET['role']) ? $_GET['role'] : 'employee';
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Get filter and search values
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Get accounts for display
$accounts = getAccounts($conn, $activeRole === 'admin' ? 'admin' : $activeRole, $filter, $search);
$positions = getPositions($conn, $activeRole === 'admin' ? 'admin' : $activeRole);

// Get all position names for filter dropdown
$allPositions = [];
$result = $conn->query("SELECT name, role FROM positions ORDER BY role, name");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $allPositions[] = $row;
    }
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
    <link href="css/style.css" rel="stylesheet">
    <link href="css/account-manager.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>

    <div class="main--content">
        <div class="account-manager-container">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success'];
                                                    unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['error'];
                                                unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="account-manager-header">
                <h2>ACCOUNT MANAGER</h2>
                <div class="tabs">
                    <a href="account-manager.php?role=employee" class="tab <?php echo ($activeRole == 'employee') ? 'active' : ''; ?>">Employee</a>
                    <?php if ($_SESSION['role'] === 'super_admin'): ?>
                        <a href="account-manager.php?role=admin" class="tab <?php echo ($activeRole == 'admin') ? 'active' : ''; ?>">Administrator</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="account-manager-tools">
                <form method="get" action="account-manager.php" class="filter-search">
                    <input type="hidden" name="role" value="<?php echo $activeRole; ?>">
                    <div class="dropdown">
                        <select id="filterDropdown" name="filter" onchange="this.form.submit()">
                            <option value="all">All Roles</option>
                            <option value="archived" <?php echo ($filter == 'archived') ? 'selected' : ''; ?>>Archived Accounts</option>
                            <option value="<?php echo $activeRole; ?>" <?php echo ($filter == $activeRole) ? 'selected' : ''; ?>>
                                <?php echo ucfirst($activeRole); ?>
                            </option>
                            <optgroup label="<?php echo ($activeRole == 'employee') ? 'Employee' : 'Administrator'; ?> Positions">
                                <?php foreach ($allPositions as $pos): ?>
                                    <?php if (($activeRole == 'employee' && $pos['role'] == 'employee') ||
                                        ($activeRole == 'admin' && ($pos['role'] == 'hr_admin' || $pos['role'] == 'support_admin'))
                                    ): ?>
                                        <option value="<?php echo htmlspecialchars($pos['name']); ?>" <?php echo ($filter == $pos['name']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($pos['name']); ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                    <div class="search-container">
                        <input type="text" id="searchInput" name="search" placeholder="Search by name" value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="search-btn">Search</button>
                    </div>
                </form>
                <button class="add-account-btn" onclick="openAddModal()">
                    <i class="fas fa-plus"></i> Add Account
                </button>
            </div>

            <div class="account-table">
                <div class="table-header">
                    <div class="header-item employee-id">ID</div>
                    <div class="header-item employee-name">Name</div>
                    <div class="header-item role">Role</div>
                    <div class="header-item position">Position</div>
                    <div class="header-item actions">Actions</div>
                </div>
                <div class="table-content" id="employeeTableContent">
                    <?php if (empty($accounts)): ?>
                        <div class="empty-table">
                            <p>No records found</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($accounts as $account): ?>
                            <div class="table-row <?php echo $account['archived'] ? 'archived' : ''; ?>">
                                <div class="row-item employee-id"><?php echo $account['id']; ?></div>
                                <div class="row-item employee-name">
                                    <?php echo htmlspecialchars($account['firstname'] . ' ' . $account['lastname']); ?>
                                    <?php if ($account['archived']): ?>
                                        <span class="archived-badge">Inactive</span>
                                    <?php endif; ?>
                                </div>
                                <div class="row-item role"><?php echo ucfirst(str_replace('_', ' ', $account['role'])); ?></div>
                                <div class="row-item position"><?php echo htmlspecialchars($account['position'] ?? 'N/A'); ?></div>
                                <div class="row-item actions">
                                    <button class="action-btn edit-btn" onclick="openEditModal(<?php echo $account['id']; ?>)">
                                        <i class="fas fa-user-edit"></i> Edit
                                    </button>
                                    <?php if ($account['archived']): ?>
                                        <button class="action-btn restore-btn" onclick="confirmAction(<?php echo $account['id']; ?>, 'restore')">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    <?php else: ?>
                                        <button class="action-btn archive-btn" onclick="confirmAction(<?php echo $account['id']; ?>, 'archive')">
                                            <i class="fas fa-archive"></i> Inactive
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Modal for adding/editing account -->
            <div id="accountModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModals()">&times;</span>
                    <h2 id="modalTitle">Add New Account</h2>
                    <form id="accountForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" id="employeeId" name="id" value="">
                        <input type="hidden" id="actionType" name="action" value="add_account">

                        <!-- Profile Photo Section -->
                        <div class="profile-photo-section">
                            <div class="photo-container">
                                <i class="fas fa-user-circle profile-placeholder"></i>
                                <img id="profileImagePreview" src="" alt="Profile Photo" style="display: none;">
                            </div>
                            <div class="photo-actions">
                                <button type="button" class="upload-photo-btn" onclick="document.getElementById('profilePhoto').click()">
                                    <i class="fas fa-upload"></i> Upload Photo
                                </button>
                                <input type="file" id="profilePhoto" name="profilePhoto" accept="image/*" style="display: none;" onchange="previewImage(this)">
                                <button type="button" class="scan-fingerprint-btn">
                                    <i class="fas fa-fingerprint"></i> Scan Fingerprint
                                </button>
                            </div>
                        </div>

                        <!-- User Details Section -->
                        <div class="form-section">
                            <h3>User Details</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstName">First Name *</label>
                                    <input type="text" id="firstName" name="firstName" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Last Name *</label>
                                    <input type="text" id="lastName" name="lastName" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="gender">Gender *</label>
                                    <select id="gender" name="gender" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="phoneNumber">Phone Number</label>
                                    <input type="tel" id="phoneNumber" name="phoneNumber">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="roleSelect">Role *</label>
                                <select id="roleSelect" name="role" required onchange="updatePositionOptions(this.value)" <?php echo ($_SESSION['role'] === 'hr_admin') ? 'disabled' : ''; ?>>
                                    <option value="employee" <?php echo ($activeRole == 'employee') ? 'selected' : ''; ?>>Employee</option>
                                    <?php if ($_SESSION['role'] === 'super_admin'): ?>
                                        <option value="hr_admin" <?php echo ($activeRole == 'admin') ? 'selected' : ''; ?>>HR Administrator</option>
                                        <option value="support_admin" <?php echo ($activeRole == 'admin') ? 'selected' : ''; ?>>Support Administrator</option>
                                        <option value="super_admin" <?php echo ($activeRole == 'admin') ? 'selected' : ''; ?>>Super Administrator</option>
                                    <?php endif; ?>
                                </select>
                                <?php if ($_SESSION['role'] === 'hr_admin'): ?>
                                    <input type="hidden" name="role" value="employee">
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="positionSelect">Position *</label>
                                <select id="positionSelect" name="position" required>
                                    <?php foreach ($positions as $position): ?>
                                        <option value="<?php echo $position['id']; ?>"><?php echo htmlspecialchars($position['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                        </div>

                        <!-- Change Password Section -->
                        <div class="form-section">
                            <h3>Account Credentials</h3>
                            <div class="form-group">
                                <label for="username">Username *</label>
                                <input type="text" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">New Password <span id="passwordRequired">*</span></label>
                                <input type="password" id="password" name="password">
                                <small id="passwordNote">Leave blank to keep current password (when editing)</small>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm New Password</label>
                                <input type="password" id="confirmPassword" name="confirmPassword">
                            </div>
                        </div>

                        <div class="form-buttons">
                            <button type="button" onclick="closeModals()">Cancel</button>
                            <button type="submit" id="saveBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Confirmation Modal -->
            <div id="confirmModal" class="modal">
                <div class="modal-content confirmation-modal">
                    <h2 id="archiveModalTitle">Confirm Archive</h2>
                    <p id="archiveConfirmText">Are you sure you want to archive this account? Archived accounts can be restored later.</p>
                    <form id="archiveForm" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" id="archiveAccountId" name="id" value="">
                        <input type="hidden" id="archiveAction" name="action" value="archive_account">
                        <div class="form-buttons">
                            <button type="button" onclick="closeModals()">Cancel</button>
                            <button type="submit" id="confirmArchiveBtn">Archive</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Positions data for JavaScript
        const positionsByRole = {
            employee: <?php echo json_encode(getPositions($conn, 'employee')); ?>,
            hr_admin: <?php echo json_encode(getPositions($conn, 'hr_admin')); ?>,
            support_admin: <?php echo json_encode(getPositions($conn, 'support_admin')); ?>,
            super_admin: []
        };

        // Open add modal
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Account';
            document.getElementById('actionType').value = 'add_account';
            document.getElementById('employeeId').value = '';
            document.getElementById('accountForm').reset();

            // Set default role based on user role
            if ('<?php echo $_SESSION['role']; ?>' === 'hr_admin') {
                document.getElementById('roleSelect').value = 'employee';
            } else if ('<?php echo $activeRole; ?>' === 'admin') {
                document.getElementById('roleSelect').value = 'hr_admin';
            } else {
                document.getElementById('roleSelect').value = 'employee';
            }

            updatePositionOptions(document.getElementById('roleSelect').value);
            document.getElementById('passwordRequired').style.display = 'inline';
            document.getElementById('passwordNote').style.display = 'none';
            document.getElementById('profileImagePreview').style.display = 'none';
            document.getElementById('profileImagePreview').src = '';
            document.querySelector('.profile-placeholder').style.display = 'block';
            document.getElementById('accountModal').style.display = 'flex';
        }

        // Open edit modal
        function openEditModal(employeeId) {
            fetch('includes/get_account.php?id=' + employeeId)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('modalTitle').textContent = 'Edit Account';
                        document.getElementById('actionType').value = 'edit_account';
                        document.getElementById('employeeId').value = data.id;
                        document.getElementById('firstName').value = data.firstname;
                        document.getElementById('lastName').value = data.lastname;
                        document.getElementById('gender').value = data.gender;
                        document.getElementById('phoneNumber').value = data.phone;

                        // Set role - use role_type if available (for admin types)
                        const role = data.role_type || data.role;
                        document.getElementById('roleSelect').value = role;

                        document.getElementById('email').value = data.email;
                        document.getElementById('username').value = data.username;
                        document.getElementById('passwordRequired').style.display = 'none';
                        document.getElementById('passwordNote').style.display = 'block';

                        // Update positions based on role
                        updatePositionOptions(role);

                        // Set position after options are updated
                        setTimeout(() => {
                            document.getElementById('positionSelect').value = data.position_id;
                        }, 100);

                        // Set profile image if exists
                        if (data.photo && data.photo !== 'default.jpg') {
                            document.getElementById('profileImagePreview').src = 'uploads/profiles/' + data.photo;
                            document.getElementById('profileImagePreview').style.display = 'block';
                            document.querySelector('.profile-placeholder').style.display = 'none';
                        } else {
                            document.getElementById('profileImagePreview').style.display = 'none';
                            document.getElementById('profileImagePreview').src = '';
                            document.querySelector('.profile-placeholder').style.display = 'block';
                        }

                        document.getElementById('accountModal').style.display = 'flex';
                    }
                });
        }

        // Update position options based on selected role
        function updatePositionOptions(role) {
            const positionSelect = document.getElementById('positionSelect');
            positionSelect.innerHTML = '';

            // For super admin, we don't need positions
            if (role === 'super_admin') {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Super Admin (No Position)';
                positionSelect.appendChild(option);
                positionSelect.disabled = true;
                return;
            } else {
                positionSelect.disabled = false;
            }

            // For admin roles, combine both position types
            const positions = role === 'hr_admin' || role === 'support_admin' ? [...positionsByRole['hr_admin'], ...positionsByRole['support_admin']] :
                positionsByRole[role] || [];

            positions.forEach(position => {
                const option = document.createElement('option');
                option.value = position.id;
                option.textContent = position.name;
                positionSelect.appendChild(option);
            });
        }

        // Open confirmation modal for archive/restore
        function confirmAction(employeeId, action) {
            const modal = document.getElementById('confirmModal');
            const title = document.getElementById('archiveModalTitle');
            const text = document.getElementById('archiveConfirmText');
            const btn = document.getElementById('confirmArchiveBtn');
            const form = document.getElementById('archiveForm');
            const actionField = document.getElementById('archiveAction');
            const idField = document.getElementById('archiveAccountId');

            idField.value = employeeId;

            if (action === 'archive') {
                title.textContent = 'Confirm Inactive';
                text.textContent = 'Are you sure you want to change this account to inactive? Inactive accounts can be restored later.';
                btn.textContent = 'Inactive';
                actionField.value = 'archive_account';
            } else {
                title.textContent = 'Confirm Restore';
                text.textContent = 'Are you sure you want to restore this account?';
                btn.textContent = 'Restore';
                actionField.value = 'restore_account';
            }

            modal.style.display = 'flex';
        }

        // Close all modals
        function closeModals() {
            document.getElementById('accountModal').style.display = 'none';
            document.getElementById('confirmModal').style.display = 'none';
        }

        // Preview uploaded image
        function previewImage(input) {
            const preview = document.getElementById('profileImagePreview');
            const placeholder = document.querySelector('.profile-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Auto-generate username and email from first and last name
        document.getElementById('firstName').addEventListener('input', updateUsername);
        document.getElementById('lastName').addEventListener('input', updateUsername);

        function updateUsername() {
            const firstName = document.getElementById('firstName').value.trim().toLowerCase();
            const lastName = document.getElementById('lastName').value.trim().toLowerCase();

            if (firstName && lastName) {
                const username = `${firstName}.${lastName}`.replace(/\s+/g, '');
                document.getElementById('username').value = username;
                document.getElementById('email').value = `${username}@company.com`;
            }
        }

        // Validate form before submission
        document.getElementById('accountForm').addEventListener('submit', function(e) {
            const actionType = document.getElementById('actionType').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // For new accounts, password is required
            if (actionType === 'add_account' && !password) {
                alert('Password is required for new accounts');
                e.preventDefault();
                return;
            }

            // Check if passwords match when provided
            //  if (password && password !== confirmPassword) {
            //  alert('Passwords do not match');
            //      e.preventDefault();
            //     return;
            // }
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                closeModals();
            }
        });
    </script>
    <?php include "includes/script.php"; ?>
</body>

</html>
<?php $conn->close(); ?>