<?php
include 'config.php';
include 'header.php';

$itemsPerPage = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Check if the request is an AJAX request
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// SQL query for fetching unique player data with search and pagination
if ($searchQuery) {
    $sql = "SELECT DISTINCT IdPlayer, Name, NickName, ImagePlayer 
            FROM player 
            WHERE Name LIKE '%$searchQuery%' OR NickName LIKE '%$searchQuery%' 
            ORDER BY RAND() 
            LIMIT $itemsPerPage OFFSET $offset";
} else {
    $sql = "SELECT DISTINCT IdPlayer, Name, NickName, ImagePlayer 
            FROM player 
            ORDER BY RAND() 
            LIMIT $itemsPerPage OFFSET $offset";
}

$result = $connect->query($sql);

// SQL query for total players count for pagination
if ($searchQuery) {
    $totalPlayersQuery = "SELECT COUNT(DISTINCT IdPlayer) AS total FROM player WHERE Name LIKE '%$searchQuery%' OR NickName LIKE '%$searchQuery%'";
} else {
    $totalPlayersQuery = "SELECT COUNT(DISTINCT IdPlayer) AS total FROM player";
}

$totalPlayersResult = $connect->query($totalPlayersQuery);
$totalPlayers = $totalPlayersResult->fetch_assoc()['total'];
$totalPages = ceil($totalPlayers / $itemsPerPage);

