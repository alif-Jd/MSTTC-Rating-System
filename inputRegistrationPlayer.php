<?php
include "config.php"; // Assumes config.php connects to the database

$Name = $_POST["Name"];
$NickName = $_POST["NickName"];
$Age = $_POST["Age"];
$DominantHand = $_POST["DominantHand"];
$Playstyle = $_POST["Playstyle"];
$Blade = $_POST["Blade"];
$RubberForeHand = $_POST["RubberForeHand"];
$RubberBackHand = $_POST["RubberBackHand"];
$Grip = $_POST["Grip"];
$CareerType = $_POST["CareerType"]; // Get career type from form submission

// Define tournament points based on CareerType
$CareerPoints = [
    "BEGINNER" => 0,
    "ADVANCED" => 800,
    "INTERMEDIATE" => 1200,
    "PROFESSIONAL" => 1500
];

// Calculate the rating points based on career type
$RatingPoint = isset($CareerPoints[$CareerType]) ? $CareerPoints[$CareerType] : 0;

// Check if a player with the same Name, Nickname, and Age already exists
$checkQuery = "SELECT COUNT(*) AS count FROM player WHERE Name = ? AND NickName = ? ";
if ($stmt = mysqli_prepare($connect, $checkQuery)) {
    mysqli_stmt_bind_param($stmt, "ss", $Name, $NickName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    if ($count > 0) {
        header("Location: RegistrationPlayer.php?status=error");
                exit();
    } else {
        // Insert new player if no duplicate found
        $insertQuery = "INSERT INTO player (Name, NickName, Age, DominantHand, Playstyle, Blade, RubberForeHand, RubberBackHand, Grip, CareerType, RatingPoint) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($connect, $insertQuery)) {
            mysqli_stmt_bind_param($stmt, "ssissssssss", $Name, $NickName, $Age, $DominantHand, $Playstyle, $Blade, $RubberForeHand, $RubberBackHand, $Grip, $CareerType, $RatingPoint);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: RegistrationPlayer.php?status=success");
                exit();
            } else {
                echo "Error inserting player: " . mysqli_error($connect);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing insert statement: " . mysqli_error($connect);
        }
    }
} else {
    echo "Error preparing check statement: " . mysqli_error($connect);
}

// Close the database connection
mysqli_close($connect);
?>
