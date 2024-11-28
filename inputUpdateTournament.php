<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $IdTournament = $_POST['IdTournament']; // ID of the tournament to update
    $TournamentTitle = $_POST['TournamentTitle'];
    $TournamentPlace = $_POST['TournamentPlace'];
    $TournamentDate = $_POST['TournamentDate'];
    $TournamentLinkDetails = $_POST['TournamentLinkDetails'];

    // Retrieve the current image from the database
    $imageQuery = "SELECT TournamentImage FROM tournament WHERE IdTournament = ?";
    $TournamentImage = NULL; // Default value

    if ($stmt = mysqli_prepare($connect, $imageQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $IdTournament);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $existingImage);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        
        $TournamentImage = $existingImage; // Default to existing image
    }

    // Handle file upload (optional)
    if (isset($_FILES['TournamentImage']) && $_FILES['TournamentImage']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES['TournamentImage']['name']);
        $targetFilePath = $targetDir . $fileName;

        // Move the file to the uploads directory
        if (move_uploaded_file($_FILES['TournamentImage']['tmp_name'], $targetFilePath)) {
            // If file upload succeeds, store the file name in the database
            $TournamentImage = $fileName; // Update the image path
        } else {
            echo "Error uploading image.";
            exit;
        }
    }

    // Update tournament in the database
    $updateQuery = "UPDATE tournament SET TournamentTitle = ?, TournamentPlace = ?, TournamentDate = ?, TournamentLinkDetails = ?, TournamentImage = ? WHERE IdTournament = ?";
    if ($stmt = mysqli_prepare($connect, $updateQuery)) {
        mysqli_stmt_bind_param($stmt, "sssssi", $TournamentTitle, $TournamentPlace, $TournamentDate, $TournamentLinkDetails, $TournamentImage, $IdTournament);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: UpdateTournament.php?status=success");
        } else {
            echo "Error updating tournament: " . mysqli_error($connect);
        }
        mysqli_stmt_close($stmt);
    }
} else {
    echo "Invalid form submission.";
}

mysqli_close($connect);
?>
