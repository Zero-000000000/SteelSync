<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intellitech System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .tab-content {
            padding: 20px;
            background-color: white;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }

        .fingerprint-icon {
            font-size: 100px;
            color: #0d6efd;
        }

        .back-button-container {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1000;
        }

        .header-container {
            position: relative;
        }
    </style>
</head>

<body>
    <!-- Back Button -->
    <div class="back-button-container">
        <a href="attendance.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="container py-5">
        <div class="header-container">
            <h1 class="text-center mb-4">Employee attendance Tracking</h1>
        </div>

        <ul class="nav nav-tabs" id="mainTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="employees-tab" data-bs-toggle="tab" data-bs-target="#employees" type="button" role="tab" aria-controls="employees" aria-selected="true">Employees</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button" role="tab" aria-controls="reports" aria-selected="false">Reports</button>
            </li>
        </ul>

        <div class="tab-content" id="mainTabsContent">
            <!-- Employees Tab -->
            <div class="tab-pane fade show active" id="employees" role="tabpanel" aria-labelledby="employees-tab">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Employee Management</h5>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add New Employee</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="employees-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Position</th>

                                                <th>Fingerprint Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Employee rows will be loaded here via AJAX -->
                                            <tr>
                                                <td colspan="6" class="text-center">Loading employees...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Tab -->
            <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Attendance Report</h5>
                            </div>
                            <div class="card-body">
                                <form id="report-form" class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <label for="report-employee" class="form-label">Employee</label>
                                        <select class="form-select" id="report-employee">
                                            <option value="all">All Employees</option>
                                            <!-- Employee options will be loaded here -->
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="report-start-date" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="report-start-date">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="report-end-date" class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="report-end-date">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                                    </div>
                                </form>

                                <div id="report-results">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="report-table">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Employee</th>
                                                    <th>Time In</th>
                                                    <th>Time Out</th>
                                                    <th>location</th>
                                                    <th>Duration</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Report data will be loaded here -->
                                                <tr>
                                                    <td colspan="7" class="text-center">Generate a report to see data</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-employee-form">
                        <div class="mb-3">
                            <label for="employee-name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="employee-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="employee-position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="employee-position" required>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-employee">Save Employee</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Fingerprint Modal -->
    <div class="modal fade" id="registerFingerprintModal" tabindex="-1" aria-labelledby="registerFingerprintModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerFingerprintModalLabel">Register Fingerprint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <input type="hidden" id="fingerprint-employee-id">
                    <p class="lead">Place your finger on the scanner</p>
                    <div class="fingerprint-icon mb-3">
                        <i class="bi bi-fingerprint"></i>
                    </div>
                    <div class="mb-3" id="register-status">
                        Waiting for fingerprint...
                    </div>
                    <button class="btn btn-primary" id="register-fingerprint-button">
                        Scan Fingerprint
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Update time and date
            function updateDateTime() {
                const now = new Date();
                const timeStr = now.toLocaleTimeString();
                const dateStr = now.toLocaleDateString(undefined, {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                $('#current-time').text(timeStr);
                $('#current-date').text(dateStr);
            }

            setInterval(updateDateTime, 1000);
            updateDateTime();

            // Show notification
            function showNotification(message, type) {
                const notification = $('#notification');
                notification.removeClass('success error').addClass(type);
                notification.text(message);
                notification.fadeIn();

                setTimeout(function() {
                    notification.fadeOut();
                }, 5000);
            }

            // Load employee list
            function loadEmployees() {
                // In a real application, this would be an AJAX call to fetch employees from the server
                // For demonstration, we'll simulate with dummy data
                const employees = [{
                        employee_id: 1,
                        name: 'Mike Adrian Dela Cruz',
                        position: 'Project manager',
                        fingerprint_id: 'REGISTERED'
                    },
                    {
                        employee_id: 2,
                        name: 'Jennylyn Vinuya',
                        position: 'Business Analyst',
                        fingerprint_id: 'REGISTERED'
                    },
                    {
                        employee_id: 3,
                        name: 'Ozzy Hernandez',
                        position: 'Designer',
                        fingerprint_id: 'REGISTERED'
                    },
                    {
                        employee_id: 4,
                        name: 'Angelo Acquiatan',
                        position: 'Back-End Developer',
                        fingerprint_id: 'REGISTERED'
                    },
                    {
                        employee_id: 5,
                        name: 'Alexis Mendoza',
                        position: 'Fron-End Developer',
                        fingerprint_id: 'REGISTERED'
                    },
                    {
                        employee_id: 6,
                        name: 'Rossel Tiquia',
                        position: 'Assistant Designer',
                        fingerprint_id: 'REGISTERED'
                    },
                    {
                        employee_id: 7,
                        name: 'MeyQue',
                        position: 'Spy',
                        fingerprint_id: 'PENDING_REGISTRATION_12345'
                    }
                ];
                const tbody = $('#employees-table tbody');
                tbody.empty();

                employees.forEach(function(employee) {
                    const fingerprintStatus = employee.fingerprint_id.startsWith('PENDING') ?
                        '<span class="badge bg-warning">Not Registered</span>' :
                        '<span class="badge bg-success">Registered</span>';

                    const registerButton = employee.fingerprint_id.startsWith('PENDING') ?
                        `<button class="btn btn-sm btn-primary register-fingerprint" data-employee-id="${employee.employee_id}">Register Fingerprint</button>` :
                        `<button class="btn btn-sm btn-outline-primary register-fingerprint" data-employee-id="${employee.employee_id}">Update Fingerprint</button>`;

                    tbody.append(`
                        <tr>
                            <td>${employee.employee_id}</td>
                            <td>${employee.name}</td>
                            <td>${employee.position}</td>
                            <td>${fingerprintStatus}</td>
                            <td>
                                ${registerButton}
                                <button class="btn btn-sm btn-info view-history" data-employee-id="${employee.employee_id}">View History</button>
                            </td>
                        </tr>
                    `);
                });

                // Also populate the report dropdown
                const reportSelect = $('#report-employee');
                reportSelect.find('option:not(:first)').remove();

                employees.forEach(function(employee) {
                    reportSelect.append(`<option value="${employee.employee_id}">${employee.name}</option>`);
                });
            }

            // Register employee
            $('#save-employee').click(function() {
                const name = $('#employee-name').val();
                const position = $('#employee-position').val();


                if (!name || !position || !department) {
                    showNotification('Please fill all fields', 'error');
                    return;
                }

                // In a real app, this would be an AJAX call to the PHP backend
                // Simulate an AJAX call to add employee
                setTimeout(function() {
                    const employeeId = Math.floor(Math.random() * 1000) + 10; // Random ID for demo

                    showNotification(`Employee ${name} added successfully`, 'success');
                    $('#addEmployeeModal').modal('hide');

                    // Reset form
                    $('#add-employee-form')[0].reset();

                    // Reload employee list
                    loadEmployees();

                    // Show fingerprint registration modal
                    $('#fingerprint-employee-id').val(employeeId);
                    $('#registerFingerprintModal').modal('show');
                }, 1000);
            });

            // Register fingerprint button click
            $(document).on('click', '.register-fingerprint', function() {
                const employeeId = $(this).data('employee-id');
                $('#fingerprint-employee-id').val(employeeId);
                $('#registerFingerprintModal').modal('show');
            });

            // Register fingerprint process
            $('#register-fingerprint-button').click(function() {
                const button = $(this);
                const status = $('#register-status');

                button.prop('disabled', true);
                status.text('Scanning fingerprint...');

                // Simulate scanning - in a real app, this would be an AJAX call to the PHP backend
                setTimeout(function() {
                    status.text('Fingerprint captured. Processing...');

                    setTimeout(function() {
                        const isSuccess = Math.random() > 0.1; // 90% success rate for demo

                        if (isSuccess) {
                            status.text('Fingerprint registered successfully!');
                            status.removeClass('text-danger').addClass('text-success');

                            // Reload employee list after successful registration
                            loadEmployees();

                            setTimeout(function() {
                                $('#registerFingerprintModal').modal('hide');
                                status.text('Waiting for fingerprint...');
                                status.removeClass('text-success');
                                button.prop('disabled', false);
                            }, 2000);
                        } else {
                            status.text('Failed to register fingerprint. Please try again.');
                            status.removeClass('text-success').addClass('text-danger');
                            button.prop('disabled', false);

                            setTimeout(function() {
                                status.text('Waiting for fingerprint...');
                                status.removeClass('text-danger');
                            }, 3000);
                        }
                    }, 1000);
                }, 2000);
            });

            // View employee history
            $(document).on('click', '.view-history', function() {
                const employeeId = $(this).data('employee-id');

                // Switch to reports tab
                $('#reports-tab').tab('show');

                // Set values in the report form
                $('#report-employee').val(employeeId);

                // Set default date range (last 30 days)
                const today = new Date();
                const thirtyDaysAgo = new Date();
                thirtyDaysAgo.setDate(today.getDate() - 30);

                $('#report-start-date').val(formatDate(thirtyDaysAgo));
                $('#report-end-date').val(formatDate(today));

                // Trigger report generation
                $('#report-form').submit();
            });

            // Generate report
            $('#report-form').submit(function(e) {
                e.preventDefault();

                const employeeId = $('#report-employee').val();
                const startDate = $('#report-start-date').val();
                const endDate = $('#report-end-date').val();

                if (!startDate || !endDate) {
                    showNotification('Please select date range', 'error');
                    return;
                }

                // In a real app, this would be an AJAX call to the PHP backend
                const tbody = $('#report-table tbody');
                tbody.html('<tr><td colspan="6" class="text-center">Loading report data...</td></tr>');

                setTimeout(function() {
                    // Generate random report data for demo
                    generateRandomReportData(employeeId, startDate, endDate);
                }, 1000);
            });

            // Helper function to format date as YYYY-MM-DD for input fields
            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Generate random attendance data for demo purposes
            function generateRandomReportData(employeeId, startDate, endDate) {
                const tbody = $('#report-table tbody');
                tbody.empty();

                // Create dates array
                const start = new Date(startDate);
                const end = new Date(endDate);
                const dateArray = [];

                let currentDate = new Date(start);
                while (currentDate <= end) {
                    dateArray.push(new Date(currentDate));
                    currentDate.setDate(currentDate.getDate() + 1);
                }

                // Get employee name (or "All Employees")
                let employeeName = "All Employees";
                if (employeeId !== "all") {
                    // In a real app, you would fetch the employee name from the database
                    // For demo, we'll use placeholder names
                    const employeeNames = {
                        "1": "Mike Adrian Dela Cruz",
                        "2": "Jennylyn Vinuya",
                        "3": "Ozzy Hernandez",
                        "4": "Angelo Acquiatan",
                        "5": "Alexis Mendoza",
                        "6": "Rossel Tiquia",
                        "7": "MeyQue"
                    };
                    employeeName = employeeNames[employeeId] || `Employee #${employeeId}`;
                }

                // Generate records
                const records = [];

                if (employeeId === "all") {
                    // Generate records for multiple employees
                    const employees = ["Mike Adriane Dela Cruz", "Jennylyn Vinuya", "Ozzy Hernandez", "Angelo Acquiatan", "Alexis Mendoza", "Rossel Tiquia", "MeyQue"];

                    dateArray.forEach(date => {
                        // Not all employees have records every day
                        const employeesToShow = employees.filter(() => Math.random() > 0.3);

                        employeesToShow.forEach(emp => {
                            if (Math.random() > 0.1) { // 80% chance of having a record
                                records.push(generateAttendanceRecord(date, emp));
                            }
                        });
                    });
                } else {
                    // Generate records for a single employee
                    dateArray.forEach(date => {
                        // Skip weekends
                        const dayOfWeek = date.getDay();
                        if (dayOfWeek !== 0 && dayOfWeek !== 6) {
                            if (Math.random() > 0.1) { // 90% chance of having a record on weekdays
                                records.push(generateAttendanceRecord(date, employeeName));
                            }
                        }
                    });
                }

                // Sort records by date (newest first)
                records.sort((a, b) => new Date(b.date) - new Date(a.date));

                // Render records
                if (records.length === 0) {
                    tbody.html('<tr><td colspan="6" class="text-center">No records found for the selected criteria</td></tr>');
                } else {
                    records.forEach(record => {
                        tbody.append(`
                            <tr>
                                <td>${record.date}</td>
                                <td>${record.employee}</td>
                                <td>${record.timeIn}</td>
                                <td>${record.timeOut}</td>
                                <td>${record.location}</td>
                                <td>${record.duration}</td>
                                <td><span class="badge ${record.status === 'Present' ? 'bg-success' : 'bg-warning'}">${record.status}</span></td>
                            </tr>
                        `);
                    });
                }
            }

            // Generate a random attendance record for demo
            function generateAttendanceRecord(date, employee) {
                const dateStr = date.toLocaleDateString();

                // Random time in (between 7:30 and 9:30)
                const hourIn = Math.floor(Math.random() * 2) + 7;
                const minuteIn = Math.floor(Math.random() * 60);
                const timeIn = `${hourIn}:${minuteIn.toString().padStart(2, '0')} AM`;

                // Random time out (between 4:00 and 6:30 PM)
                const hourOut = Math.floor(Math.random() * 3) + 16;
                const minuteOut = Math.floor(Math.random() * 60);
                const timeOut = `${hourOut - 12}:${minuteOut.toString().padStart(2, '0')} PM`;

                // Calculate duration
                const durationHours = hourOut - hourIn;
                const durationMinutes = minuteOut - minuteIn;
                let duration;

                if (durationMinutes < 0) {
                    duration = `${durationHours - 1} hr ${durationMinutes + 60} min`;
                } else {
                    duration = `${durationHours} hr ${durationMinutes} min`;
                }

                // Status (mostly present, occasionally late)
                const status = hourIn >= 9 ? 'Late' : 'Present';

                return {
                    date: dateStr,
                    employee: employee,
                    timeIn: timeIn,
                    timeOut: timeOut,
                    duration: duration,
                    status: status
                };
            }

            // Set default date values for the report form
            $(function() {
                const today = new Date();
                const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

                $('#report-start-date').val(formatDate(firstDayOfMonth));
                $('#report-end-date').val(formatDate(today));

                // Load initial data
                loadEmployees();
            });
        });
    </script>
</body>

</html>