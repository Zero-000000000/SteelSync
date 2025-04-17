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
    <link href="css/pointofsale.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>

    <div class="main--content">
        <div class="orders-manager-container">
            <div class="orders-manager-header">
                <h2>ORDERS MANAGER</h2>
            </div>

            <div class="orders-manager-tools">
                <div class="filter-search">
                    <div class="dropdown">
                        <select id="filterDropdown">
                            <option value="all">All Orders</option>
                            <option value="archived">Archived Orders</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="complete">Complete</option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                        </select>
                    </div>
                    <div class="search-container">
                        <input type="text" id="searchInput" placeholder="Search by client name">
                        <button class="search-btn">Search</button>
                    </div>
                </div>
                <button class="add-order-btn" id="openOrderModalBtn">
                    <i class="fas fa-plus"></i> Add Order
                </button>
            </div>

            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Service Availed</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                    <!-- Orders will be populated via JavaScript -->
                </tbody>
            </table>

            <div class="pagination">
                <div class="page-buttons">
                    <button class="page-btn" id="prevBtn" disabled><i class="fas fa-chevron-left"></i> Prev</button>
                    <div class="page-numbers" id="pageNumbers">
                        <button class="page-number active">1</button>
                    </div>
                    <button class="page-btn" id="nextBtn">Next <i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="page-info">
                    Page:
                    <input type="text" class="page-input" id="pageInput" value="1">
                    of <span id="totalPages">1</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Add New Order</h2>
            <form id="orderForm">
                <input type="hidden" id="orderId" value="">

                <div class="form-section">
                    <h3>Client Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="clientName">Client Name</label>
                            <input type="text" id="clientName" required>
                        </div>
                        <div class="form-group">
                            <label for="contactNumber">Contact Number</label>
                            <input type="text" id="contactNumber">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Order Details</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="service">Service</label>
                            <select id="service" required>
                                <option value="Gate Automation">Gate Automation</option>
                                <option value="Sectional Garage Door">Sectional Garage Door</option>
                                <option value="Roll Up Door">Roll Up Door</option>
                                <option value="Smart Electric Fence">Smart Electric Fence</option>
                                <option value="Gate Fabrication">Gate Fabrication</option>
                                <option value="Smart Curtain">Smart Curtain</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" id="quantity" value="1" min="1" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea id="notes" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Status</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="paymentStatus">Payment Status</label>
                            <select id="paymentStatus" required>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="orderStatus">Order Status</label>
                            <select id="orderStatus" required>
                                <option value="ongoing">Ongoing</option>
                                <option value="complete">Complete</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="button" id="cancelBtn">Cancel</button>
                    <button type="submit" id="saveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Archive Confirmation Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content confirmation-modal">
            <h2 id="archiveModalTitle">Confirm Archive</h2>
            <p id="archiveConfirmText">Are you sure you want to archive this order? Archived orders can be restored later.</p>
            <div class="form-buttons">
                <button type="button" id="cancelArchiveBtn">Cancel</button>
                <button type="button" id="confirmArchiveBtn">Archive</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sample order data with archived status
            const orderData = [{
                    id: 1,
                    clientName: "Jennylyn Vinuya",
                    service: "Gate Automation",
                    paymentStatus: "unpaid",
                    orderStatus: "ongoing",
                    archived: false
                },
                {
                    id: 2,
                    clientName: "Mike Dela Cruz",
                    service: "Sectional Garage Door",
                    paymentStatus: "paid",
                    orderStatus: "complete",
                    archived: false
                },
                {
                    id: 3,
                    clientName: "Ozzy Hernandez",
                    service: "Roll Up Door",
                    paymentStatus: "unpaid",
                    orderStatus: "complete",
                    archived: false
                },
                {
                    id: 4,
                    clientName: "Angelo Aqcuitan",
                    service: "Smart Electric Fence",
                    paymentStatus: "paid",
                    orderStatus: "ongoing",
                    archived: false
                },
                {
                    id: 5,
                    clientName: "Alexis Paira",
                    service: "Gate Fabrication",
                    paymentStatus: "paid",
                    orderStatus: "complete",
                    archived: false
                },
                {
                    id: 6,
                    clientName: "Rossel Tiqua",
                    service: "Smart Curtain",
                    paymentStatus: "unpaid",
                    orderStatus: "ongoing",
                    archived: false
                },
                {
                    id: 7,
                    clientName: "Alfred Io",
                    service: "Smart Electric Fence",
                    paymentStatus: "paid",
                    orderStatus: "ongoing",
                    archived: false
                },
                {
                    id: 8,
                    clientName: "Rossel Tiqua",
                    service: "Smart Curtain",
                    paymentStatus: "unpaid",
                    orderStatus: "complete",
                    archived: true
                }
            ];

            // Variables for pagination
            let currentPage = 1;
            const recordsPerPage = 5;
            let filteredData = [...orderData];

            // Elements
            const filterDropdown = document.getElementById('filterDropdown');
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('ordersTableBody');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const pageInput = document.getElementById('pageInput');
            const totalPagesSpan = document.getElementById('totalPages');
            const pageNumbersDiv = document.getElementById('pageNumbers');
            const addOrderBtn = document.getElementById('openOrderModalBtn');
            const orderModal = document.getElementById('orderModal');
            const confirmModal = document.getElementById('confirmModal');
            const modalCloseBtns = document.querySelectorAll('.close');
            const orderForm = document.getElementById('orderForm');
            const modalTitle = document.getElementById('modalTitle');
            const orderIdInput = document.getElementById('orderId');
            const cancelBtn = document.getElementById('cancelBtn');
            const cancelArchiveBtn = document.getElementById('cancelArchiveBtn');
            const confirmArchiveBtn = document.getElementById('confirmArchiveBtn');
            const archiveModalTitle = document.getElementById('archiveModalTitle');
            const archiveConfirmText = document.getElementById('archiveConfirmText');

            // Initialize the page
            function init() {
                displayData();
                setupEventListeners();
            }

            // Filter and display data
            function displayData() {
                // Filter data based on dropdown and search input
                const filterValue = filterDropdown.value;
                const searchValue = searchInput.value.trim().toLowerCase();

                filteredData = orderData.filter(order => {
                    // Filter by dropdown selection
                    const matchesFilter = filterValue === 'all' ||
                        (filterValue === 'archived' && order.archived) ||
                        order.paymentStatus === filterValue ||
                        order.orderStatus === filterValue;

                    // Filter by search text
                    const matchesSearch = order.clientName.toLowerCase().includes(searchValue) ||
                        order.service.toLowerCase().includes(searchValue);

                    return matchesFilter && matchesSearch;
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
                tableBody.innerHTML = '';

                if (currentPageData.length === 0) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.innerHTML = '<td colspan="5" style="text-align: center; padding: 20px;">No orders found</td>';
                    tableBody.appendChild(emptyRow);
                } else {
                    // Create rows for current page data
                    currentPageData.forEach(order => {
                        const row = document.createElement('tr');
                        if (order.archived) {
                            row.classList.add('archived');
                        }

                        row.innerHTML = `
                            <td>${order.clientName} ${order.archived ? '<span class="archived-badge">Archived</span>' : ''}</td>
                            <td>${order.service}</td>
                            <td><span class="status-badge ${order.paymentStatus}">${order.paymentStatus.toUpperCase()}</span></td>
                            <td><span class="status-badge ${order.orderStatus}">${order.orderStatus.toUpperCase()}</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn view-btn" data-id="${order.id}">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="action-btn complete-btn" data-id="${order.id}" ${order.orderStatus === 'complete' || order.archived ? 'disabled' : ''}>
                                        <i class="fas fa-check"></i> Complete
                                    </button>
                                    <button class="action-btn archive-btn ${order.archived ? 'restore-btn' : ''}" data-id="${order.id}">
                                        <i class="fas fa-${order.archived ? 'undo' : 'archive'}"></i> ${order.archived ? 'Restore' : 'Archive'}
                                    </button>
                                </div>
                            </td>
                        `;

                        tableBody.appendChild(row);
                    });

                    // Add event listeners for action buttons
                    addActionButtonEventListeners();
                }
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
                document.querySelectorAll('.view-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const orderId = btn.getAttribute('data-id');
                        openEditModal(parseInt(orderId));
                    });
                });

                document.querySelectorAll('.complete-btn:not([disabled])').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const orderId = btn.getAttribute('data-id');
                        markOrderComplete(parseInt(orderId));
                    });
                });

                document.querySelectorAll('.archive-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const orderId = btn.getAttribute('data-id');
                        openArchiveConfirmation(parseInt(orderId));
                    });
                });
            }

            // Mark order as complete
            function markOrderComplete(orderId) {
                const order = orderData.find(o => o.id === orderId);
                if (order) {
                    order.orderStatus = 'complete';
                    displayData();
                    alert(`Order #${orderId} marked as complete`);
                }
            }

            // Open edit modal with order data
            function openEditModal(orderId) {
                const order = orderData.find(o => o.id === orderId);
                if (order) {
                    modalTitle.textContent = 'Edit Order';
                    orderIdInput.value = order.id;
                    document.getElementById('clientName').value = order.clientName;
                    document.getElementById('contactNumber').value = order.contactNumber || '';
                    document.getElementById('service').value = order.service;
                    document.getElementById('quantity').value = order.quantity || 1;
                    document.getElementById('notes').value = order.notes || '';
                    document.getElementById('paymentStatus').value = order.paymentStatus;
                    document.getElementById('orderStatus').value = order.orderStatus;

                    orderModal.style.display = 'flex';
                }
            }

            // Open add order modal
            function openAddModal() {
                modalTitle.textContent = 'Add New Order';
                orderForm.reset();
                orderIdInput.value = '';
                orderModal.style.display = 'flex';
            }

            // Open archive confirmation modal
            function openArchiveConfirmation(orderId) {
                const order = orderData.find(o => o.id === orderId);
                if (order) {
                    if (order.archived) {
                        archiveModalTitle.textContent = 'Confirm Restore';
                        archiveConfirmText.textContent = 'Are you sure you want to restore this order?';
                        confirmArchiveBtn.textContent = 'Restore';
                    } else {
                        archiveModalTitle.textContent = 'Confirm Archive';
                        archiveConfirmText.textContent = 'Are you sure you want to archive this order? Archived orders can be restored later.';
                        confirmArchiveBtn.textContent = 'Archive';
                    }

                    confirmArchiveBtn.setAttribute('data-id', orderId);
                    confirmModal.style.display = 'flex';
                }
            }

            // Toggle archive status
            function toggleArchiveStatus() {
                const orderId = parseInt(confirmArchiveBtn.getAttribute('data-id'));
                const order = orderData.find(o => o.id === orderId);

                if (order) {
                    order.archived = !order.archived;
                    displayData();
                    closeModals();
                }
            }

            // Close modals
            function closeModals() {
                orderModal.style.display = 'none';
                confirmModal.style.display = 'none';
            }

            // Save order data
            function saveOrder(event) {
                event.preventDefault();

                // Get form values
                const orderId = orderIdInput.value;
                const isEditMode = orderId !== '';

                const newOrder = {
                    id: isEditMode ? parseInt(orderId) : orderData.length + 1,
                    clientName: document.getElementById('clientName').value,
                    contactNumber: document.getElementById('contactNumber').value,
                    service: document.getElementById('service').value,
                    quantity: document.getElementById('quantity').value,
                    notes: document.getElementById('notes').value,
                    paymentStatus: document.getElementById('paymentStatus').value,
                    orderStatus: document.getElementById('orderStatus').value,
                    archived: false
                };

                if (isEditMode) {
                    // Update existing order
                    const index = orderData.findIndex(o => o.id === parseInt(orderId));
                    if (index !== -1) {
                        // Preserve the archived status when editing
                        newOrder.archived = orderData[index].archived;
                        orderData[index] = newOrder;
                    }
                } else {
                    // Add new order
                    orderData.push(newOrder);
                }

                closeModals();
                displayData();
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

                // Modal controls
                addOrderBtn.addEventListener('click', openAddModal);
                modalCloseBtns.forEach(btn => {
                    btn.addEventListener('click', closeModals);
                });
                cancelBtn.addEventListener('click', closeModals);
                cancelArchiveBtn.addEventListener('click', closeModals);
                confirmArchiveBtn.addEventListener('click', toggleArchiveStatus);
                orderForm.addEventListener('submit', saveOrder);

                // Close modal when clicking outside
                window.addEventListener('click', function(event) {
                    if (event.target === orderModal || event.target === confirmModal) {
                        closeModals();
                    }
                });
            }

            // Initialize the application
            init();
        });
    </script>
    <?php include "includes/script.php"; ?>
</body>

</html>