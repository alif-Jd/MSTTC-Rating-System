<?php
include "config.php"; // Include the database connection

// Check if the delete form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $IdTournament = $_POST['IdTournament'] ?? null; // Get IdTournament if provided

    // Prepare the delete query based on the provided IdTournament
    if ($IdTournament) {
        $deleteQuery = "DELETE FROM tournament WHERE IdTournament = ?";
        if ($stmt = mysqli_prepare($connect, $deleteQuery)) {
            mysqli_stmt_bind_param($stmt, "i", $IdTournament); // "i" for integer
            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    // Redirect to the same page with a success status
                    header("Location: DeleteTournament.php?status=success");
                    exit();
                } else {
                    echo "Error: No tournament found with the given ID.";
                }
            } else {
                echo "Error deleting tournament: " . mysqli_error($connect);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Invalid request. Please provide a valid Tournament ID.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($connect);
?>
