<?php
session_start();

// Redirect to login if no user is logged in
// Redirect to login if no user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: ../login.php");
    exit();
}

// Verify the user has the correct role
if ($_SESSION["role"] !== 'support_admin') {
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

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .dashboard-header h2 {
            font-size: 22px;
            font-weight: bold;
            font-style: italic;
        }

        .metrics-container {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .metric-box {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .metric-box h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .metric-box p {
            font-size: 22px;
            font-weight: bold;
            margin: 5px 0 0;
        }

        .chart-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            height: 45%;
        }

        .chart {
            width: 100px;
            flex: 1;
            background-color: #fff;
            padding: 60px 30px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .section-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .section {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .payroll-input {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .payroll-input input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .submit-btn {
            background-color: #f57c00;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #e65100;
        }
    </style>
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>


    <div class="main--content">
        <div class="dashboard-header">
            <h2>ORDER FORM - Overview</h2>
            <div class="date-picker">
                <i class="fas fa-calendar"></i>
                <span>Start date → End date</span>
            </div>
        </div>

        <!-- Metrics -->
        <div class="metrics-container">
            <div class="metric-box">
                <h3>Customer Total</h3>
                <p>40</p>
            </div>
            <div class="metric-box">
                <h3>New Customer</h3>
                <p>10</p>
            </div>
            <div class="metric-box">
                <h3>Total Complete Service</h3>
                <p>50</p>
            </div>
            <div class="metric-box">
                <h3>Total Income</h3>
                <p>₱ 100000 </p>
            </div>
        </div>

        <!-- Charts -->
        <div class="chart-container">
            <div class="chart">
                <h3>Revenue Income</h3>
                <p>Amount</p>
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="chart">
                <h3>Service Sales Distribution</h3>
                <p>Sales</p>
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="section-container">
            <div class="section">
                <h3>Attendance Statistics</h3>
                <p>Total Employees: 39</p>
            </div>
            <div class="section">
                <h3>Inventory Overview</h3>
                <p>Flap Disc - Quantity: 100</p>
            </div>
        </div>


    </div>
    </div>

    <script>
        var ctx1 = document.getElementById('revenueChart').getContext('2d');
        var gradient = ctx1.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(0, 0, 0, 0.2)');
        gradient.addColorStop(1, 'rgba(0, 0, 0, 0)');

        var revenueChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [1000, 1200, 900, 1400, 1300, 1500],
                    borderColor: 'rgba(0, 0, 0, 0.7)',
                    borderWidth: 2,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: {
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 14
                        },
                        padding: 8
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#888'
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        ticks: {
                            color: '#888'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            borderDash: [4, 4]
                        },
                        beginAtZero: true
                    }
                }
            }
        });


        var ctx2 = document.getElementById('salesChart').getContext('2d');

        var salesChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Gate Automation', 'Gate Fabrication', 'Sectional Garage Door', 'Sectional Garage Door', ],
                datasets: [{
                    data: [30, 50, 10, 10],
                    backgroundColor: ['#3498db', '#2ecc71', '#f39c12', '#FFFF00'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '50%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 14
                            },
                            color: '#333'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.7)',
                        bodyFont: {
                            size: 14
                        },
                        padding: 10
                    }
                }
            }
        });
    </script>
    <?php include "includes/script.php"; ?>

</body>

</html>