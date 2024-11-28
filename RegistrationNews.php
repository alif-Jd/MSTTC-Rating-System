<?php include 'auth.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MSTTC - Add News</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- FontAwesome for icons (optional) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <link rel="stylesheet" href="header&footerAdmin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

  <style>
    /* Your existing CSS styles */
    body {
      background: linear-gradient(to right, black, gold);
    }

    h1 {
      color: white;
      text-align: center;
      margin-bottom: 30px;
      margin-top: 20px;
    }

    .card {
      position: relative;
      padding: 10px 10px 10px 30px;
      margin: 20px auto 50px auto;
      border-radius: 15px;
      background-color: #1a1b34;
      max-width: 950px;
      width: 100%;
    }

    .col-form-label {
      color: white;
      margin-bottom: 50px;
      text-align: left;
    }

    .form-group {
      margin-bottom: 20px;
    }

    input,
    textarea {
      margin-bottom: 15px;
      margin-left: 20px;
      max-width: 700px;
      width: 100%;
    }

    /* Default styling for form-controlDes */
    .form-controlDes {
      height: 200px;
      /* Default height */
      width: 100%;
      /* Ensures full width like other inputs */
      border-radius: 10px;
      margin-bottom: 15px;
    }

    .text-center {
      text-align: center;
    }

    .btnR {
      text-align: center;
      padding: 10px;
      font-size: 1.1rem;
      border-radius: 20px;
      background-color: #009E60;
      color: white;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
      height: 50px;
      max-width: 130px;
      margin: 0px auto 30px;
    }

    .btnR:hover {
      background-color: darkgreen;
      transform: scale(1.1);
    }

    .btn-block {
      display: block;
      width: 100%;
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

    /* Responsive Adjustments */
    @media (max-width: 1024px) {

      input,
      textarea {
        width: 90%;
        margin-left: 0px;
      }

      .btn {
        font-size: 1rem;
        height: 50px;
        max-width: 120px;
        padding: 10px;
      }

      h1 {
        font-size: 2rem;
      }

      .col-form-label {
        margin-bottom: 20px;
      }

      #alertMessage {
        max-width: 90%;
        padding: 8px;
      }

      input,
      .form-controlDes {
        width: 100%;
        /* Match other inputs' width on smaller screens */
        margin-left: 0;
        /* Align properly without offset */
      }

      .form-controlDes {
        height: 150px;
        /* Adjust height for tablets */
      }
    }

    @media (max-width: 768px) {

      input,
      textarea {
        width: 90%;
        padding: 10px;
        margin-left: 0px;
      }

      .btn {
        font-size: 0.9rem;
        height: 50px;
        max-width: 110px;
        padding: 8px;
      }

      h1 {
        font-size: 1.8rem;
      }

      .col-form-label {
        margin-bottom: 15px;
      }

      #alertMessage {
        max-width: 70%;
        padding: 6px;
      }

      .form-controlDes {
        height: 150px;
        /* Adjust height for tablets */
        width: 100%;
        /* Same width as other inputs */
      }
    }

    @media (max-width: 576px) {

      input,
      textarea {
        width: 85%;
        padding: 10px;
        margin-left: 0px;
      }

      .btn {
        font-size: 0.9rem;
        height: 40px;
        max-width: 100px;
        padding: 8px;
      }

      h1 {
        font-size: 1.5rem;
      }

      .col-form-label {
        margin-bottom: 10px;
      }

      #alertMessage {
        max-width: 90%;
        padding: 10px;
        font-size: 0.9rem;
      }

      .form-controlDes {
        height: 100px;
        /* Adjust height for phones */
        width: 100%;
        /* Same width as other inputs */
      }
    }

    @media (min-width: 1200px) {

      input,
      textarea {
        width: 80%;
        padding: 12px;
      }

      .btn {
        font-size: 1.2rem;
        height: 60px;
        max-width: 140px;
        padding: 12px;
      }

      h1 {
        font-size: 2.5rem;
      }

      #alertMessage {
        max-width: 80%;
        padding: 10px;
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

  <form id="newsForm" action="inputRegistrationNews.php" method="post" enctype="multipart/form-data">
    <div class="container">
      <div class="card">
        <h1>ADD NEWS</h1>
        <div class="row mb-1">
          <input type="hidden" name="IdNews" value="">

          <label for="name" class="col-sm-2 col-form-label">News Title</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="NewsTitle" value="" placeholder="Enter News Title" required>
          </div>

          <label for="short-description" class="col-sm-2 col-form-label">Short News Description</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="short-description" name="ShortDescription" placeholder="Enter Short News Description" required></textarea>
          </div>

          <label for="description" class="col-sm-2 col-form-label">News Description</label>
          <div class="col-sm-10">
            <textarea class="form-controlDes" id="description" name="NewsDescription" placeholder="Enter Full News Description" required></textarea>
          </div>

          <label for="date" class="col-sm-2 col-form-label">Date</label>
          <div class="col-sm-10">
            <input type="date" class="form-control" id="date" name="NewsDate" value="" required>
          </div>

          <label for="news-picture" class="col-sm-2 col-form-label">News Picture</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" id="news-picture" name="NewsPicture" accept="image/*" required>
          </div>
          <div>
            <img id="imagePreview" style="max-width: 100%; display: none;">
          </div>
          <input type="hidden" id="croppedImage" name="croppedImage"> <!-- Hidden input to hold cropped image data -->

          <label for="link" class="col-sm-2 col-form-label">Link</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="link" name="NewsLink" value="" placeholder="Enter Enter Related Link (Optional)" >
          </div>

          <div class="text-center">
            <button class="btnR btn-dark btn-lg btn-block" type="submit">ADD NEWS</button>
          </div>

          <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert"
            style="display: none;">
            <strong>Success!</strong> News Registered Successfully!
          </div>
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

  <script>
    function validateForm(event) {}

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
          alertMessage.classList.add('hidden'); // Trigger fade-out animation
          setTimeout(() => {
            alertMessage.style.display = 'none'; // Fully hide after fade-out
          }, 1000); // Wait for the fade-out animation (1s) to complete
        }, 2000); // Wait 2 seconds before starting the fade-out
      }
    }

    // Show the alert message after form submission
    window.onload = function() {
      if (window.location.search.includes('status=success')) {
        const alertMessage = document.getElementById('alertMessage');
        alertMessage.style.display = 'block'; // Display the success message
        alertMessage.classList.remove('hidden'); // Ensure the alert is visible
        scrollToBottom(); // Scroll to bottom and trigger auto hide
      }
    };

    const imageInput = document.getElementById('NewsPicture');
    const imagePreview = document.getElementById('imagePreview');
    let cropper;

    imageInput.addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (!file) {
        alert("No file selected.");
        return; // Exit if no file selected
      }

      const reader = new FileReader();
      reader.onload = function(e) {
        imagePreview.src = e.target.result;
        imagePreview.style.display = 'block';

        if (cropper) cropper.destroy(); // Destroy any existing cropper
        cropper = new Cropper(imagePreview, {
          // Remove aspectRatio to allow free cropping
          viewMode: 1, // Allows users to see the cropped area without restrictions
          autoCropArea: 1, // Starts with the auto crop area covering the whole image
          crop() {
            const canvas = cropper.getCroppedCanvas(); // No fixed width or height
            // Set the cropped image data to the hidden input field
            document.getElementById('croppedImage').value = canvas.toDataURL(); // Default to 'image/png' for full compatibility
          }
        });
      };

      reader.onerror = function() {
        alert("Error reading file. Please try again.");
      };

      reader.readAsDataURL(file);
    });

    // Ensure the cropped image is processed before form submission
    document.querySelector('form').addEventListener('submit', function(event) {
      const croppedImageInput = document.getElementById('croppedImage');
      if (!croppedImageInput.value) {
        event.preventDefault(); // Prevent form submission if no cropped image
        alert('Please crop the image before submitting.');
      }
    });
  </script>

</body>

</html>