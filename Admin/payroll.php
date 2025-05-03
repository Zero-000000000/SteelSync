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
    <link href="css/payroll.css" rel="stylesheet">

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