<?php include 'includes/style.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link href="css/contact.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">


</head>

<body>
    <?php include 'includes/navbar.php'; ?>
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