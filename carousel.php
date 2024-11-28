<?php
include 'config.php'; // Include the database connection

$limit = 3; // Number of videos per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query to fetch the total number of videos
$totalQuery = "SELECT COUNT(*) FROM about_us";
$totalResult = $connect->query($totalQuery); // Use $connect here
$totalRows = $totalResult->fetch_row()[0];
$totalPages = ceil($totalRows / $limit);

// Query to fetch video data with pagination
$query = "SELECT youtubeTitle, youtubeLink FROM about_us LIMIT $limit OFFSET $offset";
$result = $connect->query($query); // Use $connect here

// Function to extract YouTube video ID
function getYoutubeID($youtubeLink)
{
    // Handle both standard and shortened YouTube URLs
    preg_match("/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/", $youtubeLink, $matches);
    return isset($matches[1]) ? $matches[1] : '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Carousel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-item img {
            max-width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: black;
        }

        .pagination .page-item.active .page-link {
            background-color: gold;
            /* Background color for active page */
            color: black;
            /* Text color for active page */
            border-color: gold;
            /* Border color to match background */
        }

        .pagination .page-link {
            background-color: gold;
            /* Default background color */
            color: black;
            /* Text color for other pages */
            border-color: gold;
            /* Border color for all pages */
            font-weight: bold;
        }

        .pagination .page-item.disabled .page-link {
            background-color: #f8f9fa;
            /* Background color for disabled state */
            color: #6c757d;
            /* Grey text color for disabled state */
        }

        .pagination .page-item .page-link:hover {
            background-color: black;
            /* Background color on hover */
            color: gold;
            /* Text color on hover */
        }
    </style>
</head>

<body>
     <!-- Carousel -->
     <div id="videoCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            if ($result->num_rows > 0) {
                $i = 0; // Counter to keep track of slides
                while ($row = $result->fetch_assoc()) {
                    $youtubeID = getYoutubeID($row['youtubeLink']);
                    if ($youtubeID) { // Only display if valid YouTube ID found
                        if ($i % $limit === 0) { // Start a new slide every 3 videos
                            if ($i > 0) {
                                echo '</div>'; // Close the previous row
                                echo '</div>'; // Close the previous slide
                            }
                            echo '<div class="carousel-item ' . ($i === 0 ? 'active' : '') . '">';
                            echo '<div class="d-flex justify-content-center gap-3">'; // Start a new row
                        }
            ?>
                        <div class="card value-item">
                            <a href="https://www.youtube.com/watch?v=<?php echo $youtubeID; ?>" target="_blank">
                                <img src="https://img.youtube.com/vi/<?php echo $youtubeID; ?>/hqdefault.jpg" width="100%" height="215" alt="<?php echo $row['youtubeTitle']; ?>">
                            </a>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $row['youtubeTitle']; ?></h4>
                            </div>
                        </div>
            <?php
                        $i++;
                    }
                }
                echo '</div>'; // Close the last row
                echo '</div>'; // Close the last slide
            } else {
                echo "<p class='text-white'>No videos found.</p>";
            }
            ?>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#videoCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#videoCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <script>
        let currentPage = 1;
        const totalPages = 2; // Update this as you add more video pages

        function showPage(page) {
            // Hide all pages
            for (let i = 1; i <= totalPages; i++) {
                document.getElementById(`videoPage${i}`).style.display = 'none';
            }

            // Show selected page
            if (page === 'prev' && currentPage > 1) {
                currentPage--;
            } else if (page === 'next' && currentPage < totalPages) {
                currentPage++;
            } else if (typeof page === 'number') {
                currentPage = page;
            }

            document.getElementById(`videoPage${currentPage}`).style.display = 'flex';

            // Update pagination state (active class and disabled for prev/next)
            document.querySelectorAll('.pagination .page-item').forEach(el => el.classList.remove('active'));
            document.querySelector(`.pagination .page-item:nth-child(${currentPage + 1})`).classList.add('active');

            document.getElementById('prevPage').parentNode.classList.toggle('disabled', currentPage === 1);
            document.getElementById('nextPage').parentNode.classList.toggle('disabled', currentPage === totalPages);
        }

        // Show the first page initially
        showPage(1);

        document.addEventListener('DOMContentLoaded', function() {
            var myCarousel = document.querySelector('#videoCarousel');
            var carousel = new bootstrap.Carousel(myCarousel, {
                interval: false, // Set to false to avoid automatic sliding
                ride: 'carousel'
            });
        });
    </script>

    <!-- Bootstrap JS and Initialization -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script></body>

</html>
