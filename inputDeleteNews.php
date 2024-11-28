<?php
include "config.php";

// Check if the delete form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $IdNews = $_POST['IdNews'] ?? null; // Use null coalescing to handle undefined

    // Prepare the delete query based on IdNews
    if ($IdNews) {
        $deleteQuery = "DELETE FROM news WHERE IdNews = ?";
        if ($stmt = mysqli_prepare($connect, $deleteQuery)) {
            mysqli_stmt_bind_param($stmt, "i", $IdNews); // "i" for integer
            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    // Redirect to the same page with a success status
                    header("Location: DeleteNews.php?status=success");
                    exit();
                } else {
                    echo "Error: No news found with the given ID.";
                }
            } else {
                echo "Error deleting news: " . mysqli_error($connect);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Invalid request. Please provide a valid News ID.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($connect);
?>
