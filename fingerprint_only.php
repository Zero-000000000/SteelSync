<?php

// Fingerprint Scanner Interface

?>

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
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .time-display {
            font-size: 3rem;
            font-weight: bold;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        .date-display {
            font-size: 1.5rem;
        }

        .fingerprint-icon {
            font-size: 100px;
            color: #0d6efd;
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
    </style>
</head>

<body>
    <div class="container py-5">
        <h1 class="text-center mb-4">Employee Attendance Tracking</h1>

        <ul class="nav nav-tabs" id="mainTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="timeclock-tab" data-bs-toggle="tab" data-bs-target="#timeclock"
                    type="button" role="tab" aria-controls="timeclock" aria-selected="true">Time Clock</button>
            </li>
        </ul>

        <div class="tab-content" id="mainTabsContent">
            <!-- Time Clock Tab -->
            <div class="tab-pane fade show active" id="timeclock" role="tabpanel" aria-labelledby="timeclock-tab">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="time-display" id="current-time">00:00:00</div>
                                    <div class="date-display" id="current-date">Loading...</div>
                                </div>

                                <div class="fingerprint-icon mb-3">
                                    <i class="bi bi-fingerprint"></i>
                                </div>

                                <button class="btn btn-primary btn-lg" id="scan-button">
                                    Scan Fingerprint
                                </button>

                                <div class="mt-4" id="scan-status">
                                    <p class="lead text-muted">Place your finger on the scanner</p>
                                    <div class="spinner-border text-primary d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Recent Activity</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group" id="recent-activity">
                                    <!-- Activity entries will be added here via JavaScript -->
                                    <div class="list-group-item text-center text-muted">
                                        No recent activity
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

            // Scan fingerprint
            $('#scan-button').click(function() {
                const button = $(this);
                const status = $('#scan-status');

                button.prop('disabled', true);
                status.find('.spinner-border').removeClass('d-none');
                status.find('p').text('Scanning...');

                // Simulate scanning - in a real app, this would be an AJAX call to the PHP backend
                setTimeout(function() {
                    // Simulate success
                    const isSuccess = Math.random() > 0.1; //success rate for demo

                    if (isSuccess) {
                        // Randomly choose time in or time out
                        const isTimeIn = Math.random() > 0.5;
                        const employee = {
                            name: 'Jennylyn Vinuya',
                            position: 'Business Analyst',
                            department: 'IT'
                        };

                        status.find('p').text(`Success! ${isTimeIn ? 'Time In' : 'Time Out'} recorded.`);
                        status.find('p').removeClass('text-muted').addClass('text-success');

                        // Add to recent activity
                        const timeStr = new Date().toLocaleTimeString();
                        const activityList = $('#recent-activity');
                        activityList.empty();
                        activityList.prepend(`
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${employee.name} - ${isTimeIn ? 'Time In' : 'Time Out'}</h5>
                                    <small>${timeStr}</small>
                                </div>
                                <p class="mb-1">${employee.position}, ${employee.department}</p>
                            </div>
                        `);

                        showNotification(`${employee.name} ${isTimeIn ? 'checked in' : 'checked out'} successfully`, 'success');
                    } else {
                        status.find('p').text('Fingerprint not recognized. Please try again.');
                        status.find('p').removeClass('text-muted').addClass('text-danger');
                        showNotification('Fingerprint not recognized', 'error');
                    }

                    button.prop('disabled', false);
                    status.find('.spinner-border').addClass('d-none');

                    // Reset status after a few seconds
                    setTimeout(function() {
                        status.find('p').text('Place your finger on the scanner');
                        status.find('p').removeClass('text-success text-danger').addClass('text-muted');
                    }, 3000);
                }, 2000);
            });
        });
    </script>