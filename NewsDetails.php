<?php
include 'config.php'; // Include the database connection
include 'header.php';


// Check if an IdNews is provided in the URL, and sanitize the input
$newsId = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default to IdNews 1 if no id is passed

// SQL query to fetch the specific news article based on IdNews
$sql = "SELECT * FROM news WHERE IdNews = $newsId";
$result = $connect->query($sql); // Execute the query

if ($result->num_rows > 0) {
    $news = $result->fetch_assoc(); // Fetch news data
} else {
    echo "No news found.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MSTTC - News Details</title>
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <!-- FontAwesome for icons (optional) -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <link rel="stylesheet" href="header&footer.css">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      
     background: linear-gradient(to right, black 30%, #d1b000);

    }

    .news-container {
      max-width: 800px;
      margin: 50px auto;
      background: transparent;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.5);
      color: whitesmoke;
    }

    .news-image {
      width: 100%;
      max-width: 850px;
      height: 100%;
      max-height: 400px;
      border-radius: 15px;
      margin: 0 auto 20px auto;
      display: block;
    }

    .news-title {
      font-size: 28px;
      font-weight: bold;
      color: #FF7F50;
    }

    .news-date {
      font-size: 16px;
      color: silver;
      text-align: right;
    }

    hr {
      height: 3px;
      background-color: black;
      border: none;
      margin: 20px 0;
    }

    .news-description {
      line-height: 1.6;
      color: whitesmoke;
      height: auto;
    
    }

    .news-button {
      background-color: #d6b400;
      color: black;
      border: none;
      padding: 10px 20px;
      font-size: 18px;
      border-radius: 5px;
      cursor: pointer;
      
    }

    .news-button:hover {
      background-color: #c6a000;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-custom">
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
            <a class="nav-link active" href="index.php">News & Update</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Ranking.php">Ranking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Player.php">Player</a>
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

  <!-- News Content -->
  <div class="news-container">

    <?php if (!empty($news['NewsPicture'])): ?>
      <img src="uploads/<?php echo htmlspecialchars($news['NewsPicture']); ?>" alt="<?php echo htmlspecialchars($news['NewsTitle']); ?>" class="news-image">
    <?php endif; ?>

    <h1 class="news-title"><?php echo htmlspecialchars($news['NewsTitle']); ?></h1>

    <p class="news-date"><?php echo date('F d, Y', strtotime($news['NewsDate'])); ?></p>

    <p class="news-description"><?php echo nl2br(htmlspecialchars($news['NewsDescription'])); ?></p>

    <button class="news-button" onclick="window.open('<?php echo htmlspecialchars($news['NewsLink']); ?>', '_blank');">More Info</button>

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
