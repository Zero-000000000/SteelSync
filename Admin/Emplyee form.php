<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $position = $_POST['position'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Handle file upload
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
    }

    // Database connection (Replace with your DB credentials)
    $conn = new mysqli("localhost", "root", "", "your_database");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("INSERT INTO employees (first_name, last_name, position, phone, email, username, password, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $first_name, $last_name, $position, $phone, $email, $username, $password, $target_file);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Admin/css.css/style.css">
    <title>Add Employee</title>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <section class="content-container">
        <form action="" method="POST" enctype="multipart/form-data">
            <h2>Add Employee</h2>
            <label>Upload Photo:</label>
            <input type="file" name="profile_image" required>
            
            <label>First Name:</label>
            <input type="text" name="first_name" required>
            
            <label>Last Name:</label>
            <input type="text" name="last_name" required>
            
            <label>Position:</label>
            <input type="text" name="position" required>
            
            <label>Phone Number:</label>
            <input type="text" name="phone" required>
            
            <label>Email Address:</label>
            <input type="email" name="email" required>
            
            <label>Username:</label>
            <input type="text" name="username" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Submit</button>
        </form>
    </section>
</body>
</html>
