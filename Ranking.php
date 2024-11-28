<?php
include 'config.php'; // Include the database connection
include 'header.php';

// Define the tournament points based on PositionWin
$tournamentPoints = [
    "International" => [378, 252, 168, 112, 70, 42, 28, 14],
    "States" => [216, 144, 96, 64, 40, 24, 16, 8],
    "Districts" => [54, 36, 24, 16, 10, 6, 4, 2]
];

// Function to get points based on numeric PositionWin
function getTournamentPoints($TournamentType, $PositionWin, $tournamentPoints)
{
    if (!isset($tournamentPoints[$TournamentType])) {
        return 0; // Invalid tournament type
    }

    $PositionWin = (int) $PositionWin; // Convert PositionWin to integer
    switch ($PositionWin) {
        case 1:
            return $tournamentPoints[$TournamentType][0]; // 1st place
        case 2:
            return $tournamentPoints[$TournamentType][1]; // 2nd place
        case 3:
        case 4:
            return $tournamentPoints[$TournamentType][2]; // 3rd-4th place
        case 5:
        case 6:
        case 7:
        case 8:
            return $tournamentPoints[$TournamentType][3]; // 5th-8th place
        case 9:
        case 10:
        case 11:
        case 12:
        case 13:
        case 14:
        case 15:
        case 16:
            return $tournamentPoints[$TournamentType][4]; // 9th-16th place
        case 17:
        case 18:
        case 19:
        case 20:
        case 21:
        case 22:
        case 23:
        case 24:
        case 25:
        case 26:
        case 27:
        case 28:
        case 29:
        case 30:
        case 31:
        case 32:
            return $tournamentPoints[$TournamentType][5]; // 17th-32nd place
        case 33:
        case 34:
        case 35:
        case 36:
        case 37:
        case 38:
        case 39:
        case 40:
        case 41:
        case 42:
        case 43:
        case 44:
        case 45:
        case 46:
        case 47:
        case 48:
        case 49:
        case 50:
        case 51:
        case 52:
        case 53:
        case 54:
        case 55:
        case 56:
        case 57:
        case 58:
        case 59:
        case 60:
        case 61:
        case 62:
        case 63:
        case 64:
            return $tournamentPoints[$TournamentType][6]; // 33rd-64th place
        case 65:
        case 66:
        case 67:
        case 68:
        case 69:
        case 70:
        case 71:
        case 72:
        case 73:
        case 74:
        case 75:
        case 76:
        case 77:
        case 78:
        case 79:
        case 80:
        case 81:
        case 82:
        case 83:
        case 84:
        case 85:
        case 86:
        case 87:
        case 88:
        case 89:
        case 90:
        case 91:
        case 92:
        case 93:
        case 94:
        case 95:
        case 96:
        case 97:
        case 98:
        case 99:
        case 100:
        case 101:
        case 102:
        case 103:
        case 104:
        case 105:
        case 106:
        case 107:
        case 108:
        case 109:
        case 110:
        case 111:
        case 112:
        case 113:
        case 114:
        case 115:
        case 116:
        case 117:
        case 118:
        case 119:
        case 120:
        case 121:
        case 122:
        case 123:
        case 124:
        case 125:
        case 126:
        case 127:
        case 128:
            return $tournamentPoints[$TournamentType][7]; // 65th-128th place
        default:
            return 0;
    }
}

// Retrieve the current image and rating points from the database
$imageQuery = "SELECT ImagePlayer, RatingPoint FROM player WHERE IdPlayer = ?";
if ($stmt = mysqli_prepare($connect, $imageQuery)) {
    mysqli_stmt_bind_param($stmt, "i", $IdPlayer);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $existingImage, $existingRatingPoint);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// Fetch players from the database
