<?php
session_start();

// Redirect to login if no user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: /steelsync/admin/login.php");
    exit();
}
// Verify the user has the correct role
if ($_SESSION["role"] !== 'super_admin') {
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
        /**dito mo lagay yung css ng fix assets content yung css sa taas default yan format ng main--content wag mo aalisin*/
    </style>
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>


    <div class="main--content">
        <!-- dito mo ilagay yung fix asseta ng appointment-->
        <div class="account-manager-container">
            <div class="account-manager-header">
                <h2>ACCOUNT MANAGER</h2>
                <div class="tabs">
                    <a href="#" class="tab <?php echo ($_SESSION['role'] == 'employee') ? 'active' : ''; ?>">Employee</a>
                    <a href="#" class="tab <?php echo ($_SESSION['role'] == 'administrator') ? 'active' : ''; ?>">Administrator</a>
                </div>
            </div>

            <div class="account-manager-tools">
                <div class="filter-search">
                    <div class="dropdown">
                        <select id="filterDropdown">
                            <option value="all">All Roles</option>
                            <option value="administrator">Administrator</option>
                            <option value="employee">Employee</option>
                            <optgroup label="Employee Positions">
                                <option value="Training & ControlOperations Manager">Training & Control Operations Manager</option>
                                <option value="Sales Staff">Sales Staff</option>
                                <option value="Office Staff/Sales Clerk">Office Staff/Sales Clerk</option>
                                <option value="Accounting & Inventory">Accounting & Inventory</option>
                                <option value="Senior Supervisor">Senior Supervisor</option>
                                <option value="Fabrication Team Leader">Fabrication Team Leader</option>
                                <option value="Site Team Leader">Site Team Leader</option>
                                <option value="Skilled Welder/Driver">Skilled Welder/Driver</option>
                                <option value="Site Supervisor">Site Supervisor</option>
                                <option value="TL/Skilled Welder">TL/Skilled Welder</option>
                                <option value="Skilled Welder">Skilled Welder</option>
                                <option value="Fabrication Supervisor">Fabrication Supervisor</option>
                                <option value="Fab Helper">Fab Helper</option>
                                <option value="Welder">Welder</option>
                                <option value="Welder/Driver">Welder/Driver</option>
                                <option value="Helper - Welder">Helper - Welder</option>
                                <option value="Helper - Mason">Helper - Mason</option>
                                <option value="Electrician /Site Supervisor">Electrician/Site Supervisor</option>
                                <option value="Electrician /Team Leader">Electrician/Team Leader</option>
                                <option value="Skilled Electrician/team leader">Skilled Electrician/Team Leader</option>
                                <option value="Paint Supervisor">Paint Supervisor</option>
                                <option value="Skilled Painter">Skilled Painter</option>
                                <option value="Driver - Helper">Driver - Helper</option>
                            </optgroup>
                            <optgroup label="Administrator Positions">
                                <option value="Purchaser">Purchaser</option>
                                <option value="HR Manager/Admin">HR Manager/Admin</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="search-container">
                        <input type="text" id="searchInput" placeholder="Search by name">
                        <button class="search-btn">Search</button>
                    </div>
                </div>
                <button class="add-account-btn">
                    <i class="fas fa-plus"></i> Add Account
                </button>
            </div>

            <div class="account-table">
                <div class="table-header">
                    <div class="header-item employee-id">ID</div>
                    <div class="header-item employee-name">Employee Name</div>
                    <div class="header-item role">Role</div>
                    <div class="header-item position">Position</div>
                    <div class="header-item actions">Actions</div>
                </div>
                <div class="table-content" id="employeeTableContent">
                    <!-- Data will be populated via JavaScript -->
                </div>
            </div>

            <div class="pagination">
                <button class="page-btn" id="prevBtn" disabled><i class="fas fa-chevron-left"></i> Prev</button>
                <div class="page-numbers" id="pageNumbers">
                    <button class="page-number active">1</button>
                    <!-- Page numbers will be generated dynamically -->
                </div>
                <button class="page-btn" id="nextBtn">Next <i class="fas fa-chevron-right"></i></button>
                <div class="page-info">
                    Page:
                    <input type="text" class="page-input" id="pageInput" value="1">
                    of <span id="totalPages">1</span>
                </div>
            </div>

            <!-- Modal for adding/editing account -->
            <div id="accountModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2 id="modalTitle">Add New Account</h2>
                    <form id="accountForm">
                        <input type="hidden" id="employeeId" value="">

                        <!-- Profile Photo Section -->
                        <div class="profile-photo-section">
                            <div class="photo-container">
                                <i class="fas fa-user-circle profile-placeholder"></i>
                            </div>
                            <div class="photo-actions">
                                <button type="button" class="upload-photo-btn">
                                    <i class="fas fa-upload"></i> Upload Photo
                                </button>
                                <button type="button" class="scan-fingerprint-btn">
                                    <i class="fas fa-fingerprint"></i> Scan Fingerprint
                                </button>
                            </div>
                        </div>

                        <!-- User Details Section -->
                        <div class="form-section">
                            <h3>User Details</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" id="firstName" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" id="lastName" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="roleSelect">Role</label>
                                <select id="roleSelect" required>
                                    <option value="employee">Employee</option>
                                    <option value="administrator">Administrator</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="positionSelect">Position</label>
                                <select id="positionSelect" required>
                                    <!-- Options will be populated based on selected role -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="phoneNumber">Phone Number</label>
                                <input type="tel" id="phoneNumber">
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" required>
                            </div>
                        </div>

                        <!-- Change Password Section -->
                        <div class="form-section">
                            <h3>Account Credentials</h3>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" id="password">
                                <small id="passwordNote">Leave blank to keep current password</small>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm New Password</label>
                                <input type="password" id="confirmPassword">
                            </div>
                        </div>

                        <div class="form-buttons">
                            <button type="button" id="cancelBtn">Cancel</button>
                            <button type="submit" id="saveBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Confirmation Modal -->
            <div id="confirmModal" class="modal">
                <div class="modal-content confirmation-modal">
                    <h2>Confirm Delete</h2>
                    <p>Are you sure you want to delete this account? This action cannot be undone.</p>
                    <div class="form-buttons">
                        <button type="button" id="cancelDeleteBtn">Cancel</button>
                        <button type="button" id="confirmDeleteBtn">Delete</button>
                    </div>
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
                    position: "Training & ControlOperations Manager"
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
                    position: "HR Manager/Admin"
                },
                {
                    id: 31,
                    name: "Milen San Jose",
                    role: "administrator",
                    position: "Purchaser"
                }
            ];

            // Variables for pagination
            let currentPage = 1;
            const recordsPerPage = 10;
            let filteredData = [...employeeData];
            let activeRole = 'employee'; // Default active role

            // Elements
            const filterDropdown = document.getElementById('filterDropdown');
            const searchInput = document.getElementById('searchInput');
            const tableContent = document.getElementById('employeeTableContent');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const pageInput = document.getElementById('pageInput');
            const totalPagesSpan = document.getElementById('totalPages');
            const pageNumbersDiv = document.getElementById('pageNumbers');
            const addAccountBtn = document.querySelector('.add-account-btn');
            const accountModal = document.getElementById('accountModal');
            const confirmModal = document.getElementById('confirmModal');
            const modalCloseBtn = document.querySelector('.close');
            const accountForm = document.getElementById('accountForm');
            const modalTitle = document.getElementById('modalTitle');
            const employeeIdInput = document.getElementById('employeeId');
            const fullNameInput = document.getElementById('fullName');
            const roleSelect = document.getElementById('roleSelect');
            const positionSelect = document.getElementById('positionSelect');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const passwordNote = document.getElementById('passwordNote');
            const cancelBtn = document.getElementById('cancelBtn');
            const saveBtn = document.getElementById('saveBtn');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const tabLinks = document.querySelectorAll('.tab');
            const firstNameInput = document.getElementById('firstName');
            const lastNameInput = document.getElementById('lastName');
            const usernameInput = document.getElementById('username');
            const phoneNumberInput = document.getElementById('phoneNumber');

            // Positions for each role
            const positions = {
                employee: [
                    "Training & ControlOperations Manager",
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

            // Initialize the page
            function init() {
                setupFilterDropdown('employee'); // Initialize dropdown for the default tab
                displayData();
                setupEventListeners();
                updatePositionOptions('employee');

                // Set the initial active tab
                tabLinks.forEach(tab => {
                    if (tab.textContent.toLowerCase() === activeRole) {
                        tab.classList.add('active');
                    } else {
                        tab.classList.remove('active');
                    }
                });
            }

            // Update filter dropdown options based on selected role
            function setupFilterDropdown(role) {
                filterDropdown.innerHTML = '';

                // Always add "All" option at the top
                const allOption = document.createElement('option');
                allOption.value = 'all';
                allOption.textContent = 'All Positions';
                filterDropdown.appendChild(allOption);

                // Add the role itself as an option
                if (role === 'employee') {
                    const employeeOption = document.createElement('option');
                    employeeOption.value = 'employee';
                    employeeOption.textContent = 'Employee';
                    filterDropdown.appendChild(employeeOption);
                } else if (role === 'administrator') {
                    const adminOption = document.createElement('option');
                    adminOption.value = 'administrator';
                    adminOption.textContent = 'Administrator';
                    filterDropdown.appendChild(adminOption);
                }

                // Add optgroup for positions
                const positionGroup = document.createElement('optgroup');
                positionGroup.label = role === 'employee' ? 'Employee Positions' : 'Administrator Positions';

                // Add position options
                positions[role].forEach(position => {
                    const option = document.createElement('option');
                    option.value = position;
                    option.textContent = position;
                    positionGroup.appendChild(option);
                });

                filterDropdown.appendChild(positionGroup);
            }

            // Filter and display data
            function displayData() {
                // Filter data based on dropdown and search input
                const filterValue = filterDropdown.value;
                const searchValue = searchInput.value.trim().toLowerCase();

                filteredData = employeeData.filter(employee => {
                    // First filter by active role
                    const matchesRole = employee.role === activeRole;

                    // Then filter by dropdown selection
                    const matchesFilter = filterValue === 'all' ||
                        employee.role === filterValue ||
                        employee.position === filterValue;

                    // Then filter by search text
                    const matchesSearch = employee.name.toLowerCase().includes(searchValue);

                    return matchesRole && matchesFilter && matchesSearch;
                });

                // Update pagination
                const totalPages = Math.ceil(filteredData.length / recordsPerPage);
                totalPagesSpan.textContent = totalPages;
                if (currentPage > totalPages && totalPages > 0) {
                    currentPage = totalPages;
                }

                updatePageNumbers(totalPages);
                updatePaginationButtons(totalPages);

                // Display current page
                const startIndex = (currentPage - 1) * recordsPerPage;
                const endIndex = startIndex + recordsPerPage;
                const currentPageData = filteredData.slice(startIndex, endIndex);

                // Clear table
                tableContent.innerHTML = '';

                if (currentPageData.length === 0) {
                    const emptyRow = document.createElement('div');
                    emptyRow.className = 'empty-table';
                    emptyRow.innerHTML = '<p>No records found</p>';
                    tableContent.appendChild(emptyRow);
                } else {
                    // Create rows for current page data
                    currentPageData.forEach(employee => {
                        const row = document.createElement('div');
                        row.className = 'table-row';
                        row.innerHTML = `
                    <div class="row-item employee-id">${employee.id}</div>
                    <div class="row-item employee-name">${employee.name}</div>
                    <div class="row-item role">${employee.role === 'administrator' ? 'Admin' : 'Employee'}</div>
                    <div class="row-item position">${employee.position}</div>
                    <div class="row-item actions">
                        <button class="action-btn edit-btn" data-id="${employee.id}">
                            <i class="fas fa-user-edit"></i> Edit
                        </button>
                        <button class="action-btn delete-btn" data-id="${employee.id}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                `;
                        tableContent.appendChild(row);
                    });

                    // Add event listeners for edit and delete buttons
                    addActionButtonEventListeners();
                }
            }

            // Update position options based on selected role
            function updatePositionOptions(role) {
                positionSelect.innerHTML = '';
                positions[role].forEach(position => {
                    const option = document.createElement('option');
                    option.value = position;
                    option.textContent = position;
                    positionSelect.appendChild(option);
                });
            }

            // Update page number buttons
            function updatePageNumbers(totalPages) {
                pageNumbersDiv.innerHTML = '';

                // Determine range of page numbers to show
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, startPage + 4);

                if (endPage - startPage < 4) {
                    startPage = Math.max(1, endPage - 4);
                }

                // Create page number buttons
                for (let i = startPage; i <= endPage; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.className = 'page-number' + (i === currentPage ? ' active' : '');
                    pageBtn.textContent = i;
                    pageBtn.addEventListener('click', () => {
                        currentPage = i;
                        displayData();
                    });
                    pageNumbersDiv.appendChild(pageBtn);
                }
            }

            // Update pagination buttons state
            function updatePaginationButtons(totalPages) {
                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = currentPage === totalPages || totalPages === 0;
                pageInput.value = currentPage;
            }

            // Add event listeners to action buttons
            function addActionButtonEventListeners() {
                document.querySelectorAll('.edit-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const employeeId = btn.getAttribute('data-id');
                        openEditModal(parseInt(employeeId));
                    });
                });

                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const employeeId = btn.getAttribute('data-id');
                        openDeleteConfirmation(parseInt(employeeId));
                    });
                });
            }

            // Generate a mock phone number for example purposes
            function generateMockPhoneNumber() {
                return `+63 9${Math.floor(Math.random() * 90000000) + 10000000}`;
            }

            // Open edit modal with employee data
            function openEditModal(employeeId) {
                const employee = employeeData.find(emp => emp.id === employeeId);
                if (employee) {
                    modalTitle.textContent = 'Edit Account';
                    employeeIdInput.value = employee.id;

                    // Split the name into first and last name (assuming space separation)
                    const nameParts = employee.name.split(' ');
                    firstNameInput.value = nameParts[0] || '';
                    lastNameInput.value = nameParts.slice(1).join(' ') || '';

                    roleSelect.value = employee.role;
                    updatePositionOptions(employee.role);
                    positionSelect.value = employee.position;

                    // Set email with proper format
                    const emailAddr = `${employee.name.toLowerCase().replace(/\s+/g, '.')}@company.com`;
                    emailInput.value = emailAddr;
                    usernameInput.value = employee.name.toLowerCase().replace(/\s+/g, '.');

                    // Clear password fields and show password note
                    passwordInput.value = '';
                    confirmPasswordInput.value = '';
                    passwordNote.style.display = 'block';

                    // Set phone number (mock data for example)
                    phoneNumberInput.value = employee.phoneNumber || generateMockPhoneNumber();

                    accountModal.style.display = 'flex';
                    setTimeout(addPhotoActionListeners, 100);
                }
            }

            // Open delete confirmation modal
            function openDeleteConfirmation(employeeId) {
                confirmDeleteBtn.setAttribute('data-id', employeeId);
                confirmModal.style.display = 'flex';
            }

            // Open add account modal
            function openAddModal() {
                modalTitle.textContent = 'Add New Account';
                accountForm.reset();
                employeeIdInput.value = '';
                roleSelect.value = activeRole; // Set the role to the active tab
                updatePositionOptions(activeRole);
                passwordNote.style.display = 'none';

                accountModal.style.display = 'flex';
                setTimeout(addPhotoActionListeners, 100);
            }

            // Close modals
            function closeModals() {
                accountModal.style.display = 'none';
                confirmModal.style.display = 'none';
            }

            // Save account data
            function saveAccount(event) {
                event.preventDefault();

                // Get form values
                const employeeId = employeeIdInput.value;
                const isEditMode = employeeId !== '';
                const firstName = firstNameInput.value;
                const lastName = lastNameInput.value;
                const fullName = `${firstName} ${lastName}`.trim();
                const role = roleSelect.value;
                const position = positionSelect.value;
                const email = emailInput.value;
                const username = usernameInput.value;
                const phoneNumber = phoneNumberInput.value;

                // Validate passwords match if either is filled
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (password !== confirmPassword) {
                    alert("Passwords don't match. Please try again.");
                    return;
                }

                const newEmployee = {
                    id: isEditMode ? parseInt(employeeId) : employeeData.length + 1,
                    name: fullName,
                    role: role,
                    position: position,
                    email: email,
                    username: username,
                    phoneNumber: phoneNumber
                };

                if (isEditMode) {
                    // Update existing employee
                    const index = employeeData.findIndex(emp => emp.id === parseInt(employeeId));
                    if (index !== -1) {
                        employeeData[index] = newEmployee;
                    }
                } else {
                    // Add new employee
                    employeeData.push(newEmployee);
                }

                closeModals();
                displayData();
            }

            // Delete account
            function deleteAccount() {
                const employeeId = parseInt(confirmDeleteBtn.getAttribute('data-id'));
                const index = employeeData.findIndex(emp => emp.id === employeeId);

                if (index !== -1) {
                    employeeData.splice(index, 1);
                    displayData();
                }

                closeModals();
            }

            // Switch between tabs
            function switchTab(role) {
                // Update the active role
                activeRole = role;

                // Update the active tab display
                tabLinks.forEach(tab => {
                    if (tab.textContent.toLowerCase() === role) {
                        tab.classList.add('active');
                    } else {
                        tab.classList.remove('active');
                    }
                });

                // Rebuild the filter dropdown for the new role
                setupFilterDropdown(role);

                // Reset to first page and update display
                currentPage = 1;
                displayData();
            }

            // Add event listeners for photo actions
            function addPhotoActionListeners() {
                const uploadBtn = document.querySelector('.upload-photo-btn');
                const scanBtn = document.querySelector('.scan-fingerprint-btn');

                if (uploadBtn) {
                    uploadBtn.addEventListener('click', function() {
                        alert('Photo upload functionality would be implemented here.');
                    });
                }

                if (scanBtn) {
                    scanBtn.addEventListener('click', function() {
                        alert('Fingerprint scanning functionality would be implemented here.');
                    });
                }
            }

            // Set up all event listeners
            function setupEventListeners() {
                // Filter and search
                filterDropdown.addEventListener('change', () => {
                    currentPage = 1;
                    displayData();
                });

                searchInput.addEventListener('input', () => {
                    currentPage = 1;
                    displayData();
                });

                // Pagination buttons
                prevBtn.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        displayData();
                    }
                });

                nextBtn.addEventListener('click', () => {
                    const totalPages = Math.ceil(filteredData.length / recordsPerPage);
                    if (currentPage < totalPages) {
                        currentPage++;
                        displayData();
                    }
                });

                pageInput.addEventListener('change', () => {
                    const totalPages = Math.ceil(filteredData.length / recordsPerPage);
                    const pageNum = parseInt(pageInput.value);

                    if (!isNaN(pageNum) && pageNum >= 1 && pageNum <= totalPages) {
                        currentPage = pageNum;
                        displayData();
                    } else {
                        pageInput.value = currentPage;
                    }
                });

                // Tab switching
                tabLinks.forEach(tab => {
                    tab.addEventListener('click', function(e) {
                        e.preventDefault();
                        const role = this.textContent.toLowerCase();
                        switchTab(role);
                    });
                });

                // Modal controls
                addAccountBtn.addEventListener('click', openAddModal);
                modalCloseBtn.addEventListener('click', closeModals);
                cancelBtn.addEventListener('click', closeModals);
                cancelDeleteBtn.addEventListener('click', closeModals);
                confirmDeleteBtn.addEventListener('click', deleteAccount);
                accountForm.addEventListener('submit', saveAccount);

                // Role select change
                roleSelect.addEventListener('change', function() {
                    updatePositionOptions(this.value);
                });

                // Username generation from first and last name
                firstNameInput.addEventListener('input', updateUsername);
                lastNameInput.addEventListener('input', updateUsername);

                // Close modal when clicking outside
                window.addEventListener('click', function(event) {
                    if (event.target === accountModal) {
                        closeModals();
                    }
                    if (event.target === confirmModal) {
                        closeModals();
                    }
                });
            }

            // Auto-generate username and email from first and last name
            function updateUsername() {
                const firstName = firstNameInput.value.trim();
                const lastName = lastNameInput.value.trim();

                if (firstName && lastName) {
                    const username = `${firstName.toLowerCase()}.${lastName.toLowerCase()}`.replace(/\s+/g, '');
                    usernameInput.value = username;
                    emailInput.value = `${username}@company.com`;
                }
            }

            // Initialize the application
            init();
        });
    </script>
    <?php include "includes/script.php"; ?>
</body>

</html>