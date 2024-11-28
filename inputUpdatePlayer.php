<?php
include "config.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateProfile'])) {
    // Get player data from POST
    $IdPlayer = $_POST['IdPlayer'];
    $Name = $_POST['Name'];
    $NickName = $_POST['NickName'];
    $Age = $_POST['Age'];
    $DominantHand = $_POST['DominantHand'];
    $Playstyle = $_POST['Playstyle'];
    $Blade = $_POST['Blade'];
    $RubberForeHand = $_POST['RubberForeHand'];
    $RubberBackHand = $_POST['RubberBackHand'];
    $Grip = $_POST['Grip'];
    $CareerType = $_POST['CareerType'];

    // Verify if the data is being received
    echo "<pre>";
    echo "ID Player: $IdPlayer\n";
    echo "Name: $Name\n";
    echo "NickName: $NickName\n";
    echo "Age: $Age\n";
    echo "Dominant Hand: $DominantHand\n";
    echo "Playstyle: $Playstyle\n";
    echo "Blade: $Blade\n";
    echo "Rubber ForeHand: $RubberForeHand\n";
    echo "Rubber BackHand: $RubberBackHand\n";
    echo "Grip: $Grip\n";
    echo "Career Type: $CareerType\n";
    echo "</pre>";
    
    // Retrieve existing images from the database
    $imageQuery = "SELECT ImagePlayer, ImageRubberForeHand, ImageRubberBackHand FROM player WHERE IdPlayer = ?";
    if ($stmt = mysqli_prepare($connect, $imageQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $IdPlayer);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $existingImage, $existingRubberForeHandImage, $existingRubberBackHandImage);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    // Initialize image paths with the existing images
    $ImagePlayer = $existingImage;
    $ImageRubberForeHand = $existingRubberForeHandImage;
    $ImageRubberBackHand = $existingRubberBackHandImage;

    // Process cropped ImagePlayer data (if provided)
    if (isset($_POST['croppedImage']) && !empty($_POST['croppedImage'])) {
        $croppedImageData = $_POST['croppedImage'];
        if (strpos($croppedImageData, 'data:image/') === 0) {
            list($type, $croppedImageData) = explode(';', $croppedImageData);
            list(, $croppedImageData) = explode(',', $croppedImageData);
            $croppedImageData = base64_decode($croppedImageData);
            $extension = ($type === 'data:image/jpeg') ? 'jpg' : 'png';
            $filePath = 'uploads/' . $IdPlayer . '_cropped.' . $extension;
            file_put_contents($filePath, $croppedImageData);
            $ImagePlayer = $filePath . '?' . time(); // Cache-busting timestamp
        }
    }

    // Process cropped RubberForeHand data
    if (isset($_POST['croppedRubberForeHand'])) {
        $croppedRubberForeHandData = $_POST['croppedRubberForeHand'];
        if (strpos($croppedRubberForeHandData, 'data:image/') === 0) {
            list($type, $croppedRubberForeHandData) = explode(';', $croppedRubberForeHandData);
            list(, $croppedRubberForeHandData) = explode(',', $croppedRubberForeHandData);
            $croppedRubberForeHandData = base64_decode($croppedRubberForeHandData);
            $extension = ($type === 'data:image/jpeg') ? 'jpg' : 'png';
            $filePath = 'uploads/' . $IdPlayer . '_rubberForeHand.' . $extension;
            file_put_contents($filePath, $croppedRubberForeHandData);
            $ImageRubberForeHand = $filePath . '?' . time(); // Cache-busting timestamp
        }
    }

    // Process cropped RubberBackHand data
    if (isset($_POST['croppedRubberBackHand'])) {
        $croppedRubberBackHandData = $_POST['croppedRubberBackHand'];
        if (strpos($croppedRubberBackHandData, 'data:image/') === 0) {
            list($type, $croppedRubberBackHandData) = explode(';', $croppedRubberBackHandData);
            list(, $croppedRubberBackHandData) = explode(',', $croppedRubberBackHandData);
            $croppedRubberBackHandData = base64_decode($croppedRubberBackHandData);
            $extension = ($type === 'data:image/jpeg') ? 'jpg' : 'png';
            $filePath = 'uploads/' . $IdPlayer . '_rubberBackHand.' . $extension;
            file_put_contents($filePath, $croppedRubberBackHandData);
            $ImageRubberBackHand = $filePath . '?' . time(); // Cache-busting timestamp
        }
    }

    // Update profile data in the database
    $updateProfileQuery = "UPDATE player SET Name = ?, NickName = ?, Age = ?, DominantHand = ?, Playstyle = ?, Blade = ?, RubberForeHand = ?, RubberBackHand = ?, Grip = ?, ImagePlayer = ?, ImageRubberForeHand = ?, ImageRubberBackHand = ?, CareerType = ? WHERE IdPlayer = ?";
    if ($stmt = mysqli_prepare($connect, $updateProfileQuery)) {
        mysqli_stmt_bind_param($stmt, "ssissssssssssi", $Name, $NickName, $Age, $DominantHand, $Playstyle, $Blade, $RubberForeHand, $RubberBackHand, $Grip, $ImagePlayer, $ImageRubberForeHand, $ImageRubberBackHand, $CareerType, $IdPlayer);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: UpdatePlayer.php?status=success");
            exit;
        } else {
            echo "Error updating profile: " . mysqli_error($connect);
        }
        mysqli_stmt_close($stmt);
    }
} else {
    echo "No profile data received for update.";
}



