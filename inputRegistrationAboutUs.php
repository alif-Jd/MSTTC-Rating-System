<?php
include "config.php"; // Include database configuration

// Initialize variables
$success = false;
$errorMessage = "";

// Check if an IdYoutube is provided in the GET request
if (isset($_GET['IdYoutube'])) {
    $IdYoutube = $_GET['IdYoutube'];
    $searchQuery = "SELECT * FROM aboutus WHERE IdYoutube = ?";
    if ($stmt = mysqli_prepare($connect, $searchQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $IdYoutube);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($about = mysqli_fetch_assoc($result)) {
            // About information found, process $about array as needed (e.g., populate form fields)
        } else {
            $errorMessage = "No information found with the provided ID.<br>";
        }
        mysqli_stmt_close($stmt);
    } else {
        $errorMessage = "Error preparing statement: " . mysqli_error($connect) . "<br>";
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize inputs
    $YoutubeTitle = isset($_POST["TitleYoutube"]) ? trim($_POST["TitleYoutube"]) : '';
    $YoutubeLink = isset($_POST["LinksYoutube"]) ? trim($_POST["LinksYoutube"]) : '';

    // Validate form inputs
    if (empty($YoutubeTitle) || empty($YoutubeLink)) {
        $errorMessage = "All fields are required.<br>";
    } elseif (!filter_var($YoutubeLink, FILTER_VALIDATE_URL)) {
        $errorMessage = "Invalid YouTube link format.<br>";
    }

    // If no errors, proceed to insert data into the database
    if (empty($errorMessage)) {
        $stmt = $connect->prepare("INSERT INTO aboutus (YoutubeTitle, YoutubeLink) VALUES (?, ?)");
        $stmt->bind_param("ss", $YoutubeTitle, $YoutubeLink);

        if ($stmt->execute()) {
            $success = true;
            // Redirect to RegistrationAboutUs.php with success parameter
            header("Location: RegistrationAboutUs.php?status=success");
            exit();
        } else {
            $errorMessage = "Database error: " . $stmt->error . "<br>";
        }

        $stmt->close();
    }
}

// Close the database connection
mysqli_close($connect); 
?>
