<?php
include 'auth.php';
include "config.php";

$tournament = null;
$searchError = "";

// Check if the search form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchValue = trim($_POST['searchValue']); // Get the search input

    // Prepare a query to search for the tournament by IdTournament or TournamentTitle
    $searchQuery = "SELECT * FROM tournament WHERE IdTournament = ? OR TournamentTitle = ?";

    if ($stmt = mysqli_prepare($connect, $searchQuery)) {
        mysqli_stmt_bind_param($stmt, "ss", $searchValue, $searchValue); // Use string binding for both fields
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Store the fetched tournament data in $tournament
            $tournament = $row;
        } else {
            $searchError = "Tournament not found.";
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
    <title>MSTTC - Delete Tournament</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="header&footerAdmin.css" />
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

        h3 {
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

        .btnSearch {
            border-radius: 30px;
            width: 100%;
            max-width: 150px;
            padding: 10px;
            background-color: #0097b2;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btnSearch:hover {
            transform: scale(1.05);
            background-color: darkcyan;
        }

        .btnDelete {
            border-radius: 30px;
            width: 100%;
            max-width: 150px;
            padding: 10px;
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .btnDelete:hover {
            transform: scale(1.1);
            background-color: darkred;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .table {
            color: white;
        }

        #alertMessage {
            max-width: 80%;
            margin: 20px auto;
            text-align: center;
            transition: opacity 2s ease-in-out;
            opacity: 1;
        }

        #alertMessage.hidden {
            opacity: 0;
        }

        .imgTour {
            max-width: 80%;
            height: auto;
            border-radius: 10px;
            border: white solid 2px;
            display: block;
            margin: 20px auto;
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
            <h1>DELETE TOURNAMENT</h1>

            <form method="post" id="searchForm" action="DeleteTournament.php">
                <div class="row mb-3">
                    <label for="searchValue" class="col-sm-2 col-form-label">Search Tournament</label>
                    <div class="col-sm-10">
                        <input type="text" name="searchValue" id="searchValue" class="form-control" placeholder="Enter Tournament ID" value="<?php echo isset($searchValue) ? htmlspecialchars($searchValue) : ''; ?>" required>
                        <?php if (!empty($searchError)): ?>
                            <p style="color: red;"><?php echo $searchError; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="search" class="btnSearch">SEARCH</button>
                </div>

               
            </form>

            <hr>

             <!-- Alert for Success Message -->
             <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong> Tournament deleted successfully!
            </div>

            <?php if ($tournament): ?>
                <div class="table-responsive">
                    <h3>Tournament Details</h3>
                    <img src="uploads/<?php echo htmlspecialchars($tournament['TournamentImage']); ?>" alt="Tournament Image" class="imgTour">
                    <table class="table table-bordered">
                        <tr>
                            <td class="lbl-td"><strong>Tournament Title</strong></td>
                            <td><?php echo htmlspecialchars($tournament['TournamentTitle']); ?></td>
                        </tr>
                        <tr>
                            <td class="lbl-td"><strong>Tournament Place</strong></td>
                            <td><?php echo htmlspecialchars($tournament['TournamentPlace']); ?></td>
                        </tr>
                        <tr>
                            <td class="lbl-td"><strong>Tournament Date</strong></td>
                            <td><?php echo htmlspecialchars($tournament['TournamentDate']); ?></td>
                        </tr>
                    </table>

                    <div class="text-center">
                        <button type="button" class="btnDelete" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">DELETE</button>
                    </div>
                </div>

                <!-- Hidden delete form -->
                <form id="deleteTournamentForm" method="post" action="inputDeleteTournament.php" style="display:none;">
                    <input type="hidden" name="IdTournament" value="<?php echo htmlspecialchars($tournament['IdTournament']); ?>">
                </form>
            <?php endif; ?>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color:#1a1c35;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel" style="color: silver;font-weight:bold">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="color: white;">
                            Are you sure you want to delete this tournament?
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
                // Trigger delete form submission on "Yes, Delete" button click
                document.getElementById('confirmDeleteButton').addEventListener('click', function() {
                    document.getElementById('deleteTournamentForm').submit();
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