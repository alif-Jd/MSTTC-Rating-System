<?php include 'auth.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MSTTC - Admin</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- FontAwesome for icons (optional) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <link rel="stylesheet" href="header&footerAdmin.css" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      background: linear-gradient(to right, black, #D6B400);
      font-family: Arial, sans-serif;
      color: white;
    }

    /* Styles for the card and container */
    .container {
      margin-top: 50px;
    }

    /* Expand the card to 90% width on larger screens */
    .card {
      background-color: #1a1c35;
      padding: 30px;
      border-radius: 20px;
      width: 90%;
      margin: auto;
      margin-bottom:20px;
    }

    /* Ensure table takes up full width within the card */
    .table {
      width: 100%;
      margin-top: 20px;
      text-align: center;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      
    }
    
    h2 {
        margin-top:20px;
    }

    /* Info icon positioning */
    .info-icon-link {
      position: absolute;
      right: 10px;
      /* Adjust as needed */
      color: white;
      font-size: 1.3rem;
      transition: color 0.3s ease;
      margin-top: 10px;
      margin-right: 10px;
    }

    /* Hover effect for info icon */
    .info-icon-link:hover {
      color: #FF7F50;
      /* Hover color */
    }

    h3 {
      color: #D6B400;
      margin-bottom: 10px;
    }

    .lblS {
      font-size: 13px;
    }

    .form-select {
      background-color: #1c1c1c;
      color: white;
      border: 2px solid #FFD700;
      border-radius: 5px;
      padding: 10px;
      font-size: 16px;
      max-width: 210px;
      appearance: none;
      margin-right: 10px;
      transition: transform 0.2s ease;
    }

    .form-select:hover {
      background-color: #FFD700;
      color: black;
      transform: scale(1.05);
    }

    .btnShow {
      background-color: #0097b2;
      color: white;
      width: 120px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
    }

    .btnShow:hover {
      transform: scale(1.1);
      background-color: darkcyan;
      color: black;
    }

    .custom-btn {
      background-color: #009E60;
        color: white;
        border: none;
        margin-bottom:30px;
    }
    .custom-btn:hover {
      background-color: darkgreen;
        color: white;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      h1 {
        font-size: 2rem;
      }

      /* Reduce margin for smaller screens */
      .container {
        margin-top: 20px;
      }

      /* Expand the card to take up more space on smaller screens */
      .card {
        width: 95%;
        padding: 20px;
      }

      /* Reduce table font size slightly to fit better on small screens */
      .table {
        font-size: 0.85rem;
      }

    }

    @media (max-width: 576px) {
      .form-select {
        font-size: 10px;
        /* Smaller font size for the dropdown text */
        padding: 5px;
        /* Adjust padding for a compact look */
        max-width: 200px;
        /* Reduce the max width */
        width: 100%;
        /* Ensure the dropdown takes up full width */
      }

      .form-select option {
        font-size: 10px;
        /* Smaller font size for the options */
        padding: 5px;
        /* Smaller padding inside the options */
      }

      /* Card adjustments for smaller screens */
      .card {
        width: 100%;
        padding: 15px;
      }

      /* Ensure table is scrollable on smaller screens */
      .table-responsive {
        overflow-x: auto;
      }

      .lblS {
        font-size: 10px;
      }

      .btn {
        width: 40%;
        height: auto;
        margin-top: 10px;
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
      <h1 class="admin-header">ADMIN PAGE
        <a href="https://online.fliphtml5.com/ojdmg/bvhe/" target="_blank" class="info-icon-link" title="User Manual MSTTCRS">
          <i class="bi bi-info-circle"></i>
        </a>
        <br>
        <a href="MSTTCRS%20RATING%20POINTS%20FORMAT.pdf" download class="info-icon-link" title="Download Rating Format PDF">
          <i class="bi bi-file-earmark-arrow-down"></i>
        </a>
      </h1>
      <label class="lblS">SELECT WHAT DATA NEED TO SHOW</label>
      <div class="input-group">
        <select class="form-select" id="dataSelect" name="dataSelect" required>
          <option selected disabled>Choose...</option>
          <option class="option" value="player">Player</option>
          <option class="option" value="news">News</option>
          <option class="option" value="tournament">Tournament</option>
          <option class="option" value="aboutus">About Us</option>
        </select>
        <button class="btnShow" id="enterButton" onclick="fetchData()">SHOW</button>
      </div>
      <div class="table-responsive">
        <div id="data-display"></div> <!-- Section to display data -->
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
        function fetchData() {
            var selectedOption = document.getElementById("dataSelect").value;

            // Make an AJAX request to fetch the data based on the selection
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "inputAdmin.php?type=" + selectedOption, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("data-display").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>

</body>

</html>