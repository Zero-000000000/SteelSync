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



        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            padding: 20px;
            border-radius: 20px;
            min-width: 230px;
            height: auto;
            transition: .3s;
        }

        .card:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .card--data {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .card h1 {
            font-size: 30px;
            margin-top: 10px;
        }

        .card--icon--lg {
            font-size: 80px;
        }

        .card--stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 5px;
        }

        .card--stats span {
            display: flex;
            align-items: center;
        }

        .card--icon {
            margin-right: 5px;
        }

        .stat--icon {
            color: #5f5ce0;
        }

        .up--arrow {
            color: #70d7a5;
        }

        .down--arrow {
            color: #e86786;
        }

        .card-1 {
            background-color: rgba(80, 115, 251, .1);
        }

        .card-1 .card--title {
            color: rgba(80, 115, 251, 1);
        }

        .card-1 .card--icon--lg {
            color: rgba(80, 115, 251, .4);
        }

        .card-2 {
            background-color: rgba(241, 210, 67, .1);
        }

        .card-2 .card--title {
            color: rgba(241, 210, 67, 1);
        }

        .card-2 .card--icon--lg {
            color: rgba(241, 210, 67, .4);
        }

        .card-3 {
            background-color: rgba(112, 215, 165, .1);
        }

        .card-3 .card--title {
            color: rgba(112, 215, 165, 1);
        }

        .card-3 .card--icon--lg {
            color: rgba(112, 215, 165, .4);
        }

        .card-4 {
            background-color: rgba(227, 106, 200, .1);
        }

        .card-4 .card--title {
            color: rgba(227, 106, 200, 1);
        }

        .card-4 .card--icon--lg {
            color: rgba(227, 106, 200, .4);
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
        <div class="cards">
            <div class="card card-1">
                <div class="card--data">
                    <div class="card--content">
                        <h5 class="card--title">Total Customer</h5>
                        <h1>152</h1>
                    </div>
                    <i class="ri-user-2-line card--icon--lg"></i>
                </div>
            </div>
            <div class="card card-2">
                <div class="card--data">
                    <div class="card--content">
                        <h5 class="card--title">New Customer</h5>
                        <h1>1145</h1>
                    </div>
                    <i class="ri-user-line card--icon--lg"></i>
                </div>
            </div>
            <div class="card card-3">
                <div class="card--data">
                    <div class="card--content">
                        <h5 class="card--title">Total Complete Service</h5>
                        <h1>102</h1>
                    </div>
                    <i class="ri-check-line card--icon--lg"></i>
                </div>
            </div>
            <div class="card card-4">
                <div class="card--data">
                    <div class="card--content">
                        <h5 class="card--title">Total Income</h5>
                        <h1>15</h1>
                    </div>
                    <i class="ri-money-dollar-circle-line card--icon--lg"></i>
                </div>
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

        <div class="section">
            <h3>Input Payroll Data</h3>
            <p>Enter details accurately</p>
            <div class="payroll-input">
                <input type="text" placeholder="Hours Worked">
                <input type="text" placeholder="Overtime Hours (if applicable)">
            </div>
            <button class="submit-btn">Submit</button>
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