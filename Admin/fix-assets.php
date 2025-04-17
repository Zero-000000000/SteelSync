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
    <link href="css/fix-assets.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>

    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>


    <div class="main--content">
        <div class="inventory-container">
            <h1 class="title">INVENTORY ASSET</h1>
            <div class="search-container">
                <input type="text" id="search-input" class="search-input" placeholder="Search">
                <button id="search-button" class="search-button">Search</button>
                <select id="category-select" class="dropdown">
                    <option value="all">All</option>
                    <option value="tools">Tools</option>
                    <option value="vehicles">Vehicles</option>
                    <option value="machines">Machines</option>
                </select>
                <button class="new-btn" id="newOrderBtn">
                    <span style="font-size: 18px;">+</span> New Order
                </button>
            </div>

            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Code</th>
                        <th>Color Code</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody id="inventory-body">
                </tbody>
            </table>

            <div class="pagination">
                <button class="pagination-btn prev-btn">Prev</button>
                <span id="pageInfo">Page 1 of 3</span>
                <button class="pagination-btn next-btn active">Next</button>
            </div>
        </div>
    </div>
    <div id="orderModal-sales" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Assets</h2><br><br>
            <form id="materialsOrderForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="itemName">Item Name</label>
                        <input type="text" id="itemName" name="itemName" required>
                    </div>
                    <div class="form-group">
                        <label for="itemCode">Item Code</label>
                        <input type="text" id="itemCode" name="itemCode" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="colorCode">Color Code</label>
                        <input type="text" id="colorCode" name="colorCode" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" name="quantity" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">Submit <span class="arrow">→</span></button>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inventoryData = [{
                    name: 'GRINDER',
                    code: '210',
                    colorCode: 'Red',
                    quantity: '20'
                },
                {
                    name: 'DRILL',
                    code: '211',
                    colorCode: 'Orange',
                    quantity: '20'
                },
                {
                    name: 'WELDING MACHINE',
                    code: '212',
                    colorCode: 'Yellow',
                    quantity: '10'
                },
                {
                    name: 'CHIPPING GUN',
                    code: '213',
                    colorCode: 'Blue',
                    quantity: '17'
                },
                {
                    name: 'VEHICLE PACKAGE 1',
                    code: '214',
                    colorCode: 'Green',
                    quantity: '1'
                },
                {
                    name: 'VEHICLE PACKAGE 2',
                    code: '215',
                    colorCode: 'Maroon',
                    quantity: '1'
                },
                {
                    name: 'VEHICLE PACKAGE 3',
                    code: '216',
                    colorCode: 'Yellow Green',
                    quantity: '1'
                },
                {
                    name: 'VEHICLE PACKAGE 4',
                    code: '217',
                    colorCode: 'Pink',
                    quantity: '1'
                },
                {
                    name: 'VEHICLE PACKAGE 5',
                    code: '218',
                    colorCode: 'Black',
                    quantity: '1'
                },
                {
                    name: 'VEHICLE PACKAGE 6',
                    code: '219',
                    colorCode: 'Cyan',
                    quantity: '1'
                },
                {
                    name: 'VEHICLE PACKAGE 7',
                    code: '220',
                    colorCode: 'Violet',
                    quantity: '1'
                }
            ];

            let currentPage = 1;
            const itemsPerPage = 5;
            const totalPages = Math.ceil(inventoryData.length / itemsPerPage);

            function populateTable(data) {
                const tableBody = document.getElementById('inventory-body');
                tableBody.innerHTML = '';

                data.forEach(item => {
                    const row = document.createElement('tr');

                    const nameCell = document.createElement('td');
                    nameCell.textContent = item.name;

                    const codeCell = document.createElement('td');
                    codeCell.textContent = item.code;
                    // Removed the contentEditable property here

                    const colorCodeCell = document.createElement('td');
                    colorCodeCell.textContent = item.colorCode;
                    // Removed the contentEditable property here

                    const quantityCell = document.createElement('td');
                    quantityCell.textContent = item.quantity;
                    // Removed the contentEditable property here

                    row.appendChild(nameCell);
                    row.appendChild(codeCell);
                    row.appendChild(colorCodeCell);
                    row.appendChild(quantityCell);

                    tableBody.appendChild(row);
                });
            }


            function updatePageInfo() {
                document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${totalPages}`;
            }

            function filterInventory() {
                const searchTerm = document.getElementById('search-input').value.toLowerCase();
                const category = document.getElementById('category-select').value;

                let filteredData = inventoryData;

                if (searchTerm) {
                    filteredData = filteredData.filter(item =>
                        item.name.toLowerCase().includes(searchTerm) ||
                        item.code.toLowerCase().includes(searchTerm) ||
                        item.colorCode.toLowerCase().includes(searchTerm)
                    );
                }

                if (category !== 'all') {
                    if (category === 'tools') {
                        filteredData = filteredData.filter(item => ['GRINDER', 'DRILL', 'CHIPPING GUN'].includes(item.name));
                    } else if (category === 'vehicles') {
                        filteredData = filteredData.filter(item =>
                            item.name.includes('VEHICLE PACKAGE')
                        );
                    } else if (category === 'machines') {
                        filteredData = filteredData.filter(item =>
                            item.name.includes('MACHINE')
                        );
                    }
                }

                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = currentPage * itemsPerPage;
                const pageData = filteredData.slice(startIndex, endIndex);

                populateTable(pageData);
                updatePageInfo();
            }

            document.getElementById('search-button').addEventListener('click', filterInventory);
            document.getElementById('search-input').addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    filterInventory();
                }
            });
            document.getElementById('category-select').addEventListener('change', filterInventory);

            // Pagination buttons
            document.querySelector('.prev-btn').addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    filterInventory();
                }
            });

            document.querySelector('.next-btn').addEventListener('click', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    filterInventory();
                }
            });

            // Initial population of the table
            filterInventory();
        });

        // Get references to the modal, open button, and close button
        const modalSales = document.getElementById("orderModal-sales");
        const closeModalButton = modalSales.querySelector(".close");
        const newOrderBtn = document.getElementById("newOrderBtn"); // Assuming this is the button for new materials

        // When the "New Order" button is clicked, open the modal
        newOrderBtn.addEventListener("click", function() {
            modalSales.style.display = "block";
        });

        // When the close button (×) is clicked, close the modal
        closeModalButton.addEventListener("click", function() {
            modalSales.style.display = "none";
        });

        // When clicking anywhere outside the modal, close the modal
        window.addEventListener("click", function(event) {
            if (event.target === modalSales) {
                modalSales.style.display = "none";
            }
        });

        // Handle form submission for adding new materials
        const materialsOrderForm = document.getElementById("materialsOrderForm");
        materialsOrderForm.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Get the form values
            const itemName = document.getElementById("itemName").value;
            const itemCode = document.getElementById("itemCode").value;
            const colorCode = document.getElementById("colorCode").value;
            const quantity = document.getElementById("quantity").value;

            // Simple validation (you can expand it)
            if (itemName && itemCode && colorCode && quantity) {
                // Here you can add the logic for what happens when the form is submitted
                // For example, you could send the data to the server or update the inventory list

                console.log("New Material Added:");
                console.log(`Item Name: ${itemName}, Item Code: ${itemCode}, Color Code: ${colorCode}, Quantity: ${quantity}`);

                // Close the modal after form submission
                modalSales.style.display = "none";

                // Optionally, reset the form
                materialsOrderForm.reset();
            } else {
                alert("Please fill in all fields.");
            }
        });
    </script>
    <?php include "includes/script.php"; ?>
</body>

</html>