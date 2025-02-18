<?php
include 'config.php'; // Include the database connection

$sql = "SELECT * FROM news ORDER BY NewsDate DESC"; // Your SQL query
$result = $connect->query($sql); // Execute the query
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSTTC - Muadzam Shah Table Tennis Club</title>
    <meta name="description" content="Show your skill as a great player with Muadzam Shah Table Tennis Club (MSTTC).">

    <!-- JSON-LD structured data -->
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "SportsOrganization",
      "name": "Muadzam Shah Table Tennis Club (MSTTC)",
      "url": "https://www.msttcrs.com",
      "description": "Stay updated with the latest news, player rankings, and tournaments at Muadzam Shah Table Tennis Club (MSTTC)."
    }
    </script>
    
        <!-- Google tag (gtag.js) Jd-->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZT5VLQ1KQ8"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-ZT5VLQ1KQ8');
    </script>

    <!-- Favicon Links -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    
    <!-- Google tag (gtag.js) msttcrs-->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-5X68MZGSS0"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-5X68MZGSS0');
</script>
    
    
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

        h1{
            text-align: center; 
            padding: 20px;
            color: white;
        }
        .card {
            background-color:silver;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            transition: transform 0.3s ease, color 0.3s ease;
            /* Smooth transition for scaling and color */
            cursor: pointer;
            overflow: hidden;
            text-decoration: none;
            max-width: 1000px;
            text-decoration:none; color:inherit;
            max-height:420px;
        }

        .card:hover {
            transform: scale(1.1);
            /* Scale card slightly on hover */
            background-color: #202020;
            color: gold;
            /* Change the color of the entire card text */
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            transition: transform 0.3s ease;
            /* Smooth scaling for image */
            margin-bottom: 10px;
        }

        .card:hover img {
            transform: scale(1.1);
            /* Scale image on hover */
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #202020;
            transition: color 0.3s ease;
            /* Smooth transition for color */
        }

        .card-info {
            font-size: 14px;
            color: black;
            margin-bottom: 10px;
            transition: color 0.3s ease;
            /* Smooth transition for color */
        }

        .card:hover .card-title,
        .card:hover .card-info {
            color: gold;
            /* Change title and info color on hover */
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="margin-left: auto; margin-bottom: 10px;">
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
                    <a class="nav-link " href="Player.php">Player</a>
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


    <h1>LATEST NEWS</h1>

    <div class="container">
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                // Fetch each row of the result set
                while ($row = $result->fetch_assoc()) {
                    $NewsPicture = !empty($row['NewsPicture']) ? 'uploads/' . $row['NewsPicture'] : 'default.jpg'; // Fallback image

                    echo '<div class="col-md-4 mb-4">'; // Margin bottom for spacing
                    echo '  <a href="NewsDetails.php?id=' . $row['IdNews'] . '" class="card" style="">'; // Anchor around card container

                    echo '      <img src="' . htmlspecialchars($NewsPicture) . '" alt="' . htmlspecialchars($row['NewsTitle']) . '" style="width:100%; height:300px; object-fit:cover;">';
                    echo '      <div class="card-body">'; // Card body
                    echo '        <h2 class="card-title">' . htmlspecialchars($row['NewsTitle']) . '</h2>';
                    echo '        <div class="card-info">' . htmlspecialchars($row['ShortDescription']) . '</div>';
                    echo '      </div>'; // Close card-body

                    echo '  </a>'; // Close anchor
                    echo '</div>'; // Close column
                }
            } else {
                // Display a message if no news is available
                echo '<div class="col-12">';
                echo '  <p style="color: white; text-align: center;">No news available at this moment.</p>';
                echo '</div>';
            }
            ?>
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



    <script>
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelectorAll('.nav-link.active').forEach(el => el.classList.remove('active'));
                link.classList.add('active');
            });
        });
    </script>

    <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>