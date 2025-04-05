<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SteelSync - OTP Verification</title>
    <link rel="stylesheet" href="css.css/login.css">
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Additional styles for OTP input */
        .verification-message {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
            font-size: 14px;
        }

        .resend-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #0066cc;
            text-decoration: none;
        }

        .resend-link:hover {
            text-decoration: underline;
        }

        .single-input {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            text-align: center;
            letter-spacing: 8px;
        }

        .success {
            color: green;
            text-align: center;
            margin: 10px 0;
        }

        /* Font Awesome icon styling */
        .icon {
            color: #555;
            font-size: 20px;
        }

        .input-container {
            position: relative;
        }

        .input-container .fa-shield-halved {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
        }

        /* Additional Font Awesome styling */
        .resend-link i {
            margin-right: 5px;
        }

        .back-to-login i {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="../images/Group 70.png" alt="SteelSync Logo">
        </div>
        <h2>SteelSync</h2>
        <p>A WEB-BASED SYSTEM FOR METAL & STEEL FABRICATION</p>

        <div class="verification-message">
            <i class="fa-solid fa-envelope"></i> Please enter the verification code sent to your registered email.
        </div>

        <form method="POST" action="">
            <div class="input-container">
                <input type="text" name="otp" class="single-input" placeholder="000000" maxlength="6" pattern="[0-9]{6}"
                    required>
                <i class="fa-solid fa-shield-halved icon"></i>
            </div>

            <!-- Error message placeholder - will be populated by PHP -->
            <!-- <p class="error">Invalid verification code</p> -->

            <!-- Success message placeholder - will be populated by PHP -->
            <!-- <p class="success">For testing: Your OTP is 123456</p> -->

            <button type="submit"><i class="fa-solid fa-check"></i> Verify</button>
        </form>

        <a href="verify_otp.php?resend=1" class="resend-link"><i class="fa-solid fa-rotate"></i> Resend Code</a>
        <a href="login.php" class="forgot-password back-to-login"><i class="fa-solid fa-arrow-left"></i> Back to
            Login</a>
    </div>

    <script>
        // Auto-focus and auto-submit when all digits are entered
        document.addEventListener('DOMContentLoaded', function() {
            const otpInput = document.querySelector('input[name="otp"]');

            otpInput.addEventListener('input', function() {
                // Keep only numbers
                this.value = this.value.replace(/[^0-9]/g, '');

                // Auto-submit when all 6 digits are entered
                if (this.value.length === 6) {
                    // Optional: add small delay before submit to give visual feedback
                    setTimeout(() => {
                        this.form.submit();
                    }, 200);
                }
            });

            // Focus on the input field when page loads
            otpInput.focus();
        });
    </script>
</body>

</html>