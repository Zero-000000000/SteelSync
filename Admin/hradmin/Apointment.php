<?php
session_start();

// Redirect to login if no user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: /steelsync/admin/login.php");
    exit();
}
// Verify the user has the correct role
if ($_SESSION["role"] !== 'hr_admin') {
    // Redirect to appropriate page or show error

    header("Location: /steelsync/admin/login.php");
    exit();
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
    <link href="css.css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        .main--content {
            position: absolute;
            top: 60px;
            right: 0;
            height: 100%;
            width: calc(100% - 300px);
            padding: 20px;
            overflow-y: auto;
            background-color: #f7f7f7;
            transition: .3s;
        }

        .main--content.active {
            width: calc(100% - 103px);
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            font-size: 24px;
        }

        .header .date-picker {
            background: #fff;
            border: 1px solid #ddd;
            padding: 5px 10px;
            cursor: pointer;
        }

        .appointment-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .appointment-table th,
        .appointment-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .appointment-table th {
            background: #f4f4f4;
            text-align: left;
        }

        .btn-new {
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            float: right;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .content-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .date-picker {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
        }

        .date-picker i {
            margin-left: 10px;
        }

        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }

        .filter-container {
            display: flex;
            gap: 10px;
        }

        .dropdown {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            min-width: 100px;
        }

        .search-container {
            display: flex;
            gap: 10px;
        }

        .search-input {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 250px;
        }

        .search-btn {
            padding: 8px 20px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }

        .new-btn {
            padding: 10px 20px;
            background-color: #e91e63;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .new-btn i {
            margin-right: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tbody td {
            font-size: 13px;
        }

        table tbody td:first-child {
            white-space: nowrap;
            font-size: 14px;
        }

        th {
            background-color: #f8f9fa;
            text-align: left;
            padding: 12px 20px;
            font-weight: bold;
            color: #333;
            border-bottom: 1px solid #ddd;
        }

        td {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            color: #333;
        }

        .status {
            white-space: nowrap;
            display: flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 13px;
        }

        .status.scheduled {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        .status.not-confirmed {
            background-color: #fff8e1;
            color: #ffa000;
        }

        .status.visited {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .status i {
            margin-right: 5px;
        }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: #666;
        }

        .pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 15px 20px;
            gap: 10px;
        }

        .page-btn {
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            cursor: pointer;
        }

        .page-btn.active {
            background-color: #ff9800;
            color: white;
            border-color: #ff9800;
        }

        .page-input {
            width: 50px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal .form-group input,
        .modal .form-group select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            height: 40px;
        }

        .modal .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 25px;
            border-radius: 8px;
            width: 600px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .modal-content h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 20px;
            color: #333;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 16px;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 14px;
            margin-bottom: 6px;
            color: #333;
        }

        .form-group input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .submit-btn {
            background-color: #3d7cf9;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .arrow {
            margin-left: 5px;
        }
    </style>
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