<?php include 'includes/style.php'; ?>
<?php include 'includes/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff8c42;
            --primary-dark: #e67e38;
            --secondary-color: #4a4a4a;
            --light-gray: #f7f7f7;
            --mid-gray: #e0e0e0;
            --dark-gray: #333333;
            --accent-color: #ffc58f;
            --bg-light: #f7f7f7;
        }

        * {
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Arial', sans-serif;
            background-color: var(--bg-light);
            line-height: 1.6;
            color: var(--text-dark);
        }

        .contact-container {
            max-width: 700px;
            width: 100%;
            margin-top: 50px;
            margin-bottom: 50px;
            margin-left: auto;
            margin-right: auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        .contact-header {
            margin-bottom: 25px;
            text-align: center;
        }

        .contact-header h1 {
            margin: 0;
            font-weight: 600;
            font-size: 2.2rem;
            color: var(--secondary-color);
        }

        .contact-header p {
            color: var(--secondary-color);
            opacity: 0.8;
            margin-top: 10px;
        }

        .form-floating {
            margin-bottom: 20px;
            position: relative;
        }

        .form-control {
            border: 1px solid var(--mid-gray);
            border-radius: 8px;
            padding: 12px 20px 12px 45px;
            background-color: var(--light-gray);
            transition: all 0.3s ease;
            font-size: 1rem;
            height: auto;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.2);
            background-color: white;
            border-color: var(--primary-color);
        }

        .form-floating>.form-control {
            padding-top: 25px;
            padding-bottom: 10px;
            padding-left: 45px;
        }

        .form-floating>label {
            padding: 12px 20px 12px 45px;
            color: var(--secondary-color);
            opacity: 0.8;
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .name-row {
            display: flex;
            gap: 15px;
        }

        .name-row .form-floating {
            flex: 1;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 17px;
            color: var(--primary-color);
            z-index: 10;
        }

        .textarea-icon {
            top: 17px;
        }

        .custom-checkbox {
            margin-bottom: 20px;
        }

        .custom-checkbox .form-check-input {
            width: 18px;
            height: 18px;
            margin-top: 0.2em;
            border: 1px solid var(--mid-gray);
        }

        .custom-checkbox .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .custom-checkbox .form-check-label {
            padding-left: 8px;
            color: var(--secondary-color);
        }

        .success-message {
            display: none;
            background-color: #e8f5e9;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-top: 20px;
        }

        .success-message h5 {
            color: #2e7d32;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .success-message p {
            color: #388e3c;
            margin-bottom: 15px;
        }

        .return-btn {
            background-color: transparent;
            border: 1px solid #4caf50;
            color: #2e7d32;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .return-btn:hover {
            background-color: rgba(76, 175, 80, 0.1);
        }

        .form-feedback {
            font-size: 0.85rem;
            color: #d32f2f;
            margin-top: 5px;
            display: none;
        }

        @media (max-width: 576px) {
            .name-row {
                flex-direction: column;
                gap: 15px;
            }

            .contact-container {
                padding: 20px;
            }

            .contact-header h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="contact-container">
        <div class="contact-header">
            <h1>Contact Us</h1>
            <p>We'd love to hear from you!</p>
        </div>

        <form id="contactForm">
            <div class="name-row">
                <div class="form-floating form-label-group">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" id="firstName" placeholder="First Name" required>
                    <label for="firstName">First Name</label>
                    <div class="form-feedback" id="firstNameFeedback">Please enter your first name</div>
                </div>

                <div class="form-floating form-label-group">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" id="lastName" placeholder="Last Name" required>
                    <label for="lastName">Last Name</label>
                    <div class="form-feedback" id="lastNameFeedback">Please enter your last name</div>
                </div>
            </div>

            <div class="form-floating form-label-group">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" class="form-control" id="email" placeholder="Email Address" required>
                <label for="email">Email Address</label>
                <div class="form-feedback" id="emailFeedback">Please enter a valid email address</div>
            </div>

            <div class="form-floating form-label-group">
                <i class="fas fa-phone input-icon"></i>
                <input type="tel" class="form-control" id="phone" placeholder="Phone Number" required>
                <label for="phone">Phone Number</label>
                <div class="form-feedback" id="phoneFeedback">Please enter a valid phone number</div>
            </div>

            <div class="form-floating form-label-group">
                <i class="fas fa-comment input-icon textarea-icon"></i>
                <textarea class="form-control" id="message" placeholder="Your Message" required></textarea>
                <label for="message">Your Message</label>
                <div class="form-feedback" id="messageFeedback">Please enter your message</div>
            </div>

            <div class="form-check custom-checkbox">
                <input class="form-check-input" type="checkbox" id="privacyCheck" required>
                <label class="form-check-label" for="privacyCheck">
                    I agree to the privacy policy
                </label>
                <div class="form-feedback" id="privacyFeedback">You must agree to continue</div>
            </div>

            <button type="submit" class="btn btn-primary">
                Send Message <i class="fas fa-paper-plane ms-1"></i>
            </button>
        </form>

        <div class="success-message" id="successMessage">
            <h5><i class="fas fa-check-circle me-2"></i> Thank you for your message!</h5>
            <p>We've received your inquiry and will get back to you as soon as possible.</p>
            <button class="return-btn" id="returnToFormBtn">
                <i class="fas fa-reply me-1"></i> Send Another Message
            </button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.getElementById('contactForm');
            const successMessage = document.getElementById('successMessage');
            const returnToFormBtn = document.getElementById('returnToFormBtn');

            // Feedback elements
            const feedbackElements = {
                firstName: document.getElementById('firstNameFeedback'),
                lastName: document.getElementById('lastNameFeedback'),
                email: document.getElementById('emailFeedback'),
                phone: document.getElementById('phoneFeedback'),
                message: document.getElementById('messageFeedback'),
                privacy: document.getElementById('privacyFeedback')
            };

            // Reset form function
            function resetForm() {
                contactForm.reset();
                contactForm.style.display = 'block';
                successMessage.style.display = 'none';

                // Reset all validation states
                const inputs = contactForm.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    input.classList.remove('is-invalid');
                });

                // Hide all feedback messages
                Object.values(feedbackElements).forEach(element => {
                    element.style.display = 'none';
                });

                // Reset submit button
                const submitButton = contactForm.querySelector('button[type="submit"]');
                submitButton.disabled = false;
                submitButton.innerHTML = 'Send Message <i class="fas fa-paper-plane ms-1"></i>';
            }

            // Return to form button
            returnToFormBtn.addEventListener('click', function() {
                resetForm();
            });

            // Form validation and submission
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Reset validation states
                const inputs = contactForm.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    input.classList.remove('is-invalid');
                });

                // Hide all feedback messages
                Object.values(feedbackElements).forEach(element => {
                    element.style.display = 'none';
                });

                // Validation flags
                let formValid = true;

                // Required fields validation
                inputs.forEach(input => {
                    if (input.hasAttribute('required') && !input.value.trim()) {
                        formValid = false;
                        input.classList.add('is-invalid');

                        // Show appropriate feedback
                        if (feedbackElements[input.id]) {
                            feedbackElements[input.id].style.display = 'block';
                        }
                    }
                });

                // Email validation
                const emailInput = document.getElementById('email');
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailInput.value && !emailPattern.test(emailInput.value)) {
                    formValid = false;
                    emailInput.classList.add('is-invalid');
                    feedbackElements.email.style.display = 'block';
                }

                // Phone validation
                const phoneInput = document.getElementById('phone');
                if (phoneInput.value && !/^[0-9+\-\s()]{6,20}$/.test(phoneInput.value)) {
                    formValid = false;
                    phoneInput.classList.add('is-invalid');
                    feedbackElements.phone.style.display = 'block';
                }

                // Privacy check validation
                const privacyCheck = document.getElementById('privacyCheck');
                if (!privacyCheck.checked) {
                    formValid = false;
                    privacyCheck.classList.add('is-invalid');
                    feedbackElements.privacy.style.display = 'block';
                }

                // Process if valid
                if (formValid) {
                    // Show loading state
                    const submitButton = contactForm.querySelector('button[type="submit"]');
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

                    // Simulate form submission (1.2 second delay)
                    setTimeout(() => {
                        contactForm.style.display = 'none';
                        successMessage.style.display = 'block';

                        // Form data (for demonstration)
                        const formData = {
                            firstName: document.getElementById('firstName').value,
                            lastName: document.getElementById('lastName').value,
                            email: document.getElementById('email').value,
                            phone: document.getElementById('phone').value,
                            message: document.getElementById('message').value,
                            privacyAgreed: document.getElementById('privacyCheck').checked
                        };

                        console.log('Form submitted:', formData);
                    }, 1200);
                }
            });

            // Real-time validation
            const inputs = contactForm.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (input.value.trim()) {
                        input.classList.remove('is-invalid');

                        // Hide feedback
                        if (feedbackElements[input.id]) {
                            feedbackElements[input.id].style.display = 'none';
                        }
                    }
                });
            });

            // Privacy checkbox
            const privacyCheck = document.getElementById('privacyCheck');
            privacyCheck.addEventListener('change', function() {
                if (this.checked) {
                    this.classList.remove('is-invalid');
                    feedbackElements.privacy.style.display = 'none';
                }
            });
        });
    </script>

    <?php include 'includes/footer.php'; ?>

    <?php include "includes/main.php"; ?>
</body>

</html>