$sql = "SELECT IdPlayer, Name, NickName, Age, DominantHand, Playstyle, Blade, RubberForeHand, RubberBackHand, Grip, ImagePlayer, CareerType, RatingPoint, PositionWin, TournamentType FROM player";
$result = $connect->query($sql); // Execute the query
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSTTC - Ranking</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome for icons (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="header&footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: linear-gradient(to right, black 5%, #d1b000);
        }

        /* Button Styling */
        .btn-custom {
            background-color: gold;
            color: black;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-left: auto;
            margin-right: 130px;
            width: 200px;
        }

        .btn-custom:hover {
            background-color: #202020;
            color: #d1b000;
            transform: scale(1.1);
        }


        .table-container {
            background-size: cover;
            background-position: center;
            color: blue;
            text-align: center;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px;
        }

        .table-container table {
            margin: auto;
            border-collapse: collapse;
            width: 80%;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #ddd;
        }

        th {
            background-color: #202020;
            font-weight: bold;
            color: gold;
        }

        tr:hover {
            background-color: gold;
            /* Gold background on hover */
            color: black;
            /* Text color black on hover */
        }

        /* Link styling and hover effects */
        td a {
            text-decoration: none;
            font-weight: bold;
            color: whitesmoke;
            display: inline-block;
            position: relative;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        td a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 2px;
            background-color: black;
            transition: width 0.3s ease;
        }

        td a:hover::after {
            width: 100%;
            /* Underline animation from left to right */
        }

        td a:hover {
            color: black;
            /* Change color on hover */
            text-decoration: none;
            transform: scale(1.1);
            /* Scale up the text */
        }

        .ratingPoints {
            color: white;
            font-weight: bold;
        }
        
               /* Medium screens (tablets) */
@media (max-width: 768px) {
    .btn-custom {
        width: 50%;
        margin: auto;
    }
}

/* Small screens (phones) */
@media (max-width: 576px) {
    .btn-custom {
        width: 50%;
        margin: auto;
    }
}

/* Extra large screens (27 inches and above) */
@media (min-width: 2560px) {
    .btn-custom {
        width: 250px;
        margin-right: 180px;
        font-size: 1.1rem; /* Slightly larger text */
        padding: 12px 20px; /* Increase padding for more prominent button */
    }
}
    </style>

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom ">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="MsttcLogo-1.png" alt="Club Logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">News & Update</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="Ranking.php">Ranking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Player.php">Player</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="Tournament.php">Tournament</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="AboutUs.php">About Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">
        <h1 class="text-center py-3" style="color: white;">LATEST RANKING</h1>

       <!-- Button Container -->
        <div class="d-flex justify-content-end mb-3">
            <button onclick="window.open('https://worldtabletennis.com/rankings', '_blank')" class="btn btn-custom">Visit WTT Ranking</button>
        </div>



        <!-- Table Container -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>RANK</th>
                        <th>NAME</th>
                        <th>POINTS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Step 1: Fetch the players and order them by RatingPoint in descending order
                    $sql = "SELECT IdPlayer, Name, RatingPoint, PositionWin, TournamentType FROM player ORDER BY RatingPoint DESC";
                    $result = $connect->query($sql); // Execute the query

                    if ($result->num_rows > 0) {
                        $rank = 1; // Initialize rank counter
                        while ($row = $result->fetch_assoc()) {
                            // Ensure CareerType and PositionWin are set
                            $positionWin = $row['PositionWin'] ?? 0;
                            $TournamentType = $row['TournamentType'] ?? 'Unknown'; // Provide a fallback value

                            // Calculate new tournament points
                            $newTournamentPoints = getTournamentPoints($TournamentType, $positionWin, $tournamentPoints);

                            // Fetch the existing rating points from the current row
                            $newTournamentPoints = $row['RatingPoint'];

                            // Calculate the new total rating points
                            $totalRatingPoint = $existingRatingPoint + $newTournamentPoints;

                            // Display the rank, player name, and the total points
                            echo "<tr>
            <td class='rank'>{$rank}</td>
            <td><a href='PlayerProfileMenSingle.php?id=" . $row["IdPlayer"] . "'><strong>{$row['Name']}</strong></a></td>
            <td class='ratingPoints'>{$totalRatingPoint}</td>
            </tr>";
                            $rank++;
                        }
                    } else {
                        echo "<tr><td colspan='3'>No players found</td></tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    

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
                    style=""
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

</body>

</html>