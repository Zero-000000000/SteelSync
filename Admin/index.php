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
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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