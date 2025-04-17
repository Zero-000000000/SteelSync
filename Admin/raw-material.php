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
    <link href="css/raw_material.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>


    <div class="main--content">
        <div class="inventory">
            <div class="title">
                <h1>INVENTORY</h1>
                <div class="navi">
                    <a href="#sales" id="salesOrderTab" class="active-tab" onclick="showSalesOrder()">Sales Order</a>
                    <a href="#purchase" id="purchaseOrderTab" onclick="showPurchaseOrder()">Purchase Order</a>
                </div>
            </div>

            <div class="control">
                <div class="search-container">
                    <input class="searchBar" type="text" id="search" placeholder="Search..." onkeyup="filterTable()">
                </div>
                <div class="filter-container">
                    <select id="statusFilter" class="dropdown" onchange="filterStatus()">
                        <option value="">All</option>
                        <option value="scheduled">Completed</option>
                        <option value="not-confirmed">Ongoing</option>
                    </select>
                </div>
                <button class="new-btn" id="newOrderBtn">
                    <span style="font-size: 18px;">+</span> New Order
                </button>
            </div>

            <table id="inventoryTable">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Incoming Stocks</th>
                        <th>Reserve Stocks</th>
                        <th>Remaining Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                </tbody>
            </table>

            <div id="purchaseOrderSection" style="display: none;">
                <table>
                    <thead>
                        <tr>
                            <th>Supplier Name</th>
                            <th>Item Name</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Jennylyn Vinuya</td>
                            <td>Gate Funirization</td>
                            <td>Paid</td>
                            <td>Completed</td>
                            <td><button class="action-btn">⋮</button></td>
                        </tr>
                        <tr>
                            <td>Mike Dela Cruz</td>
                            <td>Gate Fabrication</td>
                            <td>Unpaid</td>
                            <td>Ongoing</td>
                            <td><button class="action-btn">⋮</button></td>
                        </tr>
                        <tr>
                            <td>Ozzy Hernandez</td>
                            <td>Gate Fabrication</td>
                            <td>Paid</td>
                            <td>Completed</td>
                            <td><button class="action-btn">⋮</button></td>
                        </tr>
                        <tr>
                            <td>Angelo Agcuitan</td>
                            <td>Gate Fabrication</td>
                            <td>Unpaid</td>
                            <td>Ongoing</td>
                            <td><button class="action-btn">⋮</button></td>
                        </tr>
                        <tr>
                            <td>Alexis Paira</td>
                            <td>Gate Fabrication</td>
                            <td>Unpaid</td>
                            <td>Ongoing</td>
                            <td><button class="action-btn">⋮</button></td>
                        </tr>
                        <tr>
                            <td>Rossel Tiqua</td>
                            <td>Gate Fabrication</td>
                            <td>Paid</td>
                            <td>Completed</td>
                            <td><button class="action-btn">⋮</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>



            <div class="pagination">
                <button style="color: #000;" onclick="prevPage()">Prev</button>
                <span id="pageInfo">Page 1</span>
                <button style="background-color:darkorange" onclick="nextPage()">Next</button>
            </div>
        </div>
    </div>
    <div id="orderModal-purchase" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Order Form</h2>
            <form id="orderForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="fullName">Supplier Name</label>
                        <input type="text" id="fullName" name="fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" id="company" name="company" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="item">Item</label>
                        <input type="text" id="item" name="item" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="tel" id="quantity" name="quantity" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">Submit <span class="arrow">→</span></button>
                </div>
            </form>
        </div>
    </div>
    <div id="orderModal-sales" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Materials</h2>
            <form id="salesOrderForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="fullName">Item Name</label>
                        <input type="text" id="fullName" name="fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="company">Item Code</label>
                        <input type="text" id="company" name="company" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="item">Color Code</label>
                        <input type="text" id="item" name="item" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="tel" id="quantity" name="quantity" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">Submit <span class="arrow">→</span></button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const items = [{
                name: "Flap disc",
                incoming: 100,
                reserve: 1
            },
            {
                name: "Cutting wheel",
                incoming: 100,
                reserve: 1
            },
            {
                name: "Grinding wheel",
                incoming: 100,
                reserve: 1
            },
            {
                name: "Electrical tape",
                incoming: 100,
                reserve: 1
            },
            {
                name: "2gang",
                incoming: 100,
                reserve: 1
            },
            {
                name: "Outlet (2gang)",
                incoming: 100,
                reserve: 1
            },
            {
                name: "Blank plate",
                incoming: 100,
                reserve: 0
            },
            {
                name: "Amon/ciyo box",
                incoming: 100,
                reserve: 0
            },
            {
                name: "1gang switch",
                incoming: 100,
                reserve: 0
            },
            {
                name: "Utility box",
                incoming: 100,
                reserve: 0
            },
            {
                name: "Flux cored",
                incoming: 100,
                reserve: 0
            },
            {
                name: "Welding rod",
                incoming: 100,
                reserve: 0
            },
            {
                name: "Cylindrical",
                incoming: 100,
                reserve: 0
            },
            {
                name: "Acrylic sealant (black)",
                incoming: 100,
                reserve: 0
            },
            {
                name: "Acrylic sealant (brown)",
                incoming: 100,
                reserve: 0,
                status: "Call Supplier"
            }
        ];

        let currentPage = 1;
        const rowsPerPage = 5;

        function renderTable() {
            const tableBody = document.getElementById("tableBody");
            tableBody.innerHTML = "";
            let start = (currentPage - 1) * rowsPerPage;
            let end = start + rowsPerPage;
            let paginatedItems = items.slice(start, end);

            paginatedItems.forEach((item, index) => {
                let remainingStock = item.incoming - item.reserve;
                let row = `<tr>
            <td>${item.name}</td>
            <td>${item.incoming}</td>
            <td>
                <button class="control-btn" onclick="updateStock(${start + index}, -1)">-</button>
                <input type="number" value="${item.reserve}" min="0" max="${item.incoming}" oninput="manualUpdateStock(${start + index}, this.value)">
                <button class="control-btn" onclick="updateStock(${start + index}, 1)">+</button>
            </td>
            <td>${remainingStock}</td>
            <td>${item.status ? item.status : ""}</td>
        </tr>`;
                tableBody.innerHTML += row;
            });

            document.getElementById("pageInfo").innerText = `Page ${currentPage} of ${Math.ceil(items.length / rowsPerPage)}`;
        }

        function updateStock(index, change) {
            let newReserve = items[index].reserve + change;
            if (newReserve >= 0 && newReserve <= items[index].incoming) {
                items[index].reserve = newReserve;
                renderTable();
            }
        }

        function manualUpdateStock(index, value) {
            let newReserve = parseInt(value);
            if (!isNaN(newReserve) && newReserve >= 0 && newReserve <= items[index].incoming) {
                items[index].reserve = newReserve;
                renderTable();
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        }

        function nextPage() {
            if (currentPage < Math.ceil(items.length / rowsPerPage)) {
                currentPage++;
                renderTable();
            }
        }

        function filterTable() {
            let searchInput = document.getElementById("search").value.toLowerCase();
            let filteredItems = items.filter(item => item.name.toLowerCase().includes(searchInput));

            if (filteredItems.length > 0) {
                document.getElementById("tableBody").innerHTML = "";
                filteredItems.forEach(item => {
                    let remainingStock = item.incoming - item.reserve;
                    let row = `<tr>
                <td>${item.name}</td>
                <td>${item.incoming}</td>
                <td>
                    <button class="control-btn">-</button>
                    <input type="number" value="${item.reserve}" min="0" max="${item.incoming}">
                    <button class="control-btn">+</button>
                </td>
                <td>${remainingStock}</td>
                <td>${item.status ? item.status : ""}</td>
            </tr>`;
                    document.getElementById("tableBody").innerHTML += row;
                });
            } else {
                document.getElementById("tableBody").innerHTML = "<tr><td colspan='5'>No items found</td></tr>";
            }
        }

        renderTable();

        document.addEventListener('DOMContentLoaded', function() {

            showSalesOrder();
        });

        function showSalesOrder() {
            document.getElementById("inventoryTable").style.display = "table";
            document.getElementById("purchaseOrderSection").style.display = "none";

            document.getElementById("salesOrderTab").classList.add("active-tab");
            document.getElementById("purchaseOrderTab").classList.remove("active-tab");
        }

        function showPurchaseOrder() {
            document.getElementById("inventoryTable").style.display = "none";
            document.getElementById("purchaseOrderSection").style.display = "block";

            document.getElementById("statusFilter").style.display = "block";

            document.getElementById("salesOrderTab").classList.remove("active-tab");
            document.getElementById("purchaseOrderTab").classList.add("active-tab");
        }

        // Get modal elements
        const salesModal = document.getElementById("orderModal-sales");
        const purchaseModal = document.getElementById("orderModal-purchase");

        // Get close button for each modal
        const closeSalesModal = salesModal.querySelector(".close");
        const closePurchaseModal = purchaseModal.querySelector(".close");

        // Show the modal based on the active tab
        document.getElementById("newOrderBtn").addEventListener("click", function() {
            if (document.getElementById("salesOrderTab").classList.contains("active-tab")) {
                // Show Sales Order modal
                salesModal.style.display = "block";
            } else if (document.getElementById("purchaseOrderTab").classList.contains("active-tab")) {
                // Show Purchase Order modal
                purchaseModal.style.display = "block";
            }
        });

        // Close modals when the close button is clicked
        closeSalesModal.addEventListener("click", function() {
            salesModal.style.display = "none";
        });

        closePurchaseModal.addEventListener("click", function() {
            purchaseModal.style.display = "none";
        });

        // Close modals if the user clicks outside of the modal
        window.addEventListener("click", function(event) {
            if (event.target === salesModal) {
                salesModal.style.display = "none";
            } else if (event.target === purchaseModal) {
                purchaseModal.style.display = "none";
            }
        });

        // Function to update the button text based on the active tab
        function updateButtonText() {
            const newOrderBtn = document.getElementById("newOrderBtn");

            // Check if Sales Order tab is active
            if (document.getElementById("salesOrderTab").classList.contains("active-tab")) {
                newOrderBtn.innerHTML = '<span style="font-size: 18px;">+ </span> New Materials'; // Change text to "New Item"
            } else if (document.getElementById("purchaseOrderTab").classList.contains("active-tab")) {
                newOrderBtn.innerHTML = '<span style="font-size: 18px;">+</span> New Order'; // Keep it as "New Order"
            }
        }

        // Update the button text when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateButtonText();
        });

        // Also call this function when switching tabs to ensure the button text updates dynamically
        document.getElementById("salesOrderTab").addEventListener("click", function() {
            updateButtonText();
        });

        document.getElementById("purchaseOrderTab").addEventListener("click", function() {
            updateButtonText();
        });
    </script>
    <?php include "includes/script.php"; ?>
</body>

</html>