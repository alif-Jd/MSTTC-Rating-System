<?php
include 'auth.php'; 
include "config.php";

$news = null;
$searchError = "";

// Check if the search form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchValue = trim($_POST['searchValue']);

    $searchQuery = "SELECT * FROM news WHERE IdNews = ? OR NewsTitle = ?";

    if ($stmt = mysqli_prepare($connect, $searchQuery)) {
        mysqli_stmt_bind_param($stmt, "ss", $searchValue, $searchValue);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $news = $row;
        } else {
            $searchError = "News not found.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSTTC - Delete News</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome for icons (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <link rel="stylesheet" href="header&footerAdmin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: linear-gradient(to right, black, gold);
            font-family: Arial, sans-serif;
            color: white;
        }

        h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            margin-top: 20px;
        }

        h3 {
            text-align: center;
        }

        .card {
            background-color: #1a1c35;
            padding: 20px;
            border-radius: 20px;
            margin: 20px auto;
            max-width: 800px;
            width: 100%;
        }

        .form-group label {
            color: white;
        }

        .form-control {
            border: none;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .btnSearch {
            background-color: #0097b2;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 20px;
            transition: transform 0.3s ease, background-color 0.3s ease;
            width: 100%;
            max-width: 200px;
        }

        .btnSearch:hover {
            background-color: darkcyan;
            transform: scale(1.05);
        }

        .btnDelete {
            background-color: red;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 20px;
            transition: transform 0.3s ease, background-color 0.3s ease;
            width: 100%;
            max-width: 200px;
        }

        .btnDelete:hover {
            background-color: darkred;
            transform: scale(1.05);
        }

        table {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid silver;
            padding: 10px;
        }

        .labeltable {
            color: darkgrey;
        }

        .tdData {
            color: white;
        }

        .td-lbl {
            color: darkgrey;
        }

        .imgNews {
            display: block;
            margin: 0 auto 20px auto;
            /* Centers the image horizontally and adds bottom margin */
            max-width: 100%;
            max-height: 200px;
            /* Limit the height to 400px */
            width: auto;
            /* Maintain aspect ratio */
            border-radius: 10px;
            border: 1px solid white;
            /* Add a border with your preferred color */
        }

        /* Base style for the alert */
        #alertMessage {
            max-width: 80%;
            margin: 20px auto;
            text-align: center;
            transition: opacity 1s ease;
            /* Smooth fade-out transition */
            opacity: 1;
            /* Fully visible initially */
        }

        #alertMessage.hidden {
            opacity: 0;
            /* Hidden state */
        }

        @media (max-width: 767px) {

            .form-control,
            .btnSearch,
            .btnDelete {
                width: 100%;
                max-width: none;
            }
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

    <div class="container">
        <div class="card">
            <h1>DELETE NEWS</h1>

            <form method="post" id="searchForm" action="DeleteNews.php">
                <div class="mb-3 row">
                    <label for="searchValue" class="col-sm-2 col-form-label text-start">Search News</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="searchValue" id="searchValue" placeholder="Enter News ID" value="<?php echo isset($searchValue) ? htmlspecialchars($searchValue) : ''; ?>" required>
                    </div>
                    <div class="col-sm-10 offset-sm-2">
                        <?php if (!empty($searchError)): ?>
                            <p style="color: red;"><?php echo $searchError; ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" name="search" class="btnSearch">SEARCH</button>
                </div>

                <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                <strong>Success!</strong> News deleted successfully!
            </div>
            
            </form>

            <hr>

            <?php if ($news): ?>
                <div>
                    <h3>News Details</h3>
                    <img src="uploads/<?php echo htmlspecialchars($news['NewsPicture']); ?>" alt="News Image" class="imgNews">
                    <form id="deleteNewsForm" action="inputDeleteNews.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="IdNews" value="<?php echo $news['IdNews']; ?>">
                        <table class="table">
                            <tr>
                                <th class="labeltable">ID.No</th>
                                <td class="tdData"><?php echo htmlspecialchars($news['IdNews']); ?></td>
                            </tr>
                            <tr>
                                <th class="labeltable">News Title</th>
                                <td class="tdData"><?php echo htmlspecialchars($news['NewsTitle']); ?></td>
                            </tr>
                            <tr>
                                <th class="labeltable">Short Description</th>
                                <td class="tdData"><?php echo htmlspecialchars($news['ShortDescription']); ?></td>
                            </tr>
                            <tr>
                                <th class="labeltable">News Date</th>
                                <td class="tdData"><?php echo htmlspecialchars($news['NewsDate']); ?></td>
                            </tr>
                        </table>

                        <div class="text-center">
                            <button type="button" class="btnDelete" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">DELETE</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:#1a1c35;">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel" style="color: silver;font-weight:bold">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: white;">
                    Are you sure you want to delete this news?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Yes, Delete</button>
                </div>
            </div>
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
        // When the "Yes, Delete" button in the modal is clicked, submit the form
        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            document.getElementById('deleteNewsForm').submit();
        });

        // Show the success alert and fade it out
        window.onload = function() {
            if (window.location.search.includes('status=success')) {
                const alertMessage = document.getElementById('alertMessage');
                alertMessage.style.display = 'block'; // Display the success message

                // Fade-out animation after 2 seconds
                setTimeout(() => {
                    alertMessage.classList.add('hidden'); // Start fade-out
                    setTimeout(() => {
                        alertMessage.style.display = 'none'; // Fully hide after fade-out
                    }, 2000); // Wait for the fade-out to complete (2 seconds)
                }, 2000); // Keep the message visible for 2 seconds before fading out
            }
        };
    </script>

</body>

</html>