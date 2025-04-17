<?php
session_start();

// Redirect to login if no user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
// Verify the user has the correct role
if ($_SESSION["role"] !== 'super_admin') {
    // Redirect to appropriate page or show error
    header("Location: login.php");
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

    <style>
        /* Main content positioning to work with fixed sidebar */
        .main--content {
            margin-left: 300px;
            /* Match sidebar width */
            padding: 20px;
            transition: .3s;
        }

        /* When sidebar is collapsed */
        .sidebar.active~.main--content {
            margin-left: 103px;
            width: calc(100% - 103px);
        }

        .payroll-manager-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Payroll Header - Remains in place */
        .payroll-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .payroll-header h2 {
            font-size: 20px;
            font-weight: bold;
            font-style: italic;
            margin: 0;
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .date-picker {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
        }

        .date-picker i {
            color: #6c757d;
        }

        .download-btn {
            background-color: #f57c00;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .download-btn:hover {
            background-color: #e65100;
        }

        /* Employees Table */
        .employees-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .employees-table th,
        .employees-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .employees-table th {
            background-color: #f8f9fa;
            font-weight: 500;
            color: #495057;
        }

        .employees-table tr:hover {
            background-color: #f8f9fa;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .pagination-controls {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .pagination-btn {
            background-color: #f1f1f1;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .pagination-btn.active {
            background-color: #f57c00;
            color: white;
        }

        .pagination-info {
            font-size: 14px;
            color: #6c757d;
        }

        /* Open Payroll Button */
        .open-payroll-btn {
            background-color: #5073fb;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .open-payroll-btn:hover {
            background-color: #3f5bd3;
        }

        /* Filter controls */
        .filter-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-label {
            font-weight: 500;
            color: #495057;
        }

        .filter-select {
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search-input {
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 200px;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {
            .main--content {
                margin-left: 0;
                width: 100%;
            }

            .sidebar.active~.main--content {
                margin-left: 0;
                width: 100%;
            }

            .header-controls {
                flex-direction: column;
                align-items: flex-start;
            }

            .pagination {
                flex-direction: column;
                gap: 10px;
            }

            .filter-controls {
                flex-direction: column;
                gap: 10px;
            }
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            font-style: italic;
            color: #333;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pagination button {
            padding: 8px 12px;
            background-color: #f1f1f1;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .pagination button.active {
            background-color: #f57c00;
            color: white;
        }

        .pagination button:hover:not(.active) {
            background-color: #ddd;
        }

        .employee-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .employee-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .employee-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #000;
            margin: 0 auto 15px;
            overflow: hidden;
        }

        .employee-name {
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .employee-designation {
            color: #666;
            font-size: 14px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .page-info {
            color: #666;
            font-size: 14px;
        }

        .action-button {
            background-color: #5073fb;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }

        .action-button:hover {
            background-color: #3f5bd3;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            width: 80%;
            max-width: 900px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: modalFadeIn 0.3s;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .modal-header h2 {
            font-size: 20px;
            color: #333;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #333;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .employee-details {
            display: flex;
            gap: 30px;
            margin-bottom: 20px;
        }

        .employee-info {
            flex: 1;
        }

        .info-group {
            margin-bottom: 15px;
        }

        .info-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 500;
        }

        .salary-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .salary-details th,
        .salary-details td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .salary-details th {
            background-color: #f8f9fa;
            font-weight: 500;
            color: #495057;
        }

        .salary-details tr:last-child {
            font-weight: 700;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .modal-button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .cancel-button {
            background-color: #f1f1f1;
            color: #333;
        }

        .save-button {
            background-color: #5073fb;
            color: white;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 1200px) {
            .employee-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media screen and (max-width: 768px) {
            .employee-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .employee-details {
                flex-direction: column;
                gap: 15px;
            }
        }

        @media screen and (max-width: 576px) {
            .employee-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .pagination {
                width: 100%;
                justify-content: center;
            }

            .modal-content {
                width: 95%;
                margin: 10% auto;
            }
        }

        /* doctors */
        .doctors--right--btns {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .add {
            display: flex;
            align-items: center;
            padding: 5px 10px;
            outline: none;
            border: none;
            background-color: #5073fb;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: .3s;
        }

        .add:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .add i {
            margin-right: 10px;
            padding: 5px;
            background-color: #fff;
            border-radius: 50%;
            color: #000;
        }

        .doctors--cards {
            display: flex;
            gap: 20px;
        }

        .doctor--card {
            padding: 20px;
            border-radius: 20px;
            height: auto;
            transition: .3s;
            border: 2px solid #f1f1f1;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: .8rem;
        }

        .doctor--card:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .img--box--cover {
            border: 1px solid #5073fb;
            padding: 2px;
            border-radius: 50%;
            display: inline-block;
            margin-bottom: 10px;
        }

        .img--box {
            position: relative;
            width: 71px;
            height: 71px;
            overflow: hidden;
            border-radius: 50%;
        }

        .free {
            color: #70d7a5;
        }

        .scheduled {
            color: #5073fb;
        }

        /* recent--patients */
        .recent--patients {
            margin-bottom: 20px;
        }

        .table {
            height: 200px;
            overflow-y: scroll;
        }

        table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        tr {
            border-bottom: 1px solid #f1f1f1;
        }

        td,
        th {
            padding-block: 10px;
        }

        .edit {
            color: #70d7a5;
            margin-right: 10px;
        }

        .delete {
            color: #e86786;
        }

        .pending {
            color: #f1d243;
        }

        .confirmed {
            color: #70d7a5;
        }

        .rejected {
            color: #e86786;
        }
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>
    <?php include "includes/salarycomputation.php"; ?>

    <div class="main--content">
        <div class="payroll-manager-container">
            <!-- Payroll Header - Stays in place -->
            <div class="payroll-header">
                <h2>PAYROLL</h2>
                <div class="header-controls">
                    <div class="date-picker">
                        <i class="fas fa-calendar"></i>
                        <span id="currentPayPeriod">Jan 1 2025 - Jan 15 2025</span>
                    </div>
                    <button class="download-btn" id="downloadBtn">
                        <i class="fas fa-download"></i>
                        <span>Download</span>
                    </button>
                </div>
            </div>

            <!-- Filter controls -->
            <div class="filter-controls">
                <div class="filter-group">
                    <label class="filter-label" for="roleFilter">Role:</label>
                    <select class="filter-select" id="roleFilter">
                        <option value="all">All Roles</option>
                        <option value="employee">Employee</option>
                        <option value="administrator">Administrator</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label" for="positionFilter">Position:</label>
                    <select class="filter-select" id="positionFilter">
                        <option value="all">All Positions</option>
                        <!-- Positions will be populated dynamically -->
                    </select>
                </div>
                <div class="filter-group">
                    <input type="text" class="search-input" id="searchInput" placeholder="Search by name...">
                </div>
            </div>

            <!-- Employee Table - Will be populated dynamically -->
            <table class="employees-table">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Position</th>
                        <th>Role</th>
                        <th>Basic Pay</th>
                        <th>Regular O.T</th>
                        <th>Regular U.T</th>
                        <th>Total Hours</th>
                        <th>Total Earnings</th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody">
                    <!-- Employee data will be loaded here via JavaScript -->
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <div class="pagination-info" id="paginationInfo">
                    <span>Loading entries...</span>
                </div>
                <div class="pagination-controls" id="paginationControls">
                    <!-- Pagination buttons will be added dynamically -->
                </div>
            </div>

            <!-- Button to open payroll modal -->

            <div class="doctors">
                <div class="title">
                    <h2 class="section--title">Employees</h2>
                    <div class="doctors--right--btns">
                        <select name="date" id="date" class="dropdown doctor--filter">
                            <option>Filter</option>
                            <option value="free"></option>
                            <option value="scheduled">Training & Control Operations Manager</option>
                            <option value="free">Training & Control Operations Manager</option>
                            <option value="scheduled">Training & Control Operations Manager</option>
                            <option value="free">Training & Control Operations Manager</option>
                            <option value="scheduled">Training & Control Operations Manager</option>
                        </select>
                        <button class="add"><i class="ri-add-line"></i>Add Employees</button>
                    </div>
                </div>
                <div class="doctors--cards">
                    <a href="#" class="doctor--card" id="openPayrollBtn">
                        <div class="img--box--cover">
                            <div class="img--box">
                                <img src="../images/employee/profile.png" alt="Joel Ponce">
                            </div>
                        </div>
                        <p class="scheduled">Joel Ponce</p>
                    </a>
                    <a href="#" class="doctor--card" id="openPayrollBtn">
                        <div class="img--box--cover">
                            <div class="img--box">
                                <img src="../images/employee/profile.png" alt="Joel Ponce">
                            </div>
                        </div>
                        <p class="scheduled">Joel Ponce</p>
                    </a>
                    <a href="#" class="doctor--card" id="openPayrollBtn">
                        <div class="img--box--cover">
                            <div class="img--box">
                                <img src="../images/employee/profile.png" alt="Joel Ponce">
                            </div>
                        </div>
                        <p class="scheduled">Joel Ponce</p>
                    </a>

                </div>
            </div>
        </div>

    </div>

    <!-- JavaScript to handle employee data and interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Employee data from your system
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
                    name: "King Sison Jerome",
                    role: "employee",
                    position: "Senior Supervisor"
                },
                {
                    id: 6,
                    name: "Royo Emmanuel",
                    role: "employee",
                    position: "Fabrication Team Leader"
                },
                {
                    id: 7,
                    name: "Benito Frankeddrey",
                    role: "employee",
                    position: "Site Team Leader"
                },
                {
                    id: 8,
                    name: "FerrerJemar Magtalas",
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
                    name: "Allan SapulGong",
                    role: "employee",
                    position: "TL/Skilled Welder"
                },
                {
                    id: 11,
                    name: "Serrano Rasty",
                    role: "employee",
                    position: "Skilled Welder"
                },
                {
                    id: 12,
                    name: "ParillaPhilip",
                    role: "employee",
                    position: "Fabrication Supervisor"
                },
                {
                    id: 13,
                    name: "Guliman Engelbert",
                    role: "employee",
                    position: "Fab Helper"
                },
                {
                    id: 14,
                    name: "CunananEriczon",
                    role: "employee",
                    position: "Welder"
                },
                {
                    id: 15,
                    name: "NapisaEdrian Espino",
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

            // Generate random payroll data for demonstration
            employeeData.forEach(employee => {
                // Generate random values for demo purposes
                const basicPay = Math.floor(Math.random() * 20000) + 10000;
                const regOT = Math.floor(Math.random() * 20);
                const regUT = Math.floor(Math.random() * 5);
                const totalHours = 160 + regOT - regUT;
                const totalEarnings = basicPay + (basicPay / 160 * 1.25 * regOT) - (basicPay / 160 * regUT);

                // Add payroll data to employee object
                employee.basicPay = basicPay;
                employee.regOT = regOT;
                employee.regUT = regUT;
                employee.totalHours = totalHours;
                employee.totalEarnings = totalEarnings;
            });

            // Variables for pagination
            let currentPage = 1;
            const itemsPerPage = 7;
            let filteredEmployees = [...employeeData];

            // Get unique positions for the position filter
            const positionFilter = document.getElementById('positionFilter');
            const uniquePositions = [...new Set(employeeData.map(emp => emp.position))];
            uniquePositions.forEach(position => {
                const option = document.createElement('option');
                option.value = position;
                option.textContent = position;
                positionFilter.appendChild(option);
            });

            // Function to filter employees based on filters
            function filterEmployees() {
                const roleValue = document.getElementById('roleFilter').value;
                const positionValue = document.getElementById('positionFilter').value;
                const searchValue = document.getElementById('searchInput').value.toLowerCase();

                filteredEmployees = employeeData.filter(employee => {
                    // Filter by role
                    if (roleValue !== 'all' && employee.role !== roleValue) {
                        return false;
                    }

                    // Filter by position
                    if (positionValue !== 'all' && employee.position !== positionValue) {
                        return false;
                    }

                    // Filter by search term
                    if (searchValue && !employee.name.toLowerCase().includes(searchValue)) {
                        return false;
                    }

                    return true;
                });

                // Reset to first page when filters change
                currentPage = 1;
                renderTable();
                setupPagination();
            }

            // Event listeners for filters
            document.getElementById('roleFilter').addEventListener('change', filterEmployees);
            document.getElementById('positionFilter').addEventListener('change', filterEmployees);
            document.getElementById('searchInput').addEventListener('input', filterEmployees);

            // Function to render employee table
            function renderTable() {
                const tableBody = document.getElementById('employeeTableBody');
                tableBody.innerHTML = '';

                // Calculate pagination
                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = Math.min(startIndex + itemsPerPage, filteredEmployees.length);
                const pageEmployees = filteredEmployees.slice(startIndex, endIndex);

                // Create rows for employees
                pageEmployees.forEach(employee => {
                    const row = document.createElement('tr');

                    // Format currency for display
                    const formattedBasicPay = '₱' + employee.basicPay.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    const formattedEarnings = '₱' + employee.totalEarnings.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    row.innerHTML = `
                        <td>${employee.name}</td>
                        <td>${employee.position}</td>
                        <td>${employee.role.charAt(0).toUpperCase() + employee.role.slice(1)}</td>
                        <td>${formattedBasicPay}</td>
                        <td>${employee.regOT.toFixed(2)}</td>
                        <td>${employee.regUT.toFixed(2)}</td>
                        <td>${employee.totalHours.toFixed(2)}</td>
                        <td>${formattedEarnings}</td>
                    `;

                    tableBody.appendChild(row);
                });

                // Update pagination info
                document.getElementById('paginationInfo').innerHTML = `
                    <span>Showing ${startIndex + 1}-${endIndex} of ${filteredEmployees.length} entries</span>
                `;
            }

            // Function to set up pagination controls
            function setupPagination() {
                const paginationControls = document.getElementById('paginationControls');
                paginationControls.innerHTML = '';

                const totalPages = Math.ceil(filteredEmployees.length / itemsPerPage);

                // Previous button
                const prevButton = document.createElement('button');
                prevButton.className = 'pagination-btn';
                prevButton.innerHTML = '<i class="fas fa-angle-left"></i>';
                prevButton.disabled = currentPage === 1;
                prevButton.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderTable();
                        setupPagination();
                    }
                });
                paginationControls.appendChild(prevButton);

                // Page number buttons
                const maxPageButtons = 5;
                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, startPage + maxPageButtons - 1);

                for (let i = startPage; i <= endPage; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.className = 'pagination-btn' + (i === currentPage ? ' active' : '');
                    pageButton.textContent = i;
                    pageButton.addEventListener('click', () => {
                        currentPage = i;
                        renderTable();
                        setupPagination();
                    });
                    paginationControls.appendChild(pageButton);
                }

                // Next button
                const nextButton = document.createElement('button');
                nextButton.className = 'pagination-btn';
                nextButton.innerHTML = '<i class="fas fa-angle-right"></i>';
                nextButton.disabled = currentPage === totalPages;
                nextButton.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderTable();
                        setupPagination();
                    }
                });
                paginationControls.appendChild(nextButton);
            }

            // Payroll modal functionality
            const openPayrollBtn = document.getElementById('openPayrollBtn');
            if (openPayrollBtn) {
                openPayrollBtn.addEventListener('click', function() {
                    alert('Payroll processing would open here for the current filtered employees');
                });
            }

            // Download button functionality
            document.getElementById('downloadBtn').addEventListener('click', function() {
                alert('Payroll data would be downloaded for the current filtered employees');
            });

            // Initialize the table and pagination
            renderTable();
            setupPagination();
        });
    </script>

    <?php include "includes/script.php"; ?>
</body>

</html>