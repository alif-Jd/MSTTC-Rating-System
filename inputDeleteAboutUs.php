<?php
include "config.php"; // Include database configuration

// Check if the delete form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use null coalescing to handle undefined
    $IdYoutube = $_POST['IdYoutube'] ?? null;

    // Validate that IdYoutube is provided and is a valid integer
    if ($IdYoutube !== null && filter_var($IdYoutube, FILTER_VALIDATE_INT) !== false) {
        // Prepare the delete query based on IdYoutube
        $deleteQuery = "DELETE FROM aboutus WHERE IdYoutube = ?";
        if ($stmt = mysqli_prepare($connect, $deleteQuery)) {
            // Bind the IdYoutube parameter
            mysqli_stmt_bind_param($stmt, "i", $IdYoutube);
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
} else {
    echo "Invalid request.";
}

mysqli_close($connect); // Close the database connection
?>

