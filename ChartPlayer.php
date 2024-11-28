<?php include 'auth.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gender Distribution Pie Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome for icons (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <link rel="stylesheet" href="header&footerAdmin.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: linear-gradient(to right, black, #D6B400);
            font-family: Arial, sans-serif;
            color: white;
            margin-bottom: 30px;
            /* Adjust this value as needed */
        }

        .card {
            background-color: #1a1c35;
            padding: 20px;
            border-radius: 15px;
            margin: 15px 0;
            max-width: 700px;
            max-height: 600px;
        }

        .card2 {
            background-color: #1a1c35;
            padding: 20px;
            border-radius: 15px;
            margin: 15px 0;
            height: auto;
            width: auto;
            margin-bottom: 20px;
            /* Add bottom margin here */
        }


        h2 {
            font-size: 1.5rem;
            color: #f8f9fa;
        }

        .chart-container {
            max-width: 100%;
            margin: auto;
            padding: 10px;
        }

        .chart-container2 {
            max-width: 100%;
            margin: auto;
            padding: 10px;
            height: 500px;
            /* Set a fixed height for the chart */

        }

        .generate-report-btn {
            background-color: #009E60;
            /* Green */
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.2s;
            border-radius: 10px;
        }

        .generate-report-btn:hover {
            background-color: darkgreen;
            /* Darker green on hover */
            transform: scale(1.05);
            /* Slight upscale on hover */
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="Admin.php">
                <img src="MsttcLogo-1.png" alt="Club Logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-grid-fill" style="font-size: 1.5rem; color: white;"></i>
            </button>

            <!-- Center the navbar links -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="custom-link-admin" href="Admin.php">
                            <i class="bi bi-house-fill"> Home Admin</i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="playerDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            PLAYER
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="playerDropdown">
                            <li><a class="dropdown-item" href="RegistrationPlayer.php">Add Player</a></li>
                            <li><a class="dropdown-item" href="UpdatePlayer.php">Update Player</a></li>
                            <li><a class="dropdown-item" href="DeletePlayer.php">Delete Player</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="newsDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            NEWS
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="newsDropdown">
                            <li><a class="dropdown-item" href="RegistrationNews.php">Add News</a></li>
                            <li><a class="dropdown-item" href="UpdateNews.php">Update News</a></li>
                            <li><a class="dropdown-item" href="DeleteNews.php">Delete News</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="tournamentDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            TOURNAMENT
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="tournamentDropdown">
                            <li><a class="dropdown-item" href="RegistrationTournament.php">Add Tournament</a></li>
                            <li><a class="dropdown-item" href="UpdateTournament.php">Update Tournament</a></li>
                            <li><a class="dropdown-item" href="DeleteTournament.php">Delete Tournament</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            ABOUT US
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                            <li><a class="dropdown-item" href="RegistrationAboutUs.php">Add YT Link</a></li>
                            <li><a class="dropdown-item" href="DeleteAboutUs.php">Delete YT Link</a></li>
                        </ul>
                    </li>

                    <!-- Profile Icon with Dropdown -->
                    <li class="nav-item dropdown text-right mt-2">
                        <a href="#" class="profile-icon" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirmLogOutModal">Log Out</button></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5" style="margin-bottom: 20px;">
        <div class="row justify-content-center">
            <!-- First Row: Playstyle and CareerType -->
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card text-center">
                    <h2>Player Playstyle </h2>
                    <div class="chart-container">
                        <canvas id="playstyleChart"></canvas>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card text-center">
                    <h2>Player Career Type </h2>
                    <div class="chart-container">
                        <canvas id="careerTypeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <!-- Second Row: Grip and DominantHand -->
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card text-center">
                    <h2>Player Grip</h2>
                    <div class="chart-container">
                        <canvas id="gripChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card text-center">
                    <h2>Player Dominant Hand</h2>
                    <div class="chart-container">
                        <canvas id="dominantHandChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center mb-4">
            <!-- Age Distribution Bar Chart -->
            <div class="container mt-5 pb-5"> <!-- Add pb-5 for bottom padding -->
                <div class="chart-container2">
                    <div class="card2 text-center">
                        <h2>Player Age</h2>
                        <div class="chart-container2">
                            <canvas id="ageDistributionChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <br>

        <div class="text-center mt-4">
            <button id="generateReportBtn" class="generate-report-btn" onclick="generateAllReports()">Generate All Chart Report</button>
        </div>
    </div>



    <!-- Log Out Confirmation Modal -->
    <div class="modal fade" id="confirmLogOutModal" tabindex="-1" aria-labelledby="confirmLogOutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:#1a1c35;">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmLogOutModalLabel" style="color: silver; font-weight: bold;">Confirm Log Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: white;">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <a href="logout.php" class="btn btn-danger" id="confirmLogOutButton">Yes, Log Out</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to create a pie chart
        function createPieChart(chartId, data, label) {
            const labels = data.map(item => item[label]);
            const counts = data.map(item => item.count);

            const ctx = document.getElementById(chartId).getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: counts,
                        backgroundColor: ['#4BC0C0', '#FFD700', '#FF6384', '#9966FF', '#FF7F50'],
                        borderColor: ['#FFFFFF'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: 'white'
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    }
                }
            });
        }

        // Function to create a bar chart
        function createBarChart(chartId, data) {
            const labels = data.map(item => item.ageRange);
            const counts = data.map(item => item.count);

            const ctx = document.getElementById(chartId).getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Players',
                        data: counts,
                        backgroundColor: '#4BC0C0',
                        borderColor: '#FFFFFF',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: 'white'
                            },
                            title: {
                                display: true,
                                text: 'Age Range',
                                color: 'white'
                            }
                        },
                        y: {
                            ticks: {
                                color: 'white'
                            },
                            title: {
                                display: true,
                                text: 'Player Count',
                                color: 'white'
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    }
                }
            });
        }

        // Fetch and display Playstyle chart
        fetch('inputPlayStyleChart.php')
            .then(response => response.json())
            .then(data => createPieChart('playstyleChart', data, 'Playstyle'))
            .catch(error => console.error('Error fetching Playstyle data:', error));

        // Fetch and display CareerType chart
        fetch('inputCareerTypeChart.php')
            .then(response => response.json())
            .then(data => createPieChart('careerTypeChart', data, 'CareerType'))
            .catch(error => console.error('Error fetching CareerType data:', error));

        // Fetch and display Grip chart
        fetch('inputGripChart.php')
            .then(response => response.json())
            .then(data => createPieChart('gripChart', data, 'Grip'))
            .catch(error => console.error('Error fetching Grip data:', error));

        // Fetch and display DominantHand chart
        fetch('inputDominantHandChart.php')
            .then(response => response.json())
            .then(data => createPieChart('dominantHandChart', data, 'DominantHand'))
            .catch(error => console.error('Error fetching DominantHand data:', error));

        // Fetch and display Age Distribution bar chart
        fetch('inputAgeChart.php')
            .then(response => response.json())
            .then(data => createBarChart('ageDistributionChart', data))
            .catch(error => console.error('Error fetching Age Distribution data:', error));

        function generateAllReports() {
            window.open('inputGenerateReport.php', '_blank');
        }
    </script>
</body>

</html>