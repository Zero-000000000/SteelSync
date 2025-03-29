<?php
session_start();

// If user is already logged in, redirect to index
if (isset($_SESSION["user"])) {
    header("Location: index.php");
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

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (md5($password) === $hashed_password) {
            $_SESSION["user"] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SteelSync - Login</title>
    <link rel="stylesheet" href="css.css/login.css">

</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="../images/Group 70.png" alt="SteelSync Logo">
        </div>
        <h2>SteelSync</h2>
        <p>A WEB-BASED SYSTEM FOR METAL & STEEL FABRICATION</p>
        <form method="POST" action="">
            <div class="input-container">
                <input type="text" name="username" placeholder="Enter Your Username" required>
                <img src="../images/user.png" alt="User Icon" class="icon">
            </div>
            <div class="input-container">
                <input type="password" name="password" placeholder="Enter Your Password" required>
                <img src="../images/key.png" alt="Key Icon" class="icon">
            </div>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

            <button type="submit">Login</button>
        </form>
        <a href="#" class="forgot-password">Forgot Password?</a>
    </div>
</body>

</html>