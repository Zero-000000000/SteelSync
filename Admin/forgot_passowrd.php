<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SteelSync - Forgot Password</title>
    <link rel="stylesheet" href="css.css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .back-to-login {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        .back-to-login:hover {
            text-decoration: underline;
        }

        .form-instructions {
            text-align: center;
            font-size: 14px;
            margin-bottom: 15px;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="../images/Group 70.png" alt="SteelSync Logo">
        </div>
        <h2>SteelSync</h2>
        <p>PASSWORD RECOVERY</p>

        <!-- Message container - will be populated by PHP -->
        <div class="message success" style="display: none;">
            Password reset instructions have been sent to your email address.
        </div>

        <div class="form-instructions">
            Please enter your username and email address to recover your password.
        </div>

        <form method="POST" action="">
            <div class="input-container">
                <input type="text" name="username" placeholder="Enter Your Username" required>
                <img src="../images/user.png" alt="User Icon" class="icon">
            </div>

            <div class="input-container">
                <input type="email" name="email" placeholder="Enter Your Email Address" required>
                <i class="fas fa-envelope icon"></i>
            </div>

            <button type="submit">Reset Password</button>
        </form>

        <a href="login.php" class="back-to-login">Back to Login</a>
    </div>
</body>

</html>