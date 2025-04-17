<?php
require_once 'includes/auth.php';
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
    <link href="css/appointment.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>


    <div class="main--content">
        <div class="container">
            <div class="content-header">
                <h1>APPOINTMENT</h1>
                <div class="date-picker">
                    <span><?php echo date("M d, Y"); ?></span>
                    <span style="margin: 0 10px;">Today</span>
                    <span>📅</span>
                </div>

            </div>

            <div class="controls">
                <div class="filter-container">
                    <div class="showing">Showing: 10 Appointments</div>
                    <select class="dropdown">
                        <option>All</option>
                        <option>Scheduled</option>
                        <option>Not Confirmed</option>
                        <option>Visited</option>
                    </select>
                </div>

                <div class="search-container">
                    <input type="text" placeholder="Search" class="search-input">
                    <button class="search-btn">Search</button>
                </div>

                <button class="new-btn" id="newAppointmentBtn">
                    <span style="font-size: 18px; margin-right: 5px;">+</span> New Appointment
                </button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Service Type</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jennylyn Vinuya</td>
                        <td>Jennylyn.Vinuya@gmail.com</td>
                        <td>09********</td>
                        <td>Angat,Bulacan</td>
                        <td>April 10, 2025</td>
                        <td>Gate Automation</td>
                        <td>
                            <div class="status scheduled">🟢 Scheduled</div>
                        </td>
                        <td><button class="action-btn">⋮</button></td>
                    </tr>
                    <tr>
                        <td>Mike Dela Cruz</td>
                        <td>Mike.Dela.Cruz@gmail.com</td>
                        <td>09********</td>
                        <td>Angat,Bulacan</td>
                        <td>June 11, 2025</td>
                        <td>Sectional Garage Door</td>
                        <td>
                            <div class="status not-confirmed">🟠 Not confirmed</div>
                        </td>
                        <td><button class="action-btn">⋮</button></td>
                    </tr>
                    <tr>
                        <td>Ozzy Hernandez</td>
                        <td>Ozzy.Hernandez@gmail.com</td>
                        <td>09********</td>
                        <td>Angat,Bulacan</td>
                        <td>June 11, 2025</td>
                        <td>Roll Up Door</td>
                        <td>
                            <div class="status not-confirmed">🟠 Not confirmed</div>
                        </td>
                        <td><button class="action-btn">⋮</button></td>
                    </tr>
                    <tr>
                        <td>Angelo Agcuitan</td>
                        <td>Angelo.Agcuitan@gmail.com</td>
                        <td>09********</td>
                        <td>Baliuag,Bulacan</td>
                        <td>April 10, 2025</td>
                        <td>Smart Electric Fence Out</td>
                        <td>
                            <div class="status scheduled">🟢 Scheduled</div>
                        </td>
                        <td><button class="action-btn">⋮</button></td>
                    </tr>
                    <tr>
                        <td>Alexis Paira</td>
                        <td>Alexis.Paira@gmail.com</td>
                        <td>09********</td>
                        <td>Angat,Bulacan</td>
                        <td>June 11, 2025</td>
                        <td>Gate Fabrication</td>
                        <td>
                            <div class="status scheduled">🟢 Scheduled</div>
                        </td>
                        <td><button class="action-btn">⋮</button></td>
                    </tr>
                    <tr>
                        <td>Rossel Tiqua</td>
                        <td>Rossel.Tiqua@gmail.com</td>
                        <td>09********</td>
                        <td>Apalit,Pampangga</td>
                        <td>June 11, 2025</td>
                        <td>Smart Curtain</td>
                        <td>
                            <div class="status visited">✓ Visited</div>
                        </td>
                        <td><button class="action-btn">⋮</button></td>
                    </tr>
                </tbody>
            </table>

            <div class="pagination">
                <button class="page-btn">←</button>
                <button class="page-btn">Prev</button>
                <button class="page-btn active">Next</button>
                <span>Page:</span>
                <input type="text" class="page-input" value="1">
                <span>of 1</span>
            </div>
        </div>

        <div id="appointmentModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>New Appointment</h2>
                <form id="appointmentForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" id="fullName" name="fullName" required>
                        </div>
                        <div class="form-group">
                            <label for="availableDate">Available Date</label>
                            <input type="date" id="availableDate" name="availableDate" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" id="location" name="location" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="tel" id="phoneNumber" name="phoneNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="serviceType">Service Type</label>
                            <select id="serviceType" name="serviceType" required class="form-control">
                                <option value="" disabled selected>Select a service type</option>
                                <option value="Gate Automation">Gate Automation</option>
                                <option value="Gate Fabrication">Gate Fabrication</option>
                                <option value="Sectional Garage Door">Sectional Garage Door</option>
                                <option value="Roll Up Door">Roll Up Door</option>
                                <option value="Smart Electric Fence">Smart Electric Fence</option>
                                <option value="Smart Curtain">Smart Curtain</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Submit <span class="arrow">→</span></button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.querySelectorAll('.action-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    alert('Actions menu clicked');
                });
            });

            document.querySelector('.search-btn').addEventListener('click', () => {
                const searchTerm = document.querySelector('.search-input').value;
                alert(`Searching for: ${searchTerm}`);
            });

            document.addEventListener("DOMContentLoaded", function() {
                const modal = document.getElementById("appointmentModal");
                const openModalBtn = document.getElementById("newAppointmentBtn");
                const closeModal = document.querySelector(".close");

                modal.style.display = "none";

                openModalBtn.addEventListener("click", function() {
                    modal.style.display = "flex";
                });

                closeModal.addEventListener("click", function() {
                    modal.style.display = "none";
                });

                window.addEventListener("click", function(event) {
                    if (event.target === modal) {
                        modal.style.display = "none";
                    }
                });

                document.getElementById("appointmentForm").addEventListener("submit", function(e) {
                    e.preventDefault();

                    const fullName = document.getElementById("fullName").value;
                    const availableDate = document.getElementById("availableDate").value;
                    const email = document.getElementById("email").value;
                    const location = document.getElementById("location").value;
                    const phoneNumber = document.getElementById("phoneNumber").value;
                    const serviceType = document.getElementById("serviceType").value;

                    console.log("Form submitted:", {
                        fullName,
                        availableDate,
                        email,
                        location,
                        phoneNumber,
                        serviceType
                    });

                    modal.style.display = "none";

                    alert("Appointment created successfully!");
                });
            });
        </script>
        <?php include "includes/script.php"; ?>
</body>

</html>