if (!$isAjax) :
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MSTTC - Player</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
        <!-- FontAwesome for icons (optional) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

        <link rel="stylesheet" href="header&footer.css">

        <style>
            body {
                background: linear-gradient(to right, black 30%, #d1b000);
            }

            .card {
                text-align: center;
                /*****  background: linear-gradient(to top, #343434 , #d6b400);*/

                background-color: #202020;
            }

            .card:hover {
                background: transparent;
            }

            /* Card Image hover effect */
            .card-img-top {
                max-width: 100%;
                max-height: 300px;
                /* Set a reasonable max height */
                width: auto;
                height: 300px;
                object-fit: cover;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card-img-top:hover {
                transform: scale(1.1) rotate(10deg);
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
                border-color: #d6b400 solid;
            }

            @property --angle {
                syntax: "<angle>";
                initial-value: 0deg;
                inherits: false;
            }

            .card::after,
            .card::before {
                content: '';
                position: absolute;
                height: 101%;
                width: 100%;
                background-image: conic-gradient(from var(--angle), black, black, gold);
                top: 50%;
                left: 50%;
                translate: -50% -50%;
                z-index: -5;
                padding: 3px;
                border-radius: 15px;
                animation: 3s spin linear infinite;
            }

            .card::before {
                filter: blur(1.0rem);
                opacity: 1.0;
            }


            @keyframes spin {
                from {
                    --angle: 0deg;
                }

                to {
                    --angle: 360deg;
                }
            }

            /* Player Name hover effect */
            .card-title {
                color: white;
                /* Initial text color */
                text-decoration: none;
                /* No underline */
                transition: transform 0.3s, color 0.3s;
                /* Smooth transition for hover */
            }

            .card:hover .card-title {
                color: gold;
                /* Change text color to gold on hover */
                transform: scale(1.1);
                /* Scale up the text on hover */
                text-decoration: none;
                /* No underline on hover */
            }

            /* Remove underline from link */
            a.card {
                text-decoration: none;
                /* No underline for the link */
            }

            a.card:hover {
                text-decoration: none;
                /* No underline on hover as well */

            }

            /* Button styling */
            .btn-outline-warning {
                background-color: black;
                /* Change background to black */
                border-color: #ffc107;
                /* Keep the warning outline color */
                color: white;
                /* Change text color to white */
            }

            .btn-outline-warning:hover {
                background-color: #ffc107;
                /* Change to warning color on hover */
                color: black;
                transform: scale(1.1);
                /* Text color to black on hover */
            }

            .pagination {
                justify-content: center;
            }

            .pagination .page-item .page-link {
                color: #d1b000;
                /* Default text color */
                background-color: #202020;
                /* Default background color */
                border: 1px solid #202020;
                transition: background-color 0.3s, color 0.3s;
            }

            .pagination .page-item.active .page-link {
                color: #ff7f50;
                /* Active text color */
                background-color: #202020;
                /* Active background color */
                border-color: #ffcc00;
                /* Active border color */
            }

            .pagination .page-item .page-link:hover {
                background-color: #d1b000;
                /* Hover background color */
                color: #202020;
                /* Hover text color */
            }
        </style>
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-custom ">
            <div class="container-fluid">
                <!-- Club Brand Logo with link to the main page -->
                <a class="navbar-brand" href="index.php">
                    <img src="MsttcLogo-1.png" alt="Club Logo" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link " href="index.php">News & Update</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Ranking.php">Ranking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="Player.php">Player</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Tournament.php">Tournament</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="AboutUs.php">About Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <h1 class="text-center text-white py-3">PLAYER MSTTC</h1>

        <!-- Search Container -->
        <div class="container mb-4">
            <form class="d-flex justify-content-end" onsubmit="return false;">
                <input id="searchInput" class="form-control me-2" type="search" placeholder="Search Player Name or Nickname" aria-label="Search" onkeydown="checkEnter(event)">
                <button class="btn btn-outline-warning" type="button" onclick="searchPlayer()">Search</button>
            </form>
        </div>

        <!-- Player Grid Section -->
        <div class="container">
            <div class="row" id="playerGrid">
            <?php endif; // End of non-AJAX check 
            ?>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <a href="PlayerProfileMenSingle.php?id=<?php echo $row['IdPlayer']; ?>" class="card" data-name="<?php echo $row['Name']; ?>" data-nickname="<?php echo $row['NickName']; ?>">
                            <div class="card-body">
                                <img src="<?php echo $row['ImagePlayer']; ?>" class="card-img-top" alt="<?php echo $row['']; ?>">
                                <h5 class="card-title"><?php echo $row['Name']; ?></h5>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-white">No players found.</p>
            <?php endif; ?>

            <?php if (!$isAjax) : ?>
            </div>
        </div>

        <!-- Pagination Controls -->
        <nav aria-label="Player pagination" class="mt-4">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                <?php endif; ?>
            </ul>
        </nav>


        <!-- Footer -->
        <footer class="bg-dark text-white pt-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="index.php" class="quick-link">News & Update</a></li>
                            <li><a href="Ranking.php" class="quick-link">Ranking</a></li>
                            <li><a href="Player.php" class="quick-link">Player</a></li>
                            <li><a href="Tournament.php" class="quick-link">Tournament</a></li>
                            <li><a href="AboutUs.php" class="quick-link">About Us</a></li>
                            <li><a href="AdminLogin.php" class="quick-link" target="_blank">Admin MSTTC</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 text-center">
                        <h5>Social Links</h5>
                        <a href="https://www.facebook.com/msttc.madzam.shah.table.tannis.club" class="text-white me-2 facebook-link" target="_blank">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://wa.me/60129612701?text=Hello%20I%20am%20interested%20to%20know%20about%20MSTTC" class="text-white whatsapp-link" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <br>


                    </div>
                    <div class="col-md-4 text-center">
                        <h5>Welcome to MSTTC !</h5>
                        <p>Muadzam Shah, Rompin, Pahang, Malaysia</p>
                        <div style="max-width: 600px; margin: 0 auto;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15951.053985349418!2d103.0671794!3d3.0625575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cf097c511ab6ff%3A0x19299b117a82d0ba!2sJalan%20menuju%20Dewan%20Besar%20DARA!5e0!3m2!1sen!2smy!4v1698720180123!5m2!1sen!2smy"
                                width="400"
                                height="200"

                                allowfullscreen=""
                                loading="lazy">
                            </iframe>
                        </div>

                        <a href="https://www.google.com/maps/place/Jalan+menuju+Dewan+Besar+DARA/@3.0625575,103.0671794,14.78z/data=!4m6!3m5!1s0x31cf097c511ab6ff:0x19299b117a82d0ba!8m2!3d3.0629458!4d103.0774027!16s%2Fg%2F11b7r767_g?entry=ttu&g_ep=EgoyMDI0MTAyNy4wIKXMDSoASAFQAw%3D%3D"
                            target="_blank"
                            class="btn btn-primary mt-3"
                            style="font-size: 100%; text-decoration: none; border-radius: 5px; margin-top: 10px; height: 40px;">
                            View on Google Maps
                        </a>

                        <br>

                    </div>
                    <hr style="margin-top: 14px;">
                    <p style="text-align: center; margin-bottom: 30px;">&copy; 2024 MSTTC. All rights reserved.</p>

                </div>
            </div>
        </footer>

        <!-- Bootstrap JS and dependencies (Popper.js and jQuery) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function searchPlayer() {
                var input = document.getElementById("searchInput").value.toLowerCase();
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "Player.php?search=" + encodeURIComponent(input), true);
                xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest"); // Indicate AJAX request
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById("playerGrid").innerHTML = xhr.responseText;
                        updatePagination(input);
                    }
                };
                xhr.send();
            }

            function checkEnter(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    searchPlayer();
                }
            }

           
        </script>

    </body>

    </html>
<?php endif; ?>