<?php
include 'auth.php';
include "config.php"; // Include your database configuration

// Initialize variables
$aboutus = null;
$searchValue = '';
$searchError = '';

// Check if the search form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchValue = $_POST['searchValue'];

    // Search for the YouTube link in the database
    $searchQuery = "SELECT * FROM aboutus WHERE IdYoutube = ? OR YoutubeTitle LIKE ?";
    if ($stmt = mysqli_prepare($connect, $searchQuery)) {
        // Prepare the LIKE parameter
        $likeValue = '%' . $searchValue . '%';

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ss", $searchValue, $likeValue);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Store the fetched data in $aboutus
            $aboutus = $row; // Changed from $news to $aboutus
        } else {
            $searchError = "YouTube link not found.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $searchError = "Database query failed.";
    }
}

// Check if the delete form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idToDelete'])) {
    $IdYoutube = $_POST['idToDelete'];

    // Check if IdYoutube is valid
    if (!empty($IdYoutube)) {
        // Prepare the delete query based on IdYoutube
        $deleteQuery = "DELETE FROM aboutus WHERE IdYoutube = ?";
        if ($stmt = mysqli_prepare($connect, $deleteQuery)) {
            // Bind the IdYoutube parameter
            mysqli_stmt_bind_param($stmt, "s", $IdYoutube); // Use "s" for string, change to "i" if it's an integer
            if (mysqli_stmt_execute($stmt)) {
                // Check if any row was affected (deleted)
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    // Redirect to the same page with a success status
                    header("Location: DeleteAboutUs.php?status=success");
                    exit();
                } else {
                    echo "Error: No record found with the given ID.";
                }
            } else {
                echo "Error deleting record: " . mysqli_error($connect);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($connect);
        }
    } else {
        echo "Invalid request. Please provide a valid ID.";
    }
}

mysqli_close($connect); // Close the database connection
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSTTC - Delete Youtube Links</title>
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

        .container {
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .card {
            background-color: #1a1c35;
            padding: 20px;
            border-radius: 15px;
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
        }

        .btnSearch,
        .btnDelete {
            border-radius: 20px;
            padding: 10px;
            width: 100%;
            max-width: 150px;
        }

        .btnSearch {
            background-color: #0097b2;
            color: white;
        }

        .btnSearch:hover {
            background-color: darkcyan;
        }

        .btnDelete {
            background-color: red;
            color: white;
            margin-top: 10px;
        }

        .btnDelete:hover {
            background-color: darkred;
        }

        .table {
            color: white;
        }

        #alertMessage {
            max-width: 80%;
            margin: 20px auto;
            text-align: center;
            display: none;
        }

        .hidden {
            opacity: 0;
        }

        .lbl-td {
            color: darkgray;
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
            <h1>DELETE YOUTUBE LINK</h1>

            <form id="searchForm" action="DeleteAboutUs.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label for="searchValue" class="col-sm-2 col-form-label">Search Youtube Link</label>
                    <div class="col-sm-10">
                        <input type="text" name="searchValue" id="searchValue" class="form-control" placeholder="Enter Video ID" value="<?php echo isset($searchValue) ? htmlspecialchars($searchValue) : ''; ?>" required>
                        <?php if (!empty($searchError)): ?>
                            <p style="color: red;"><?php echo $searchError; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="search" class="btnSearch">SEARCH</button>
                </div>

                <!-- Alert for Success Message -->
                <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong> Youtube Link deleted successfully!
                </div>
            </form>

            <hr>

            <?php if ($aboutus): ?>
                <div class="table-responsive">
                    <h3>Youtube Links Details</h3>
                    <form id="deleteAboutUsForm" action="DeleteAboutUs.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="idToDelete" value="<?php echo htmlspecialchars($aboutus['IdYoutube']); ?>">
                        <table class="table table-bordered">
                            <tr>
                                <td class="lbl-td"><strong>Id Youtube</strong></td>
                                <td><?php echo htmlspecialchars($aboutus['IdYoutube']); ?></td>
                            </tr>
                            <tr>
                                <td class="lbl-td"><strong>Video Title</strong></td>
                                <td><?php echo htmlspecialchars($aboutus['YoutubeTitle']); ?></td>
                            </tr>
                            <tr>
                                <td class="lbl-td"><strong>Video Link</strong></td>
                                <td><?php echo htmlspecialchars($aboutus['YoutubeLink']); ?></td>
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
                    Are you sure you want to delete this Youtube Link?
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
        // When the "Yes, Delete" button in the modal is clicked, submit the delete form
        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            document.getElementById('deleteAboutUsForm').submit();
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