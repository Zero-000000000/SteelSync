<?php
session_start();

// If user is already logged in, redirect based on their role
if (isset($_SESSION["user_type"]) && isset($_SESSION["username"])) {
    switch ($_SESSION["user_type"]) {
        case "super_admin":
            header("Location: admin/dashboard.php");
            break;
        case "hr_admin":
            header("Location: hr/dashboard.php");
            break;
        case "support_admin":
            header("Location: support/dashboard.php");
            break;
        case "client":
            header("Location: client/dashboard.php");
            break;
        default:
            header("Location: index.php");
    }
    exit();
}

$host = "localhost";
$dbname = "steelsync";
$dbuser = "root";
$dbpass = "";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $user_type = trim($_POST["user_type"]); // Get the selected user type

    // Check the appropriate table based on user type
    switch ($user_type) {
        case "super_admin":
            $table = "super_admins";
            $redirect = "admin/dashboard.php";
            break;
        case "hr_admin":
            $table = "hr_admins";
            $redirect = "hr/dashboard.php";
            break;
        case "support_admin":
            $table = "support_admins";
            $redirect = "support/dashboard.php";
            break;
        case "client":
            $table = "clients";
            $redirect = "client/dashboard.php";
            break;
        default:
            $error = "Invalid user type selected";
            break;
    }

    if (empty($error)) {
        $stmt = $conn->prepare("SELECT password FROM $table WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (md5($password) === $hashed_password) {
                $_SESSION["username"] = $username;
                $_SESSION["user_type"] = $user_type;
                header("Location: $redirect");
                exit();
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SteelSync - Login</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
        /* Additional styles for the role selector */
        .role-selector {
            margin-bottom: 20px;
            width: 100%;
        }

        .role-selector select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="images/Group 70.png" alt="SteelSync Logo">
        </div>
        <h2>SteelSync</h2>
        <p>A WEB-BASED SYSTEM FOR METAL & STEEL FABRICATION</p>
        <form method="POST" action="">
            <div class="role-selector">
                <select name="user_type" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="super_admin">Super Admin</option>
                    <option value="hr_admin">HR Admin</option>
                    <option value="support_admin">Support Admin</option>
                    <option value="client">Client</option>
                </select>
            </div>
            <div class="input-container">
                <input type="text" name="username" placeholder="Enter Your Username" required>
                <img src="images/user.png" alt="User Icon" class="icon">
            </div>
            <div class="input-container">
                <input type="password" name="password" placeholder="Enter Your Password" required>
                <img src="images/key.png" alt="Key Icon" class="icon">
            </div>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

            <button type="submit">Login</button>
        </form>
        <a href="forgot-password.php" class="forgot-password">Forgot Password?</a>
    </div>
</body>

</html>