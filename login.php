<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welding Workshop Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .split-container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .login-section {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 500px;
            position: relative;
            background-color: white;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.05);
        }

        .login-content {
            width: 100%;
            max-width: 400px;
        }

        .image-section {
            flex: 1.5;
            background-color: #121212;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.7) 100%);
            z-index: 1;
        }

        .image-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.05);
            filter: brightness(0.8);
            transition: transform 10s ease;
        }

        .image-section:hover img {
            transform: scale(1.15);
        }

        .slogan {
            position: absolute;
            color: white;
            z-index: 2;
            text-align: center;
            padding: 0 2rem;
        }

        .slogan h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .slogan p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 500px;
            line-height: 1.6;
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .logo-icon {
            width: 80px;
            height: 80px;

            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.8rem;
            color: #333;
        }

        h1 {
            font-size: 2.3rem;
            margin-bottom: 1rem;
            color: #222;
            text-align: center;
        }

        .subtitle {
            color: #666;
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 500;
            color: #444;
        }

        input[type="email"] {
            width: 100%;
            padding: 1rem;
            padding-left: 3rem;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-size: 1rem;
            transition: all 0.3s;
        }

        input[type="email"]:focus {
            border-color: #FF7D00;
            box-shadow: 0 0 0 2px rgba(255, 125, 0, 0.2);
            outline: none;
            background-color: white;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 2.7rem;
            color: #888;
        }

        .required:after {
            content: " *";
            color: #FF7D00;
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background-color: #FF7D00;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
            box-shadow: 0 4px 6px rgba(255, 125, 0, 0.15);
        }

        .login-btn:hover {
            background-color: #E86800;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(255, 125, 0, 0.2);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .back-link {
            position: absolute;
            top: 2rem;
            left: 2rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            z-index: 10;
            font-weight: 500;
            transition: all 0.3s;
        }

        .back-link svg {
            margin-right: 0.5rem;
        }

        .back-link:hover {
            transform: translateX(-5px);
        }

        .footer {
            margin-top: auto;
            font-size: 0.9rem;
            color: #777;
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 400px;
        }

        .footer a {
            color: #FF7D00;
            text-decoration: none;
            font-weight: 500;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .sign-up-prompt {
            text-align: center;
            margin-top: 2rem;
            color: #555;
        }

        .sign-up-prompt a {
            color: #FF7D00;
            text-decoration: none;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .sign-up-prompt a:hover {
            text-decoration: underline;
        }

        .empowering-text {
            color: #FF7D00;
            font-size: 1.6rem;
            font-weight: 700;
            margin-top: 3rem;
            letter-spacing: 1px;
            text-align: center;
            margin-bottom: 10px;
        }

        /* Verification Page Styles */
        .verification-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            background-color: white;
            flex: 1;
            position: relative;
        }

        .envelope-icon {
            background-color: #FF7D00;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 6px 15px rgba(255, 125, 0, 0.3);
        }

        .verification-title {
            font-size: 2rem;
            margin-bottom: 0.8rem;
            color: #222;
        }

        .verification-subtitle {
            color: #666;
            margin-bottom: 2rem;
            max-width: 400px;
            line-height: 1.6;
        }

        .masked-email {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 400px;
            border: 1px solid #e1e1e1;
        }

        .edit-link {
            color: #FF7D00;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .edit-link svg {
            margin-right: 0.5rem;
        }

        .verification-code {
            display: flex;
            gap: 0.8rem;
            margin-bottom: 2rem;
        }

        .code-input {
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 1.5rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .code-input:focus {
            border-color: #FF7D00;
            box-shadow: 0 0 0 2px rgba(255, 125, 0, 0.2);
            outline: none;
        }

        .resend-link {
            color: #FF7D00;
            margin-bottom: 2rem;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .resend-link:hover {
            text-decoration: underline;
        }

        .verify-btn {
            width: 100%;
            max-width: 400px;
            padding: 1rem;
            background-color: #FF7D00;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(255, 125, 0, 0.15);
        }

        .verify-btn:hover {
            background-color: #E86800;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(255, 125, 0, 0.2);
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            .split-container {
                flex-direction: column-reverse;
                height: auto;
                min-height: 100vh;
            }

            .image-section {
                height: 300px;
            }

            .login-section,
            .verification-container {
                max-width: 100%;
                padding: 2rem;
            }

            .back-link {
                top: 1rem;
                left: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Login Page -->
    <div class="split-container" id="login-page">
        <div class="login-section">
            <div class="login-content">
                <div class="logo-container">

                    <div class="logo-text">Intellitech System</div>
                </div>

                <h1>Welcome back!</h1>
                <p class="subtitle">Sign in to access your account</p>

                <form id="loginForm">
                    <div class="form-group">
                        <label for="email" class="required">Email</label>
                        <div class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6ZM20 6L12 11L4 6H20ZM20 18H4V8L12 13L20 8V18Z"
                                    fill="#888" />
                            </svg>
                        </div>
                        <input type="email" id="email" placeholder="your@email.com" required>
                    </div>

                    <button type="submit" class="login-btn">Continue</button>


                </form>

                <div class="empowering-text"></div>

                <div class="footer">
                    <span>@ 2025 Intellitech System</span>
                    <div>
                        <a href="#">Privacy Policy</a> · <a href="#">Terms</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="image-section">
            <div class="image-overlay"></div>
            <a href="index.php" class="back-link" id="backToWebsite">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5M12 19L5 12L12 5" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Back to website
            </a>
            <img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                alt="Welder working with sparks flying">

            <div class="slogan">
                <h2>ABOUT Intellitech Systems</h2>
                <p>Our company specializes in a range of advanced technologies to make your home and business smarter,
                    safer, and more efficient.</p>
            </div>
        </div>
    </div>

    <!-- Verification Page -->
    <div class="split-container" id="verification-page" style="display: none;">
        <div class="image-section">
            <div class="image-overlay"></div>
            <a href="index.php" class="back-link" id="backToWebsite2">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5M12 19L5 12L12 5" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Back to website
            </a>
            <img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                alt="Welder working with sparks flying">

            <div class="slogan">
                <h2>Verify Your Account</h2>
                <p>We're committed to keeping your account secure and protected</p>
            </div>
        </div>

        <div class="verification-container">
            <div class="logo-container">
                <div class="logo-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns=">
                        <path d=" M16 6L18 8L22 4M18 12L16 14H8L6 12M6 6L8 8H16M20 2L16 6L18 8L22 4L20 2Z"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />

                    </svg>
                </div>

            </div>

            <div class="envelope-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6ZM20 6L12 11L4 6H20ZM20 18H4V8L12 13L20 8V18Z"
                        fill="white" />
                </svg>
            </div>

            <h2 class="verification-title">Verify your email</h2>
            <p class="verification-subtitle">We've sent a verification code to your email address. Please enter it below
                to confirm your account.</p>

            <div class="masked-email">
                <span id="maskedEmail">************@gmail.com</span>
                <a href="#" class="edit-link" id="editEmail">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3 17.25V21H6.75L17.81 9.94L14.06 6.19L3 17.25ZM20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C17.98 2.9 17.35 2.9 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04Z"
                            fill="#FF7D00" />
                    </svg>
                    Edit
                </a>
            </div>

            <div class="verification-code">
                <input type="text" class="code-input" maxlength="1" id="code1">
                <input type="text" class="code-input" maxlength="1" id="code2">
                <input type="text" class="code-input" maxlength="1" id="code3">
                <input type="text" class="code-input" maxlength="1" id="code4">
                <input type="text" class="code-input" maxlength="1" id="code5">
                <input type="text" class="code-input" maxlength="1" id="code6">
            </div>

            <a href="#" class="resend-link" id="resendCode">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M17.65 6.35C16.2 4.9 14.21 4 12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20C15.73 20 18.84 17.45 19.73 14H17.65C16.83 16.33 14.61 18 12 18C8.69 18 6 15.31 6 12C6 8.69 8.69 6 12 6C13.66 6 15.14 6.69 16.22 7.78L13 11H20V4L17.65 6.35Z"
                        fill="#FF7D00" />
                </svg>
                Didn't receive any code? Resend
            </a>

            <button class="verify-btn">Verify & Continue</button>

            <div class="empowering-text">EMPOWERING YOUR CRAFT</div>

            <div class="footer">
                <span>© 2025 Weld Pro</span>
                <div>
                    <a href="#">Privacy Policy</a> · <a href="#">Terms</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;

            if (email) {
                // Display masked email on verification page
                const maskedEmail = maskEmail(email);
                document.getElementById('maskedEmail').textContent = maskedEmail;

                // Switch to verification page
                document.getElementById('login-page').style.display = 'none';
                document.getElementById('verification-page').style.display = 'flex';

                // Focus on first code input
                document.getElementById('code1').focus();
            }
        });

        // Mask email function (e.g., j***@example.com)
        function maskEmail(email) {
            const [username, domain] = email.split('@');
            const maskedUsername = username.substring(0, 1) + '*'.repeat(username.length - 1);
            return maskedUsername + '@' + domain;
        }

        // Auto-focus for verification code inputs
        const codeInputs = document.querySelectorAll('.code-input');
        codeInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value && index < codeInputs.length - 1) {
                    codeInputs[index + 1].focus();
                }
            });

            // Allow backspace to go to previous input
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    codeInputs[index - 1].focus();
                }
            });
        });

        // Edit email link
        document.getElementById('editEmail').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('verification-page').style.display = 'none';
            document.getElementById('login-page').style.display = 'flex';
            document.getElementById('email').focus();
        });


        // Resend code link
        document.getElementById('resendCode').addEventListener('click', function(e) {
            e.preventDefault();
            alert('Verification code resent!');
        });

        // Verify button functionality
        document.querySelector('.verify-btn').addEventListener('click', function(e) {
            let code = '';
            codeInputs.forEach(input => {
                code += input.value;
            });

            if (code.length === 6) {
                alert('Verification successful!');
                // Here you would redirect to the dashboard or next page
            } else {
                alert('Please enter the complete verification code');
            }
        });
    </script>
</body>

</html>