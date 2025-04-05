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

        .container {
            max-width: 1000px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .title {
            border-bottom: solid 1px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 24px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 80px;
            font-size: 24px;
            display: flex;
            gap: 60%;
            color: #333;
            font-weight: bold;
        }

        .search-container {
            padding: 15px 20px;
            display: flex;
            gap: 10px;
            background-color: white;
            height: 70px;
        }

        .dropdown {
            min-width: 150px;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            cursor: pointer;
        }

        .inventory-container {
            background-color: #fff;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 15px;
            margin-bottom: 15px;
            gap: 10px;
            padding-right: 10px;
            padding-bottom: 10px;
        }

        .pagination-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            background-color: #f0f0f0;
            color: #000;
        }

        .pagination-btn.active {
            background-color: #ffa500;
            /* Orange color */
            color: white;
        }

        #pageInfo {
            font-size: 14px;
        }

        .search-input {
            width: 240px;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search-button {
            padding: 8px 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #f9f9f9;
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inventory-table th {
            background-color: #f9f9f9;
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .inventory-table td {
            padding: 10px 15px;
            border: 1px solid #ddd;
        }

        .inventory-table tr:hover {
            background-color: #f5f5f5;
        }

        tr th {
            height: 60px;
        }

        td {
            background-color: #fff;
            text-align: center;
            font-size: 13px;
        }

        .editable-cell {
            cursor: pointer;
        }

        .editable-cell:focus {
            outline: 2px solid #4d90fe;
            background-color: #fff;
        }
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inventoryData = [{
                    name: 'GRINDER',
                    code: '210',
                    colorCode: 'Green',
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
                    colorCode: 'Red',
                    quantity: '10'
                },
                {
                    name: 'CHIPPING GUN',
                    code: '213',
                    colorCode: 'Mlue',
                    quantity: '17'
                },
                {
                    name: 'VEHICLE PACKAGE 1',
                    code: '214',
                    colorCode: 'Manyenta',
                    quantity: '1'
                },
                {
                    name: 'VEHICLE PACKAGE 2',
                    code: '215',
                    colorCode: 'Mayoon',
                    quantity: '1'
                },
                {
                    name: 'VEHICLE PACKAGE 3',
                    code: '216',
                    colorCode: 'Nyelow',
                    quantity: '1'
                },
                {
                    name: 'VEHICLE PACKAGE 4',
                    code: '217',
                    colorCode: 'Mink',
                    quantity: '1'
                },
                {
                    name: 'VEHICLE PACKAGE 5',
                    code: '218',
                    colorCode: 'Mlack',
                    quantity: '1'
                },
                {
                    name: 'VEHICLE PACKAGE 6',
                    code: '219',
                    colorCode: 'Mlue',
                    quantity: '1'
                },
                {
                    name: 'VEHICLE PACKAGE 7',
                    code: '220',
                    colorCode: 'Miolet',
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
    </script>
    <?php include "includes/script.php"; ?>
</body>

</html>