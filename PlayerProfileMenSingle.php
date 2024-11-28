<?php
include 'config.php'; // Include the database connection
include 'header.php';


// Check if an IdPlayer is provided in the URL, and sanitize the input
$playerId = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default to IdPlayer 1 if no id is passed

// SQL query to fetch the specific player's information based on IdPlayer
$sql = "SELECT * FROM player WHERE IdPlayer = $playerId";
$result = $connect->query($sql); // Execute the query

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MSTTC - Player Details</title>
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <!-- FontAwesome for icons (optional) -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <link rel="stylesheet" href="header&footer.css">

  <style>
    body {
      background: linear-gradient(to right, black 30%, #d1b000);
    }

    .container-md {
      color: white;
      max-width: 1200px;
      text-align: left;
    }

    .player-info {
      /***** background-color: rgba(0, 0, 0, 0.7); *****/
      /***** End Section *****/
      background: transparent;
      padding: 20px;
      border-radius: 8px;
      width: 100%;
      max-width: 1100px;
      max-width: auto;
      box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.5);
    }

    .player-info h2 {
      color: silver;
      text-align: left;
    }

    .player-info p {
      color: white;
    }

    .info-block {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 10px;
      border-radius: 10px;
      margin-bottom: 0px;
      margin-top: 5px;
      text-align: center;
      color: #d6d6d6;

    }

    .info-block h6 {
      margin-bottom: 5px;
      font-size: 14px;
      font-weight: bold;
      color: #FFD700;
    }

    .rating-points {
      font-size: 24px;
      font-weight: bold;
      color: gold;
      text-align: center;
      margin-bottom: 60px;
      /* This controls the space after points */

    }


    .blade-spec {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 8px;
    }

    .blade-spec h6 {
      font-weight: bold;
      color: #FFD700;
    }

    .blade-spec img {
      max-width: 100px;
      margin-bottom: 10px;
    }

    .player-image {
      max-width: auto;
      width: 450px;
      height: 100%;
      max-height: 700px;
      border-radius: 20px;

    }

    .imgIconBlade {
      max-width: 100px;
      max-height: 100px;
    }

    .imgIconHand {
      max-width: 50px;
      max-height: 100px;
    }

    .btn-custom {
      background-color: #ffc107;
      /* Default warning color */
      color: white;
      text-decoration: none;
    }

    .btn-custom:hover {
      background-color: #202020;
      color: gold;
      transform: scale(1.2);
    }

    .button-container {
      text-align: left;
    }


    @media only screen and (max-width: 1024px) {
      .player-image {
        width: 350px;
      }
    }

    /* For tablets and iPads */
    @media only screen and (max-width: 768px) {
      .player-image {
        width: 300px;
      }
    }

    /* For mobile devices (optional if you want further adjustment) */
    @media only screen and (max-width: 480px) {
      .player-image {
        width: 100%;
      }
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


  <!-- Player Containers -->
  <div class="container-md mt-4">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>

            <div class="player-info">
              <div class="row">
                <div class="col-md-50 text-center">
                  <img src="<?php echo $row['ImagePlayer']; ?>" alt="Player Image" class="player-image">
                </div>
                <div class="col-md-50 text-center">
                  <p class="rating-points">Rating Points: <span style="color:green"><?php echo $row['RatingPoint']; ?></span></p>
                </div>
                <hr>
                <div class="col-1-md-10">
                  <h2><?php echo $row['Name']; ?></h2>

                  <div class="row">
                    <div class="col-md-6 mb-5">
                      <div class="info-block">
                        <h6>Nickname</h6>
                        <p><?php echo $row['NickName']; ?></p>
                      </div>
                    </div>

                    <div class="col-md-6 mb-5">
                      <div class="info-block">
                        <h6>Playstyle</h6>
                        <p><?php echo $row['Playstyle']; ?></p>
                      </div>
                    </div>

                    <div class="col-md-6 mb-5">
                      <div class="info-block">
                        <h6>Age</h6>
                        <p><?php echo $row['Age']; ?></p>
                      </div>
                    </div>

                    <div class="col-md-6 mb-5">
                      <div class="info-block">
                        <h6>Career Type</h6>
                        <p><?php echo $row['CareerType']; ?></p>
                      </div>
                    </div>

                    <div class="col-md-6 mb-5">
                      <div class="info-block">
                        <h6>Dominant Hand</h6>
                        <p><img src="handicon.png" class="imgIconHand"><?php echo $row['DominantHand']; ?></p>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <!-- Blade Specifications -->
              <div class="mt-4">
                <h4 class="text-white"><img src="bladeicon.png" alt="" class="imgIconBlade"> Blade Specs</h4>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <div class="blade-spec text-center">
                      <h6>Blade</h6>
                      <p><?php echo $row['Blade']; ?></p>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="blade-spec text-center">
                      <h6>Rubber Forehand</h6>
                      <p><?php echo $row['RubberForeHand']; ?></p>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="blade-spec text-center">
                      <h6>Rubber Backhand</h6>
                      <p><?php echo $row['RubberBackHand']; ?></p>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="blade-spec text-center">
                      <h6>Grip</h6>
                      <p><?php echo $row['Grip']; ?></p>
                    </div>
                  </div>

                  <!-- Blade Details Button -->
                  <div class="col-md-3 mb-3 button-container">
                    <a href="BladeDetails.php?id=<?php echo $row['IdPlayer']; ?>" class="btn btn-custom">
                      View Blade Image
                    </a>
                  </div>


                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>No player found.</p>
        <?php endif; ?>
      </div>
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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Active Link Script -->
  <script>
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        document.querySelectorAll('.nav-link.active').forEach(el => el.classList.remove('active'));
        link.classList.add('active');
      });
    });
  </script>
</body>

</html>