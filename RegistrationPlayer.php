<?php include 'auth.php'; 

include 'config.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MSTTC - Registration Page</title>

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
    }

    h1 {
      color: white;
      text-align: center;
      margin-bottom: 30px;
      margin-top: 20px;
    }

    h2 {
      color: white;
      text-align: center;
      margin-bottom: 30px;
      margin-top: 20px;
    }

    .card {
      padding: 20px;
      border-radius: 15px;
      background-color: #1a1b34;
      margin: 20px auto;
      /* Ensures some margin for better visibility */
    }

    .container {
      max-width: 1500px;
      margin: 0 auto;
    }

    .col-form-label {
      color: white;
      margin-bottom: 50px;
    }


    input,
    select {
      margin-bottom: 20px;
    }

    .text-center {
      text-align: center;
    }

    .btnR {
      text-align: center;
      padding: 8px 15px;
      font-size: 1.1rem;
      border-radius: 20px;
      background-color: #009E60;
      color: white;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
      width: 150px;
      height: 50px;
      max-width: 180px;
      margin: auto auto;
      
    }

    .btnR:hover {
      background-color: darkgreen;
      transform: scale(1.1);
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

     /* Base style for the alert */
     #alertError {
      max-width: 80%;
      margin: 20px auto;
      text-align: center;
      transition: opacity 1s ease;
      /* Smooth fade-out transition */
      opacity: 1;
      /* Fully visible initially */
    }

    /* Media queries for different screen sizes */
    @media (max-width: 767px) {

      /* For mobile devices */
      .card {
        width: 95%;
      }

      .col-form-label {
      color: white;
      margin-bottom:10px;
    }
    }

    @media (min-width: 768px) and (max-width: 1024px) {

      /* For tablets */
      .card {
        width: 90%;
      }
      .col-form-label {
      color: white;
      margin-bottom: 35px;
    }
    }

    @media (min-width: 1025px) and (max-width: 1440px) {

      /* For laptops */
      .card {
        width: 80%;
      }

      
    }

    @media (min-width: 1441px) {

      /* For larger monitors */
      .card {
        width: 60%;
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

  <form action="inputRegistrationPlayer.php" method="post" enctype="multipart/form-data">

    <div class="container">
      <div class="card">
        <h1>REGISTER PLAYER</h1>
        <div class="row mb-1">
          <label for="name" class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="Name" placeholder="Enter Player's Full Name" required>
          </div>

          <label for="nickname" class="col-sm-2 col-form-label">NickName</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="nickname" name="NickName" placeholder="Enter Player's Nickname" required>
          </div>

          <label for="age" class="col-sm-2 col-form-label">Age</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="age" name="Age" placeholder="Enter Player's Age" required>
          </div>

          <div class="col-sm-2 col-form-label">Dominant Hand</div>
          <div class="col-sm-10">
            <select class="form-select" id="specificSizeSelect" name="DominantHand" required>
              <option value="" selected disabled>Choose...</option>
              <option value="Right">RIGHT</option>
              <option value="Left">LEFT</option>
            </select>
          </div>

          <div class="col-sm-2 col-form-label">Playstyle</div>
          <div class="col-sm-10">
            <select class="form-select" id="playstyle" name="Playstyle" required>
              <option value="" selected disabled>Choose...</option>
              <option value="The Aggressor">Aggressor</option>
              <option value="The Controller">Controller</option>
              <option value="The All-Rounder">All-Rounder</option>
              <option value="The Brick Wall">Brick Wall</option>
              <option value="The Defender">Defender</option>
            </select>
          </div>


          <div class="col-sm-2 col-form-label">Career Type</div>
          <div class="col-sm-10">
           <select class="form-select" id="career_type" name="CareerType" required>
              <option value="" selected disabled>Career Type (Please Select)</option>
              <option value="BEGINNER">BEGINNER</option>
              <option value="ADVANCED">ADVANCED</option>
              <option value="INTERMEDIATE">INTERMEDIATE</option>
              <option value="PROFESSIONAL">PROFESSIONAL</option>
            </select>
          </div>

          <label for="name" class="col-sm-2 col-form-label">Equipment</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" placeholder="Enter Blade" name="Blade"  required>
            <input type="text" class="form-control" placeholder="Enter Rubber ForeHand" name="RubberForeHand"  required>
            <input type="text" class="form-control" placeholder="Enter Rubber Backhand" name="RubberBackHand"  required>
            
            <select class="form-select" id="grip" name="Grip" required>
              <option value="" selected disabled>Grip (Please Select)</option>
              <option value="Shakehand">SHAKEHAND</option>
              <option value="Penhold">PENHOLD</option>
            </select>
          </div>

        <div class="text-center">
          <button class="btnR btn-dark btn-lg btn-block" type="submit">REGISTER</button>
        </div>

        <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert"
            style="display: none;">
            <strong>Success!</strong> Player Registered Successfully!
          </div>

          <div id="alertError" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
    <strong>Error!</strong> Player already Registered !
</div>
          
      </div>   
    </div>   
  </form>
  
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
    // Function to scroll to the bottom of the page and hide alert after 3 seconds
    function scrollToBottom() {
        window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth' // Smooth scrolling effect
        });

        // Check if the alert message is visible
        const alertMessage = document.getElementById('alertMessage');
        if (alertMessage.style.display === 'block') {
            setTimeout(() => {
                alertMessage.classList.add('fade-out'); // Trigger fade-out animation
                setTimeout(() => {
                    alertMessage.style.display = 'none'; // Fully hide after fade-out
                }, 1000); // Wait for the fade-out animation (1s) to complete
            }, 2000); // Wait 2 seconds before starting the fade-out
        }
    }

    // Show the alert message after form submission
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'success') {
            const alertMessage = document.getElementById('alertMessage');
            alertMessage.style.display = 'block'; // Display the success message
            alertMessage.classList.remove('fade-out'); // Ensure the alert is visible
            scrollToBottom(); // Scroll to bottom and trigger auto-hide
        } else if (status === 'error') {
            const alertError = document.getElementById('alertError');
            alertError.style.display = 'block'; // Display the error message
            scrollToBottom(); // Scroll to bottom and trigger auto-hide
        }
    };
  </script>
</body>

</html>