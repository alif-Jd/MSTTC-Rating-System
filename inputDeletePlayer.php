<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $IdPlayer = $_POST['IdPlayer'] ?? null;

    if ($IdPlayer) {
        $deleteQuery = "DELETE FROM player WHERE IdPlayer = ?";
        if ($stmt = mysqli_prepare($connect, $deleteQuery)) {
            mysqli_stmt_bind_param($stmt, "i", $IdPlayer);
            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    header("Location: DeletePlayer.php?status=success");
                    exit();
                } else {
                    echo "Error: No player found with the given ID.";
                }
            } else {
                echo "Error executing query: " . mysqli_error($connect);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($connect);
?>
