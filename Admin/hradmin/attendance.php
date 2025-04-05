<?php
session_start();

// Redirect to login if no user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: /steelsync/admin/login.php");
    exit();
}
// Verify the user has the correct role
if ($_SESSION["role"] !== 'hr_admin') {
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
        /* Main content styles */
        .main--content {
            padding: 20px;
            background-color: #f5f7fa;
            min-height: calc(100vh - 60px);
            margin-left: 300px;
            transition: margin-left 0.3s;
        }

        /* Attendance container */
        .attendance-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Header with title */
        .attendance-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .attendance-header h2 {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            color: #333;
        }

        /* Action buttons */
        .attendance-actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            background-color: #ff7a00;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
        }

        .action-btn:hover {
            background-color: #e56f00;
        }

        /* Filter and search section */
        .filter-search {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            align-items: center;
        }

        .dropdown select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 150px;
            outline: none;
        }

        .search-container {
            display: flex;
            gap: 10px;
        }

        .search-container input {
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 250px;
            outline: none;
        }

        .search-btn {
            background-color: #ff7a00;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-btn:hover {
            background-color: #e56f00;
        }

        /* Attendance table */
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .attendance-table th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
            text-align: left;
            padding: 15px 12px;
            border-bottom: 2px solid #eee;
        }

        .attendance-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            color: #555;
        }

        .attendance-table tr:hover {
            background-color: #f9f9f9;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }

        .page-btn {
            background-color: #f0f0f0;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
        }

        .page-btn:hover:not(:disabled) {
            background-color: #e0e0e0;
        }

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .active-page {
            background-color: #ff7a00;
            color: white;
        }

        .page-info {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .page-input {
            width: 40px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 3px;
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
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background-color: #fff;
            margin: 50px auto;
            width: 90%;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            animation: slideIn 0.3s;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close:hover {
            color: #555;
        }

        .modal-body {
            padding: 20px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-options {
            margin: 15px 0;
        }

        .checkbox-group {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .checkbox-group input[type="checkbox"] {
            margin-right: 8px;
            width: auto;
        }

        .checkbox-list {
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #eee;
            padding: 10px;
            border-radius: 5px;
        }

        .custom-date-range {
            margin-top: 15px;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .cancel-btn {
            background-color: #6c757d;
        }

        .cancel-btn:hover {
            background-color: #5a6268;
        }

        /* File upload styles */
        .upload-preview {
            margin-top: 15px;
            padding: 10px;
            border: 1px dashed #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            min-height: 60px;
        }

        #fileInput {
            border: 1px solid #ddd;
            padding: 8px;
            width: 100%;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>

    <div class="main--content">
        <div class="attendance-container">
            <div class="attendance-header">
                <h2>ATTENDANCE</h2>
                <button class="action-btn" onclick="window.location.href='Employee_list.php';">
                    <i class="fas fa-file-export"></i> View Report
                </button>
                <div class="attendance-actions">

                    <button class="action-btn">
                        <i class="fas fa-file-import"></i> Import
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-file-export"></i> Export
                    </button>

                </div>
            </div>

            <div class="filter-search">
                <div class="dropdown">
                    <select id="filterDropdown">
                        <option value="all">All</option>
                        <option value="administrator">Administrator</option>
                        <option value="employee">Employee</option>
                    </select>
                </div>
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search">
                    <button class="search-btn">Search</button>
                </div>
            </div>

            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Position</th>
                        <th>Contact Number</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Total Hours</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

            <div class="pagination">
                <button class="page-btn" id="prevBtn" disabled>
                    <i class="fas fa-chevron-left"></i> Prev
                </button>

                <button class="page-btn" id="nextBtn">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
                <div class="page-info">
                    Page: <input type="text" class="page-input" value="1"> of 4
                </div>
            </div>
        </div>
        <div id="importModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Import Attendance Data</h2>
                    <span class="close" id="closeImportModal">&times;</span>
                </div>
                <div class="modal-body">
                    <p>Select a CSV or Excel file containing attendance data to import:</p>
                    <form id="importForm">
                        <div class="form-group">
                            <label for="fileInput">Choose File:</label>
                            <input type="file" id="fileInput" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        </div>
                        <div class="form-options">
                            <div class="checkbox-group">
                                <input type="checkbox" id="headerRow" checked>
                                <label for="headerRow">First row contains headers</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" id="replaceExisting">
                                <label for="replaceExisting">Replace existing data</label>
                            </div>
                        </div>
                        <div class="upload-preview" id="filePreview">
                            <p>No file selected</p>
                        </div>
                        <div class="form-buttons">
                            <button type="button" class="action-btn cancel-btn" id="cancelImport">Cancel</button>
                            <button type="button" class="action-btn" id="submitImport">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="exportModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Export Attendance Data</h2>
                    <span class="close" id="closeExportModal">&times;</span>
                </div>
                <div class="modal-body">
                    <p>Select export options:</p>
                    <form id="exportForm">
                        <div class="form-group">
                            <label for="exportFormat">Format:</label>
                            <select id="exportFormat">
                                <option value="csv">CSV</option>
                                <option value="excel">Excel</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dateRange">Date Range:</label>
                            <select id="dateRange">
                                <option value="all">All data</option>
                                <option value="today">Today</option>
                                <option value="week">This week</option>
                                <option value="month">This month</option>
                                <option value="custom">Custom range</option>
                            </select>
                        </div>
                        <div class="custom-date-range" id="customDateRange" style="display: none;">
                            <div class="form-group">
                                <label for="startDate">From:</label>
                                <input type="date" id="startDate">
                            </div>
                            <div class="form-group">
                                <label for="endDate">To:</label>
                                <input type="date" id="endDate">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exportFields">Fields to export:</label>
                            <div class="checkbox-list">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="field_name" checked>
                                    <label for="field_name">Employee Name</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" id="field_position" checked>
                                    <label for="field_position">Position</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" id="field_contact" checked>
                                    <label for="field_contact">Contact Number</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" id="field_timeIn" checked>
                                    <label for="field_timeIn">Time In</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" id="field_timeOut" checked>
                                    <label for="field_timeOut">Time Out</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" id="field_totalHours" checked>
                                    <label for="field_totalHours">Total Hours</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-buttons">
                            <button type="button" class="action-btn cancel-btn" id="cancelExport">Cancel</button>
                            <button type="button" class="action-btn" id="submitExport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sample data of employees
            const employeeData = [{
                    id: 1,
                    name: "Joel Ponce",
                    role: "employee",
                    position: "Training & Control Operations Manager"
                },
                {
                    id: 2,
                    name: "Reinalyn Domdom",
                    role: "employee",
                    position: "Sales Staff"
                },
                {
                    id: 3,
                    name: "Kylie Emplamado",
                    role: "employee",
                    position: "Office Staff/Sales Clerk"
                },
                {
                    id: 4,
                    name: "Aerah Mae Valero",
                    role: "employee",
                    position: "Accounting & Inventory"
                },
                {
                    id: 5,
                    name: "King Sison",
                    role: "employee",
                    position: "Senior Supervisor"
                },
                {
                    id: 6,
                    name: "Jerome Royo",
                    role: "employee",
                    position: "Fabrication Team Leader"
                },
                {
                    id: 7,
                    name: "Emmanuel Benito",
                    role: "employee",
                    position: "Site Team Leader"
                },
                {
                    id: 8,
                    name: "Frankeddrey Ferrer",
                    role: "employee",
                    position: "Skilled Welder/Driver"
                },
                {
                    id: 9,
                    name: "Rodel Rempillo",
                    role: "employee",
                    position: "Site Supervisor"
                },
                {
                    id: 10,
                    name: "Allan Sapul",
                    role: "employee",
                    position: "TL/Skilled Welder"
                },
                {
                    id: 11,
                    name: "Rasty Serrano",
                    role: "employee",
                    position: "Skilled Welder"
                },
                {
                    id: 12,
                    name: "Philip Parilla",
                    role: "employee",
                    position: "Fabrication Supervisor"
                },
                {
                    id: 13,
                    name: "Engelbert Guliman",
                    role: "employee",
                    position: "Fab Helper"
                },
                {
                    id: 14,
                    name: "Ericzon Cunanan",
                    role: "employee",
                    position: "Welder"
                },
                {
                    id: 15,
                    name: "Edrian Espino Napisa",
                    role: "employee",
                    position: "Welder"
                },
                {
                    id: 16,
                    name: "Christian Espiritu",
                    role: "employee",
                    position: "Welder/Driver"
                },
                {
                    id: 17,
                    name: "Johnrey Castillo",
                    role: "employee",
                    position: "Skilled Welder/Driver"
                },
                {
                    id: 18,
                    name: "Ronnie Enriquez",
                    role: "employee",
                    position: "Helper - Welder"
                },
                {
                    id: 19,
                    name: "Billy Montero",
                    role: "employee",
                    position: "Helper - Mason"
                },
                {
                    id: 20,
                    name: "John Michael Libanan",
                    role: "employee",
                    position: "Helper - Welder"
                },
                {
                    id: 21,
                    name: "Piolo Sabater",
                    role: "employee",
                    position: "Electrician /Site Supervisor"
                },
                {
                    id: 22,
                    name: "Fernando Dulay Jr.",
                    role: "employee",
                    position: "Electrician /Team Leader"
                },
                {
                    id: 23,
                    name: "Rande Sorio",
                    role: "employee",
                    position: "Skilled Electrician/team leader"
                },
                {
                    id: 24,
                    name: "Rizaldo San Pedro",
                    role: "employee",
                    position: "Paint Supervisor"
                },
                {
                    id: 25,
                    name: "George Pica",
                    role: "employee",
                    position: "Skilled Painter"
                },
                {
                    id: 26,
                    name: "Joraydan Briones",
                    role: "employee",
                    position: "Skilled Painter"
                },
                {
                    id: 27,
                    name: "Jayson Auton",
                    role: "employee",
                    position: "Skilled Painter"
                },
                {
                    id: 28,
                    name: "Ronel Yesan",
                    role: "employee",
                    position: "Skilled Painter"
                },
                {
                    id: 29,
                    name: "Richard Cabiad",
                    role: "employee",
                    position: "Skilled Painter"
                },
                {
                    id: 30,
                    name: "Anabelle Austria",
                    role: "administrator",
                    position: "Purchaser"
                },
                {
                    id: 31,
                    name: "Milen San Jose",
                    role: "administrator",
                    position: "HR Manager/Admin"
                }
            ];

            // Positions for each role
            const positions = {
                employee: [
                    "Training & Control Operations Manager",
                    "Sales Staff",
                    "Office Staff/Sales Clerk",
                    "Accounting & Inventory",
                    "Senior Supervisor",
                    "Fabrication Team Leader",
                    "Site Team Leader",
                    "Skilled Welder/Driver",
                    "Site Supervisor",
                    "TL/Skilled Welder",
                    "Skilled Welder",
                    "Fabrication Supervisor",
                    "Fab Helper",
                    "Welder",
                    "Welder/Driver",
                    "Helper - Welder",
                    "Helper - Mason",
                    "Electrician /Site Supervisor",
                    "Electrician /Team Leader",
                    "Skilled Electrician/team leader",
                    "Paint Supervisor",
                    "Skilled Painter",
                    "Driver - Helper"
                ],
                administrator: [
                    "HR Manager/Admin",
                    "Purchaser"
                ]
            };

            // Function to generate random time between 6:00 AM and 9:00 AM
            function generateTimeIn() {
                const hours = Math.floor(Math.random() * 3) + 6; // 6-8
                const minutes = Math.floor(Math.random() * 60);
                const ampm = "AM";
                return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')} ${ampm}`;
            }

            // Function to generate random time between 4:00 PM and 6:00 PM
            function generateTimeOut() {
                const hours = Math.floor(Math.random() * 3) + 16; // 16-18 (4PM-6PM)
                const minutes = Math.floor(Math.random() * 60);
                const ampm = "PM";
                const displayHours = hours > 12 ? hours - 12 : hours;
                return `${displayHours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')} ${ampm}`;
            }

            // Calculate total hours between time in and time out
            function calculateTotalHours(timeIn, timeOut) {
                const [inTime, inAmPm] = timeIn.split(' ');
                const [outTime, outAmPm] = timeOut.split(' ');

                let [inHours, inMinutes] = inTime.split(':').map(Number);
                let [outHours, outMinutes] = outTime.split(':').map(Number);

                // Convert to 24-hour format
                if (inAmPm === 'PM' && inHours !== 12) inHours += 12;
                if (inAmPm === 'AM' && inHours === 12) inHours = 0;
                if (outAmPm === 'PM' && outHours !== 12) outHours += 12;
                if (outAmPm === 'AM' && outHours === 12) outHours = 0;

                // Calculate difference in hours and minutes
                let hoursDiff = outHours - inHours;
                let minutesDiff = outMinutes - inMinutes;

                if (minutesDiff < 0) {
                    hoursDiff--;
                    minutesDiff += 60;
                }

                return hoursDiff + (minutesDiff / 60);
            }

            // Function to generate random phone number
            function generatePhoneNumber() {
                return `+63 ${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}`;
            }

            // Generate attendance data for all employees
            function generateAttendanceData() {
                return employeeData.map(employee => {
                    const timeIn = generateTimeIn();
                    const timeOut = generateTimeOut();
                    const totalHours = calculateTotalHours(timeIn, timeOut).toFixed(2);

                    return {
                        name: employee.name,
                        position: employee.position,
                        contactNumber: generatePhoneNumber(),
                        timeIn: timeIn,
                        timeOut: timeOut,
                        totalHours: totalHours,
                        role: employee.role
                    };
                });
            }

            // Initialize attendance data
            const attendanceData = generateAttendanceData();

            // Items per page
            const itemsPerPage = 10;
            let currentPage = 1;

            // Function to render the table with attendance data
            function renderTable(data, page = 1) {
                const tableBody = document.querySelector('.attendance-table tbody');
                tableBody.innerHTML = '';

                // Calculate start and end indices for current page
                const startIndex = (page - 1) * itemsPerPage;
                const endIndex = Math.min(startIndex + itemsPerPage, data.length);

                const pageData = data.slice(startIndex, endIndex);

                // Create table rows for current page data
                pageData.forEach(employee => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td>${employee.name}</td>
                <td>${employee.position}</td>
                <td>${employee.contactNumber}</td>
                <td>${employee.timeIn}</td>
                <td>${employee.timeOut}</td>
                <td>${employee.totalHours}</td>
            `;
                    tableBody.appendChild(row);
                });

                // Update pagination
                updatePagination(data.length, page);
            }

            // Function to update pagination controls
            function updatePagination(totalItems, currentPage) {
                const totalPages = Math.ceil(totalItems / itemsPerPage);

                // Update page buttons
                const paginationContainer = document.querySelector('.pagination');
                const pageButtons = paginationContainer.querySelectorAll('button:not(#prevBtn):not(#nextBtn)');

                // Clear existing page buttons
                pageButtons.forEach(button => {
                    if (!button.id) button.remove();
                });

                // Add new page buttons
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');

                // Always show first page, last page, and pages around current page
                const pagesToShow = new Set();
                pagesToShow.add(1); // First page
                pagesToShow.add(totalPages); // Last page

                // Pages around current page
                for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
                    pagesToShow.add(i);
                }

                const sortedPages = [...pagesToShow].sort((a, b) => a - b);

                // Insert the page buttons before the next button
                sortedPages.forEach(page => {
                    const button = document.createElement('button');
                    button.className = 'page-btn';
                    button.textContent = page;
                    if (page === currentPage) {
                        button.classList.add('active-page');
                    }

                    button.addEventListener('click', function() {
                        goToPage(page);
                    });

                    paginationContainer.insertBefore(button, nextBtn);
                });

                // Update prev/next button states
                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = currentPage === totalPages;

                // Update page input
                const pageInput = document.querySelector('.page-input');
                pageInput.value = currentPage;

                // Update total pages display
                const pageInfoText = pageInput.nextSibling;
                pageInfoText.textContent = ` of ${totalPages}`;
            }

            // Function to go to a specific page
            function goToPage(page) {
                currentPage = page;
                renderTable(filteredData, currentPage);
            }

            // Initial filtered data is all data
            let filteredData = [...attendanceData];

            // Filter functionality
            const filterDropdown = document.getElementById('filterDropdown');

            filterDropdown.addEventListener('change', function() {
                const filterValue = this.value;

                if (filterValue === 'all') {
                    filteredData = [...attendanceData];
                } else {
                    filteredData = attendanceData.filter(employee => employee.role === filterValue);
                }

                currentPage = 1;
                renderTable(filteredData, currentPage);
            });

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.querySelector('.search-btn');

            searchBtn.addEventListener('click', function() {
                performSearch();
            });

            // Allow search on Enter key
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });

            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase();

                if (searchTerm.trim() === '') {
                    // If search is empty, reset to filtered state by role
                    filterDropdown.dispatchEvent(new Event('change'));
                    return;
                }

                // Filter based on current role filter first
                let roleFiltered;
                const filterValue = filterDropdown.value;

                if (filterValue === 'all') {
                    roleFiltered = [...attendanceData];
                } else {
                    roleFiltered = attendanceData.filter(employee => employee.role === filterValue);
                }

                // Then filter by search term
                filteredData = roleFiltered.filter(employee =>
                    employee.name.toLowerCase().includes(searchTerm) ||
                    employee.position.toLowerCase().includes(searchTerm) ||
                    employee.contactNumber.toLowerCase().includes(searchTerm)
                );

                currentPage = 1;
                renderTable(filteredData, currentPage);
            }

            // Pagination event listeners
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const pageInput = document.querySelector('.page-input');

            prevBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    goToPage(currentPage - 1);
                }
            });

            nextBtn.addEventListener('click', function() {
                const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                if (currentPage < totalPages) {
                    goToPage(currentPage + 1);
                }
            });

            pageInput.addEventListener('change', function() {
                const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                let page = parseInt(this.value);

                if (isNaN(page) || page < 1) {
                    page = 1;
                } else if (page > totalPages) {
                    page = totalPages;
                }

                goToPage(page);
            });

            // Sidebar toggle functionality
            const sidebarToggle = document.querySelector('.menu-btn');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main--content');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    if (sidebar.classList.contains('active')) {
                        mainContent.style.marginLeft = '103px';
                    } else {
                        mainContent.style.marginLeft = '300px';
                    }
                });
            }

            // Import button functionality
            const importBtn = document.querySelector('.action-btn:first-child');
            if (importBtn) {
                importBtn.addEventListener('click', function() {
                    alert('Import feature will be available in the next update.');
                });
            }

            // Export button functionality
            const exportBtn = document.querySelector('.action-btn:last-child');
            if (exportBtn) {
                exportBtn.addEventListener('click', function() {
                    alert('Exporting attendance data...');
                    // Here you would implement actual export functionality
                });
            }

            // Initialize the table with all data
            renderTable(filteredData, currentPage);
        });
    </script>
    <script>
        // Get modal elements
        const importModal = document.getElementById('importModal');
        const exportModal = document.getElementById('exportModal');

        // Get buttons
        const importBtn = document.querySelector('.action-btn:first-child');
        const exportBtn = document.querySelector('.action-btn:last-child');

        // Get close buttons
        const closeImportModal = document.getElementById('closeImportModal');
        const closeExportModal = document.getElementById('closeExportModal');
        const cancelImport = document.getElementById('cancelImport');
        const cancelExport = document.getElementById('cancelExport');

        // Get form elements
        const dateRangeSelect = document.getElementById('dateRange');
        const customDateRange = document.getElementById('customDateRange');
        const fileInput = document.getElementById('fileInput');
        const filePreview = document.getElementById('filePreview');
        const submitImport = document.getElementById('submitImport');
        const submitExport = document.getElementById('submitExport');

        // Open import modal
        importBtn.addEventListener('click', function() {
            importModal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling behind modal
        });

        // Open export modal
        exportBtn.addEventListener('click', function() {
            exportModal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling behind modal
        });

        // Close modals
        function closeModal(modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        closeImportModal.addEventListener('click', () => closeModal(importModal));
        closeExportModal.addEventListener('click', () => closeModal(exportModal));
        cancelImport.addEventListener('click', () => closeModal(importModal));
        cancelExport.addEventListener('click', () => closeModal(exportModal));

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === importModal) {
                closeModal(importModal);
            }
            if (event.target === exportModal) {
                closeModal(exportModal);
            }
        });

        // Show/hide custom date range based on selection
        if (dateRangeSelect) {
            dateRangeSelect.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customDateRange.style.display = 'block';
                } else {
                    customDateRange.style.display = 'none';
                }
            });
        }

        // File input preview
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    filePreview.innerHTML = `
                <div class="file-info">
                    <p><strong>File:</strong> ${file.name}</p>
                    <p><strong>Size:</strong> ${(file.size / 1024).toFixed(2)} KB</p>
                    <p><strong>Type:</strong> ${file.type}</p>
                </div>
            `;
                } else {
                    filePreview.innerHTML = '<p>No file selected</p>';
                }
            });
        }

        // Import submission
        if (submitImport) {
            submitImport.addEventListener('click', function() {
                if (!fileInput.files.length) {
                    alert('Please select a file to import');
                    return;
                }

                // Here you would implement actual file import logic
                const file = fileInput.files[0];
                const hasHeaders = document.getElementById('headerRow').checked;
                const replaceExisting = document.getElementById('replaceExisting').checked;

                // For demo purposes, show success message
                alert(`Import started for file: ${file.name}`);

                // Mock processing - in real implementation, you'd process the file
                setTimeout(() => {
                    alert('Import completed successfully!');
                    closeModal(importModal);

                    // Reset form
                    document.getElementById('importForm').reset();
                    filePreview.innerHTML = '<p>No file selected</p>';

                    // Refresh table data (mock)
                    renderTable(filteredData, currentPage);
                }, 1500);
            });
        }

        // Export submission
        if (submitExport) {
            submitExport.addEventListener('click', function() {
                const format = document.getElementById('exportFormat').value;
                const dateRange = document.getElementById('dateRange').value;

                // Collect checked fields
                const fields = [];
                document.querySelectorAll('.checkbox-list input[type="checkbox"]:checked').forEach(checkbox => {
                    fields.push(checkbox.id.replace('field_', ''));
                });

                if (fields.length === 0) {
                    alert('Please select at least one field to export');
                    return;
                }

                // Handle date range
                let dateInfo = '';
                if (dateRange === 'custom') {
                    const startDate = document.getElementById('startDate').value;
                    const endDate = document.getElementById('endDate').value;

                    if (!startDate || !endDate) {
                        alert('Please select both start and end dates');
                        return;
                    }

                    dateInfo = ` from ${startDate} to ${endDate}`;
                } else if (dateRange !== 'all') {
                    dateInfo = ` (${dateRange})`;
                }

                // For demo purposes, show success message
                alert(`Exporting attendance data to ${format.toUpperCase()}${dateInfo}`);

                // Mock processing - in real implementation, you'd generate the export file
                setTimeout(() => {
                    alert('Export completed successfully!');
                    closeModal(exportModal);

                    // Mock download
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = '#';
                    a.download = `attendance_export_${new Date().toISOString().split('T')[0]}.${format}`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }, 1500);
            });
        }
    </script>

    <?php include "includes/script.php"; ?>
</body>

</html>