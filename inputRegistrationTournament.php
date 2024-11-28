<?php

include "config.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $TournamentTitle = isset($_POST["TournamentTitle"]) ? $_POST["TournamentTitle"] : null;
    $TournamentPlace = isset($_POST["TournamentPlace"]) ? $_POST["TournamentPlace"] : null;
    $TournamentDate = isset($_POST["TournamentDate"]) ? $_POST["TournamentDate"] : null;
    
    // Check if the file has been uploaded
    if (isset($_FILES["TournamentImage"]) && $_FILES["TournamentImage"]["error"] === UPLOAD_ERR_OK) {
        $TournamentImage = $_FILES["TournamentImage"]["name"];
        $target_dir = "uploads/";  // Ensure the "uploads" folder exists and has proper write permissions
        $target_file = $target_dir . basename($TournamentImage);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["TournamentImage"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($TournamentImage)) . " has been uploaded.<br>";
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    } else {
        echo "No file uploaded or there was an upload error.<br>";
    }

    $TournamentLinkDetails = isset($_POST["TournamentLinkDetails"]) ? $_POST["TournamentLinkDetails"] : null;

    // Insert data into the database
    $SQLCommand = "INSERT INTO tournament (TournamentTitle, TournamentPlace, TournamentDate, TournamentImage, TournamentLinkDetails) 
    VALUES (?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($connect, $SQLCommand)) {
        mysqli_stmt_bind_param($stmt, "sssss", $TournamentTitle, $TournamentPlace, $TournamentDate, $TournamentImage, $TournamentLinkDetails);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: RegistrationTournament.php?status=success");
        } else {
            echo "Error: " . mysqli_stmt_error($stmt) . "<br>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "SQL prepare failed: " . mysqli_error($connect) . "<br>";
    }

    // Display the submitted data
    echo "Tournament Title: " . htmlspecialchars($TournamentTitle) . "<br>";
    echo "Tournament Place: " . htmlspecialchars($TournamentPlace) . "<br>";
    echo "Tournament Date: " . htmlspecialchars($TournamentDate) . "<br>";
    echo "Tournament Image: " . htmlspecialchars($TournamentImage) . "<br>";
    echo "Tournament Link: " . htmlspecialchars($TournamentLinkDetails) . "<br>";
}
?>
