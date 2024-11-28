<?php
header('Content-Type: application/json'); // Set header to JSON

include 'config.php'; // Include your database connection configuration

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define age intervals and corresponding SQL conditions
    $ageIntervals = [
        '1-10' => 'Age < 11',
        '11-20' => 'Age >= 11 AND Age < 21',
        '21-30' => 'Age >= 21 AND Age < 31',
        '31-40' => 'Age >= 31 AND Age < 41',
        '41-50' => 'Age >= 41 AND Age < 51',
        '51-60' => 'Age >= 51 AND Age < 61',
        '61-70' => 'Age >= 61 AND Age < 71',
        '71-80' => 'Age >= 71 AND Age < 81',
        '81-90' => 'Age >= 81 AND Age < 91',
        '91-100' => 'Age >= 91 AND Age < 101'
    ];

    $ageData = [];

    // Query each age interval and count players
    foreach ($ageIntervals as $label => $condition) {
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM player WHERE $condition");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $ageData[] = ['ageRange' => $label, 'count' => (int)$result['count']];
    }

    // Output data as JSON
    echo json_encode($ageData);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

// Close the database connection
$pdo = null;
?>
