<?php
include "config.php"; // Include database configuration

// Search for news by ID if provided
if (isset($_GET['IdNews'])) {
    $IdNews = $_GET['IdNews'];
    $searchQuery = "SELECT * FROM news WHERE IdNews = ?";
    if ($stmt = mysqli_prepare($connect, $searchQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $IdNews);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($news = mysqli_fetch_assoc($result)) {
            // News found, process $news array as needed
        } else {
            echo "No news found with the provided ID.<br>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connect) . "<br>";
    }
}

// Retrieve form data
$IdNews = isset($_POST["IdNews"]) ? $_POST["IdNews"] : null;
$NewsTitle = $_POST["NewsTitle"];
$ShortDescription = $_POST["ShortDescription"];
$NewsDescription = $_POST["NewsDescription"];
$NewsDate = $_POST["NewsDate"];
$NewsLink = $_POST["NewsLink"];

// Handle file upload for NewsPicture
$NewsPicture = $_FILES["NewsPicture"]["name"];
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["NewsPicture"]["name"]);

// Check if file upload has errors
if ($_FILES['NewsPicture']['error'] !== UPLOAD_ERR_OK) {
    echo "File upload error: " . $_FILES['NewsPicture']['error'] . "<br>";
    exit;
}

// Validate uploaded file type (optional, but recommended)
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($fileType, $allowedTypes)) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    exit;
}

// Move the uploaded file to the target directory
if (move_uploaded_file($_FILES["NewsPicture"]["tmp_name"], $target_file)) {
    //echo "The file " . htmlspecialchars(basename($_FILES["NewsPicture"]["name"])) . " has been uploaded.<br>";
} else {
    //echo "Sorry, there was an error uploading your file.<br>";
    exit;
}

// Validate form inputs
if (empty($NewsTitle) || empty($ShortDescription) || empty($NewsDescription) || empty($NewsDate)) {
    echo "All fields are required.<br>";
    exit;
}

// Use a prepared statement to insert data into the database
$stmt = $connect->prepare("INSERT INTO news (NewsTitle, ShortDescription, NewsDescription, NewsDate, NewsPicture, NewsLink) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $NewsTitle, $ShortDescription, $NewsDescription, $NewsDate, $NewsPicture, $NewsLink);

if ($stmt->execute()) {
    // Redirect to RegistrationNews.php with success parameter
    header("Location: RegistrationNews.php?status=success");
    exit();
} else {
    echo "Error: " . $stmt->error . "<br>";
}

$stmt->close();
mysqli_close($connect); // Close the database connection

?>
