<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $IdNews = $_POST['IdNews']; // ID of the news item to update
    $NewsTitle = $_POST['NewsTitle'];
    $ShortDescription = $_POST['ShortDescription'];
    $NewsDescription = $_POST['NewsDescription'];
    $NewsDate = $_POST['NewsDate'];
    $NewsLink = $_POST['NewsLink'];

    // Retrieve the current news picture from the database
    $imageQuery = "SELECT NewsPicture FROM news WHERE IdNews = ?";
    $NewsPicture = NULL; // Default value

    if ($stmt = mysqli_prepare($connect, $imageQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $IdNews);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $existingImage);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        
        $NewsPicture = $existingImage; // Default to existing image
    }

    // Handle file upload (optional)
    if (isset($_FILES['NewsPicture']) && $_FILES['NewsPicture']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES['NewsPicture']['name']);
        $targetFilePath = $targetDir . $fileName;
        
        // Move the file to the server's upload directory
        if (move_uploaded_file($_FILES['NewsPicture']['tmp_name'], $targetFilePath)) {
            // If file upload succeeds, store the file name in the variable
            $NewsPicture = $fileName; // Update to new image filename
        } else {
            echo "File upload error.";
            exit; // Stop execution if there's an upload error
        }
    }

    // Update news in the database
    $updateQuery = "UPDATE news SET NewsTitle = ?, ShortDescription = ?, NewsDescription = ?, NewsDate = ?, NewsLink = ?, NewsPicture = ? WHERE IdNews = ?";
    if ($stmt = mysqli_prepare($connect, $updateQuery)) {
        mysqli_stmt_bind_param($stmt, "ssssssi", $NewsTitle, $ShortDescription, $NewsDescription, $NewsDate, $NewsLink, $NewsPicture, $IdNews);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: UpdateNews.php?status=success");
        } else {
            echo "Error updating news: " . mysqli_error($connect);
        }
        mysqli_stmt_close($stmt);
    }
} else {
    echo "Invalid form submission.";
}

mysqli_close($connect);
?>