// Check for points Player data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updatePoints'])) {
    $IdPlayer = $_POST['IdPlayer'];
    $PositionWin = isset($_POST['PositionWin']) && !empty($_POST['PositionWin']) ? $_POST['PositionWin'] : NULL;
    $TournamentType = isset($_POST['TournamentType']) && !empty($_POST['TournamentType']) ? $_POST['TournamentType'] : NULL;

    // Retrieve existing rating points
    $ratingQuery = "SELECT RatingPoint FROM player WHERE IdPlayer = ?";
    if ($stmt = mysqli_prepare($connect, $ratingQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $IdPlayer);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $existingRatingPoint);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    // Define tournament points based on PositionWin
    $tournamentPoints = [
        "International" => [378, 252, 168, 112, 70, 42, 28, 14],
        "States" => [216, 144, 96, 64, 40, 24, 16, 8],
        "Districts" => [54, 36, 24, 16, 10, 6, 4, 2]
    ];

    function getTournamentPoints($TournamentType, $PositionWin, $tournamentPoints)
    {
        if (!isset($tournamentPoints[$TournamentType])) {
            return 0; // Invalid tournament type
        }

        $PositionWin = (int) $PositionWin;

        switch ($PositionWin) {
            case 1:
                return $tournamentPoints[$TournamentType][0]; // 1st place
            case 2:
                return $tournamentPoints[$TournamentType][1]; // 2nd place
            case 3:
            case 4:
                return $tournamentPoints[$TournamentType][2]; // 3rd-4th place
            case 5:
            case 6:
            case 7:
            case 8:
                return $tournamentPoints[$TournamentType][3]; // 5th-8th place
            case 9:
            case 10:
            case 11:
            case 12:
            case 13:
            case 14:
            case 15:
            case 16:
                return $tournamentPoints[$TournamentType][4]; // 9th-16th place
            case 17:
            case 18:
            case 19:
            case 20:
            case 21:
            case 22:
            case 23:
            case 24:
            case 25:
            case 26:
            case 27:
            case 28:
            case 29:
            case 30:
            case 31:
            case 32:
                return $tournamentPoints[$TournamentType][5]; // 17th-32nd place
            case 33:
            case 34:
            case 35:
            case 36:
            case 37:
            case 38:
            case 39:
            case 40:
            case 41:
            case 42:
            case 43:
            case 44:
            case 45:
            case 46:
            case 47:
            case 48:
            case 49:
            case 50:
            case 51:
            case 52:
            case 53:
            case 54:
            case 55:
            case 56:
            case 57:
            case 58:
            case 59:
            case 60:
            case 61:
            case 62:
            case 63:
            case 64:
                return $tournamentPoints[$TournamentType][6]; // 33rd-64th place
            case 65:
            case 66:
            case 67:
            case 68:
            case 69:
            case 70:
            case 71:
            case 72:
            case 73:
            case 74:
            case 75:
            case 76:
            case 77:
            case 78:
            case 79:
            case 80:
            case 81:
            case 82:
            case 83:
            case 84:
            case 85:
            case 86:
            case 87:
            case 88:
            case 89:
            case 90:
            case 91:
            case 92:
            case 93:
            case 94:
            case 95:
            case 96:
            case 97:
            case 98:
            case 99:
            case 100:
            case 101:
            case 102:
            case 103:
            case 104:
            case 105:
            case 106:
            case 107:
            case 108:
            case 109:
            case 110:
            case 111:
            case 112:
            case 113:
            case 114:
            case 115:
            case 116:
            case 117:
            case 118:
            case 119:
            case 120:
            case 121:
            case 122:
            case 123:
            case 124:
            case 125:
            case 126:
            case 127:
            case 128:
                return $tournamentPoints[$TournamentType][7]; // 65th-128th place
            default:
                return 0; // PositionWin doesn't match any case
        }
    }

    // Calculate additional points for the tournament
    $newTournamentPoints = getTournamentPoints($TournamentType, $PositionWin, $tournamentPoints);

    // Add the new points to the existing rating points
    $RatingPoint = $existingRatingPoint + $newTournamentPoints;

    // Update rating points in the database
    $updatePointsQuery = "UPDATE player SET RatingPoint = ?, PositionWin = ?, TournamentType = ? WHERE IdPlayer = ?";
    if ($stmt = mysqli_prepare($connect, $updatePointsQuery)) {
        mysqli_stmt_bind_param($stmt, "issi", $RatingPoint, $PositionWin, $TournamentType, $IdPlayer);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: UpdatePlayer.php?status=success");
            exit;
        } else {
            echo "Error updating points: " . mysqli_error($connect);
        }
        mysqli_stmt_close($stmt);
    }

    // Close the database connection
    mysqli_close($connect);
}


