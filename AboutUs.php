<?php
include 'config.php'; // Include the database connection
include 'header.php';

$limit = 6; // Number of videos per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query to fetch the total number of videos
$totalQuery = "SELECT COUNT(*) FROM aboutus";
$totalResult = $connect->query($totalQuery);
$totalRows = $totalResult->fetch_row()[0];
$totalPages = ceil($totalRows / $limit);

// Query to fetch video data with pagination
$query = "SELECT YoutubeTitle, YoutubeLink FROM aboutus LIMIT $limit OFFSET $offset";
$result = $connect->query($query);

// Function to extract YouTube video ID
function getYoutubeID($youtubeLink)
{
    preg_match("/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/", $youtubeLink, $matches);
    return isset($matches[1]) ? $matches[1] : '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSTTC - About Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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

        h1,
        h2,
        h3 {
            color: #ff7f50;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-section {
            text-align: center;
            background-color: #ffcc00;
            padding: 80px 20px;
            margin-bottom: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5); /* Drop shadow */
        }

        .hero-section h1 {
            font-size: 3rem;
            color: #222;
            margin-bottom: 10px;
        }

        .hero-sectionimage {
            width: 350px;
            /* Set the desired width */
            height: 110px;
            /* Maintain aspect ratio */
            margin-bottom: 10px;

        }

        .hero-section p {
            font-size: 1.2rem;
            color: #555;
            text-align: center;
        }

        .hero-h {
            color: #ff7f50;
            /* Applies the coral color to the text */
            font-size: 1.2rem;
            /* Optional: Adjusts the font size for better readability */

        }



        .mission-section {
            background-color: #fff;
            padding: 60px 20px;
            margin-bottom: 40px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .mission-section h2 {
            font-size: 2rem;
            color: #222;
            margin-bottom: 20px;
        }

        .mission-section p {
            font-size: 1.1rem;
            color: #444;
        }

        .values-section {
            background-color: white;           
            padding: 60px 20px;
            margin-bottom: 40px;
            border-radius: 10px;
            margin-top: 30px;
            border:silver solid 1px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5); /* Drop shadow */
        }

        .values-section h2 {
            font-size: 2.2rem;
            text-align: center;
            color: black;
            margin-bottom: 30px;
        }

        .values-grid {
            display: flex;
            justify-content: center;
        }

        .value-item {
            background-color: silver;
            padding: 40px 20px;
            border-radius: 10px;
            border: gold solid 0.5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            width: 30%;
            color: black;
            margin: 0px 5px 0px 5px;
            
        }

        .value-item h4 {
            font-size: 0.9rem;
            /* Adjust this value to make it smaller */
            font-weight: bold;
        }

        .value-item p {
            font-size: 1rem;
            color: black;
        }

        .value-item:hover {
            transform: translateY(-10px);
            background-color: #202020;
            color: gold;
        }

        .value-item p:hover {
            color: #e6e6e6;
        }



        /***** Team *****/
        .team-section {
            text-align: center;
            background-color: #fff;
            padding: 60px 20px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .team-section h2 {
            font-size: 2rem;
            color: #222;
            margin-bottom: 20px;
        }

        .team-section p {
            font-size: 1.1rem;
            color: #444;
        }

        .join-section {
            background-color: #ffcc00;
            padding: 80px 20px;
            text-align: center;
            border-radius: 10px;
        }

        .join-section h2 {
            font-size: 2.2rem;
            color: #222;
            margin-bottom: 20px;
        }

        .join-section p {
            font-size: 1.1rem;
            color: #444;
            margin-bottom: 30px;
        }

        .join-btn {
            background-color: #222;
            color: #fff;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 30px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .join-btn:hover {
            background-color: #444;
            transform: scale(1.1);
        }

        .video-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
            font-weight: bold;
            color: black;
            text-align: center;
            background: silver;
            
        }

        .video-card img {
            width: 100%;
            height: auto;
            cursor: pointer;
        }

        .video-card:hover {
            transform: translateY(-10px);
            color:gold;
            background: linear-gradient(to right , #202020 , #202020);
        }

        .video-title {
            padding: 10px;
            font-weight: bold;
            color: black;
            text-align: center;
        }

        .pagination {
            justify-content: center;

        }

        .pagination .page-item .page-link {
            color: #d1b000;
            /* Default color */
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
        }

        .pagination .page-item .page-link:hover {
            background-color: #d1b000;
            /* Hover background color */
            color: #202020;
            /* Hover text color */
        }
        
        @media screen and (max-width: 480px) {
            
                .value-item h4 {
                    font-size: 0.65rem;
                }
                
                .value-item p {
                    font-size: 0.7rem;
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
                        <a class="nav-link " href="Ranking.php">Ranking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Player.php">Player</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="Tournament.php">Tournament</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="AboutUs.php">About Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="about-container">
        <br>
        <section class="hero-section">
            <h1>Welcome to MSTTC!</h1>
            <br>
            <p>
                The Muadzam Shah Table Tennis Club (MSTTC) is a vibrant community focused on
                <strong>fostering a love for table tennis</strong> and <strong>empowering players</strong> at every level. We provide an inclusive platform where enthusiasts can
                <strong>train, compete,</strong> and <strong>enhance their skills</strong> in a welcoming environment.
            </p>
           
         </section>




        <section class="values-section">
            <h2>Our Values</h2>
            <div class="values-grid">
                <div class="value-item">
                    <h4>Sportsmanship</h4>
                    <p>Integrity and respect are the foundation of our club. We believe in fair play and building strong relationships through the love of the game.</p>
                </div>
                <div class="value-item">
                    <h4>Inclusivity</h4>
                    <p>We open our doors to everyone, ensuring that all players, regardless of background or experience, feel welcome.</p>
                </div>
                <div class="value-item">
                    <h4>Development</h4>
                    <p>Growth is at the heart of our club. We’re committed to helping every player and coach improve, from beginners to seasoned professionals.</p>
                </div>
            </div>
        </section>
        
       
            
                <h2 class="text-center mb-4" style="color: white;">Check Out Some Video!</h2>
                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner">
                        <?php
                        $active = true;
                        $index = 0;
                        while ($row = $result->fetch_assoc()) {
                            if ($index % 6 === 0) {
                                echo '<div class="carousel-item' . ($active ? ' active' : '') . '"><div class="row">';
                                $active = false;
                            }
                            $youtubeID = getYoutubeID($row['YoutubeLink']);
                            $title = $row['YoutubeTitle'];
                            $link = $row['YoutubeLink'];
                        ?>
                            <div class="col-md-4 mb-4">
                                <div class="video-card">
                                    <a href="<?php echo $link; ?>" target="_blank">
                                        <img src="https://img.youtube.com/vi/<?php echo $youtubeID; ?>/0.jpg" alt="Video Thumbnail">
                                    </a>
                                    <div style="padding:10px;"><?php echo htmlspecialchars($title); ?></div>
                                </div>
                            </div>
                        <?php
                            $index++;
                            if ($index % 6 === 0) {
                                echo '</div></div>'; // Close row and carousel-item
                            }
                        }
                        if ($index % 6 !== 0) {
                            echo '</div></div>'; // Close last row and carousel-item if not closed
                        }
                        ?>
                    </div>
    
    
                    <!-- Pagination Controls -->
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item<?php if ($i == $page) echo ' active'; ?>">
                                    <a class="page-link pagination-link" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
            
       


            <section class="values-section" style="text-align: center; margin: 40px 0;">
                <h2>Our Club Location</h2>
                <div style="max-width: 900px; margin: 0 auto;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15951.053985349418!2d103.0671794!3d3.0625575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cf097c511ab6ff%3A0x19299b117a82d0ba!2sJalan%20menuju%20Dewan%20Besar%20DARA!5e0!3m2!1sen!2smy!4v1698720180123!5m2!1sen!2smy"
                        width="100%"
                        height="400"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>

                <a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15951.053985349418!2d103.0671794!3d3.0625575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cf097c511ab6ff%3A0x19299b117a82d0ba!2sJalan%20menuju%20Dewan%20Besar%20DARA!5e0!3m2!1sen!2smy!4v1698720180123!5m2!1sen!2smy"
                    target="_blank"
                    class="btn btn-primary mt-3"
                    style="padding: 10px 20px; font-size: 1.2rem; text-decoration: none; border-radius: 5px; margin-top: 30px;">
                    View on Google Maps
                </a>
            </section>






            <section class="join-section">
                <div class="join-content">
                    <h2>Join Us</h2>
                    <p>Ready to start your table tennis journey? Join Us Now!.</p>
                    <a href="https://wa.me/60129612701" class="join-btn" target="_blank">Contact Us</a>
                </div>
            </section>
        </div>

        <br>


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
        document.addEventListener("DOMContentLoaded", function() {
            const paginationLinks = document.querySelectorAll(".pagination-link");

            paginationLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    const page = this.getAttribute("data-page");

                    fetch(`AboutUs.php?page=${page}`)
                        .then(response => response.text())
                        .then(data => {
                            // Update the video carousel or relevant section without reloading
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(data, "text/html");

                            const newCarousel = doc.querySelector(".carousel-inner");
                            document.querySelector(".carousel-inner").innerHTML = newCarousel.innerHTML;

                            // Update pagination active class
                            document.querySelectorAll(".page-item").forEach(item => item.classList.remove("active"));
                            this.parentElement.classList.add("active");
                        })
                        .catch(error => console.error("Error loading page:", error));
                });
            });
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>