<style>
    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        overflow-y: auto;
    }

    .modal-container {
        position: relative;
        width: 90%;
        max-width: 1000px;
        margin: 50px auto;
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        animation: slideIn 0.3s ease-out;
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

    .modal-close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        cursor: pointer;
        background: none;
        border: none;
        color: #777;
    }

    .modal-close:hover {
        color: #333;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 5px;
        padding: 10px;
        background-color: #f9f9f9;
        border-bottom: 1px solid #e0e0e0;
    }

    .btn {
        padding: 6px 10px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn:hover {
        background-color: #f5f5f5;
    }

    /* Loading Container */
    .loading-container {
        display: none;
        justify-content: center;
        align-items: center;
        height: 60px;
    }

    .loader {
        border: 3px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        border-top: 3px solid #3498db;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Form Styles */
    .payroll-form {
        padding: 20px;
    }

    .employee-details {
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .form-group label {
        width: 150px;
        font-weight: normal;
    }

    .form-control {
        flex: 1;
        padding: 8px 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .employee-details .form-control {
        flex: 0 0 auto;
        width: 600px;
        /* You can adjust this value */
        max-width: 100%;
    }

    /* Payroll Sections */
    .payroll-sections {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .section {
        background-color: #f8f8f8;
        border-radius: 0;
        padding: 15px;
        flex: 1;
        min-width: 300px;
    }

    .section-title {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
    }

    .form-row {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }

    .form-row label {
        width: 150px;
        font-weight: normal;
    }

    .input-group {
        display: flex;
        flex: 1;
    }

    .currency {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 10px;
        background-color: #f1f1f1;
        border: 1px solid #ddd;
        border-right: none;
        border-radius: 4px 0 0 4px;
    }

    .units {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 10px;
        background-color: #f1f1f1;
        border: 1px solid #ddd;
        border-left: none;
        border-radius: 0 4px 4px 0;
    }

    .input-group .form-control {
        border-radius: 0;
        flex: 1;
    }

    .total-row {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #ddd;
        font-weight: bold;
        color: green;
    }

    .total-row label {
        color: green;
    }

    .hours-input {
        width: 60px !important;
        text-align: center;
        border-radius: 0 4px 4px 0 !important;
        border-left: none !important;
    }

    .units {
        padding: 0 !important;
        background: none !important;
        border: none !important;
    }

    /* Make sure readonly fields look different */
    input[readonly] {
        background-color: #f5f5f5;
        cursor: not-allowed;
    }

    /* Style improvements for currency and units */
    .currency {
        min-width: 30px;
        justify-content: center;
    }

    /* Success message */
    .success-message {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        text-align: center;
        margin-bottom: 10px;
    }

    /* Responsive adjustments */
    @media screen and (max-width: 768px) {
        .modal-container {
            width: 95%;
            margin: 20px auto;
        }

        .payroll-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .form-group,
        .form-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-group label,
        .form-row label {
            width: 100%;
            margin-bottom: 5px;
        }

        .input-group {
            width: 100%;
        }
    }

    /* Collapsed sidebar adjustment */
    @media screen and (max-width: 590px) {
        .main--content {
            width: 100%;
            padding: 10px;
        }
    }
</style>
</head>

<body>


    <div class="main--content">


        <!-- Modal Overlay -->
        <div class="modal-overlay" id="payrollModal">
            <div class="modal-container">
                <button class="modal-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>

                <div class="action-buttons">
                    <button class="btn" id="editBtn">Edit</button>
                    <button class="btn" id="saveBtn">Save</button>
                    <button class="btn" id="cancelBtn">Cancel</button>
                    <button class="btn" id="closeBtn">Close</button>
                </div>

                <div class="loading-container">
                    <div class="loader"></div>
                </div>

                <div class="payroll-form">
                    <div class="employee-details">
                        <div class="form-group">
                            <label>Name of employee:</label>
                            <input type="text" value="Jennylyn Vinuya" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Designation:</label>
                            <input type="text" value="Welder/Mason" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Salary Method:</label>
                            <input type="text" value="Cashless" class="form-control">
                        </div>
                    </div>

                    <div class="payroll-sections">
                        <div class="section earnings-section">
                            <h3 class="section-title">Regular and Overtime Pay</h3>

                            <div class="form-row">
                                <label>Basic Pay:</label>
                                <div class="input-group">
                                    <div class="currency">₱</div>
                                    <input type="text" value="700" class="form-control rate-input" id="basicRate">
                                    <div class="units">
                                        <input type="text" value="9" class="form-control hours-input" id="basicHours">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <label>Regular O.T:</label>
                                <div class="input-group">
                                    <div class="currency">₱</div>
                                    <input type="text" value="87.50" class="form-control rate-input" id="otRate">
                                    <div class="units">
                                        <input type="text" value="12.59" class="form-control hours-input" id="otHours">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <label>Regular U.T:</label>
                                <div class="input-group">
                                    <div class="currency">₱</div>
                                    <input type="text" value="87.50" class="form-control rate-input" id="utRate">
                                    <div class="units">
                                        <input type="text" value="35.00" class="form-control hours-input" id="utHours">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <label>Total of Hours:</label>
                                <input type="text" class="form-control total-hours-input" id="totalHours" readonly>
                            </div>

                            <div class="form-row total-row">
                                <label>TOTAL EARNINGS:</label>
                                <div class="input-group">
                                    <div class="currency">₱</div>
                                    <input type="text" value="10,464.00" class="form-control total-earnings-input" id="totalEarnings" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="section deductions-section">
                            <h3 class="section-title">Employee Deduction Pay</h3>

                            <div class="form-row">
                                <label>Cash Bond:</label>
                                <div class="input-group">
                                    <div class="currency">₱</div>
                                    <input type="text" value="200.00" class="form-control" id="cashBond">
                                </div>
                            </div>

                            <div class="form-row">
                                <label>Cash Bills:</label>
                                <div class="input-group">
                                    <div class="currency">₱</div>
                                    <input type="text" value="1375.00" class="form-control" id="cashBills">
                                </div>
                            </div>

                            <div class="form-row">
                                <label>Cash Advance:</label>
                                <div class="input-group">
                                    <div class="currency">₱</div>
                                    <input type="text" value="1000.00" class="form-control" id="cashAdvance">
                                </div>
                            </div>

                            <div class="form-row">
                                <label>HDMF:</label>
                                <div class="input-group">
                                    <div class="currency">₱</div>
                                    <input type="text" value="100.00" class="form-control" id="hdmf">
                                </div>
                            </div>

                            <div class="form-row">
                                <label>SSS:</label>
                                <div class="input-group">
                                    <div class="currency">₱</div>
                                    <input type="text" value="180.00" class="form-control" id="sss">
                                </div>
                            </div>

                            <div class="form-row">
                                <label>Philhealth:</label>
                                <div class="input-group">
                                    <div class="currency">₱</div>
                                    <input type="text" value="125.00" class="form-control" id="philhealth">
                                </div>
                            </div>

                            <div class="form-row">
                                <label>Total Deduction:</label>
                                <div class="input-group">
                                    <div class="currency">₱</div>
                                    <input type="text" value="2,980.00" class="form-control" id="totalDeduction" readonly>
                                </div>
                            </div>

                            <div class="form-row total-row">
                                <label>TOTAL NET PAY:</label>
                                <div class="input-group">
                                    <div class="currency">₱</div>
                                    <input type="text" value="7,484.13" class="form-control" id="netPay" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal elements
            const openPayrollBtn = document.getElementById('openPayrollBtn');
            const payrollModal = document.getElementById('payrollModal');
            const closeModalBtn = document.getElementById('closeModalBtn');

            // Get form controls
            const editBtn = document.getElementById('editBtn');
            const saveBtn = document.getElementById('saveBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const closeBtn = document.getElementById('closeBtn');

            // Get input fields
            const basicRate = document.getElementById('basicRate');
            const basicHours = document.getElementById('basicHours');
            const otRate = document.getElementById('otRate');
            const otHours = document.getElementById('otHours');
            const utRate = document.getElementById('utRate');
            const utHours = document.getElementById('utHours');
            const totalHours = document.getElementById('totalHours');
            const totalEarnings = document.getElementById('totalEarnings');

            // Deduction fields
            const cashBond = document.getElementById('cashBond');
            const cashBills = document.getElementById('cashBills');
            const cashAdvance = document.getElementById('cashAdvance');
            const hdmf = document.getElementById('hdmf');
            const sss = document.getElementById('sss');
            const philhealth = document.getElementById('philhealth');
            const totalDeduction = document.getElementById('totalDeduction');
            const netPay = document.getElementById('netPay');

            // Get all editable inputs
            const editableInputs = [
                basicRate, basicHours, otRate, otHours, utRate, utHours,
                cashBond, cashBills, cashAdvance, hdmf, sss, philhealth
            ];

            // Get all read-only inputs
            const readOnlyInputs = [totalHours, totalEarnings, totalDeduction, netPay];

            // Original values storage
            const originalValues = {};

            // Modal open/close functions
            openPayrollBtn.addEventListener('click', function() {
                payrollModal.style.display = 'block';
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
                // Calculate all values on open
                calculateAll();
            });

            closeModalBtn.addEventListener('click', function() {
                payrollModal.style.display = 'none';
                document.body.style.overflow = 'auto'; // Restore scrolling
            });

            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === payrollModal) {
                    payrollModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });

            // Initialize the form in edit mode
            function initializeForm() {
                // Enable all editable fields by default
                editableInputs.forEach(input => {
                    input.disabled = false;
                    originalValues[input.id] = input.value;
                });

                // Make sure read-only fields stay read-only
                readOnlyInputs.forEach(input => {
                    input.disabled = true;
                });

                // Style the edit button as active
                editBtn.style.backgroundColor = '#5073fb';
                editBtn.style.color = 'white';

                // Calculate initial values
                calculateAll();
            }

            // Function to calculate all values
            function calculateAll() {
                calculateTotalHours();
                calculateEarnings();
                calculateDeductions();
                calculateNetPay();
            }

            // Calculate total hours
            function calculateTotalHours() {
                const regular = parseFloat(basicHours.value) || 0;
                const overtime = parseFloat(otHours.value) || 0;
                const undertime = parseFloat(utHours.value) || 0;

                // Total hours (regular + overtime - undertime)
                const total = regular + overtime - undertime;
                totalHours.value = total.toFixed(2);

                return total;
            }

            // Calculate earnings
            function calculateEarnings() {
                // Basic pay calculation
                const bRate = parseFloat(basicRate.value.replace(/,/g, '')) || 0;
                const bHours = parseFloat(basicHours.value) || 0;
                const basicPay = bRate * bHours;

                // Overtime pay calculation
                const oRate = parseFloat(otRate.value.replace(/,/g, '')) || 0;
                const oHours = parseFloat(otHours.value) || 0;
                const overtimePay = oRate * oHours;

                // Undertime deduction calculation
                const uRate = parseFloat(utRate.value.replace(/,/g, '')) || 0;
                const uHours = parseFloat(utHours.value) || 0;
                const undertimeDeduction = uRate * uHours;

                // Calculate total earnings
                const earnings = basicPay + overtimePay - undertimeDeduction;

                // Format with commas
                totalEarnings.value = earnings.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                return earnings;
            }

            // Calculate deductions
            function calculateDeductions() {
                // Get all deduction values
                const bond = parseFloat(cashBond.value.replace(/,/g, '')) || 0;
                const bills = parseFloat(cashBills.value.replace(/,/g, '')) || 0;
                const advance = parseFloat(cashAdvance.value.replace(/,/g, '')) || 0;
                const hdmfVal = parseFloat(hdmf.value.replace(/,/g, '')) || 0;
                const sssVal = parseFloat(sss.value.replace(/,/g, '')) || 0;
                const philhealthVal = parseFloat(philhealth.value.replace(/,/g, '')) || 0;

                // Total deductions
                const deductions = bond + bills + advance + hdmfVal + sssVal + philhealthVal;

                // Format with commas
                totalDeduction.value = deductions.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                return deductions;
            }

            // Calculate net pay
            function calculateNetPay() {
                const earnings = parseFloat(totalEarnings.value.replace(/,/g, '')) || 0;
                const deductions = parseFloat(totalDeduction.value.replace(/,/g, '')) || 0;

                // Calculate net pay
                const net = earnings - deductions;

                // Format with commas
                netPay.value = net.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                return net;
            }

            // Add input event listeners
            editableInputs.forEach(input => {
                input.addEventListener('input', calculateAll);
            });

            // Save current values for cancel functionality
            function saveCurrentValues() {
                editableInputs.forEach(input => {
                    originalValues[input.id] = input.value;
                });
            }

            // Reset to original values
            function resetToOriginalValues() {
                editableInputs.forEach(input => {
                    input.value = originalValues[input.id];
                });
                calculateAll();
            }

            // Button event listeners
            editBtn.addEventListener('click', function() {
                // Enable all editable fields
                editableInputs.forEach(input => {
                    input.disabled = false;
                });

                // Style active button
                editBtn.style.backgroundColor = '#5073fb';
                editBtn.style.color = 'white';
            });

            saveBtn.addEventListener('click', function() {
                // Show loading indicator
                document.querySelector('.loading-container').style.display = 'flex';

                setTimeout(() => {
                    // Hide loading indicator
                    document.querySelector('.loading-container').style.display = 'none';

                    // Save current values
                    saveCurrentValues();

                    // Disable inputs after save if not in edit mode
                    if (editBtn.style.backgroundColor !== 'rgb(80, 115, 251)') {
                        editableInputs.forEach(input => {
                            input.disabled = true;
                        });
                    }

                    // Show success message
                    const successMsg = document.createElement('div');
                    successMsg.className = 'success-message';
                    successMsg.textContent = 'Payroll saved successfully!';
                    successMsg.style.backgroundColor = '#4CAF50';
                    successMsg.style.color = 'white';
                    successMsg.style.padding = '10px';
                    successMsg.style.textAlign = 'center';
                    successMsg.style.marginBottom = '10px';

                    const formContainer = document.querySelector('.payroll-form');
                    formContainer.insertBefore(successMsg, formContainer.firstChild);

                    setTimeout(() => {
                        successMsg.remove();
                    }, 3000);
                }, 1000);
            });

            cancelBtn.addEventListener('click', function() {
                // Reset to original values
                resetToOriginalValues();

                // Reset edit button style
                editBtn.style.backgroundColor = '';
                editBtn.style.color = '';

                // Disable fields if not in edit mode
                if (editBtn.style.backgroundColor !== 'rgb(80, 115, 251)') {
                    editableInputs.forEach(input => {
                        input.disabled = true;
                    });
                }
            });

            closeBtn.addEventListener('click', function() {
                const confirmClose = confirm("Are you sure you want to close this payroll form?");
                if (confirmClose) {
                    payrollModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });

            // Initialize the form when DOM is loaded
            initializeForm();
        });
    </script>


</body>

</html>