<?php
include 'config.php';

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$itemsPerPage = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Get total player count based on search
if ($searchQuery) {
    $totalPlayersQuery = "SELECT COUNT(*) AS total FROM player WHERE Name LIKE '%$searchQuery%' OR NickName LIKE '%$searchQuery%'";
} else {
    $totalPlayersQuery = "SELECT COUNT(*) AS total FROM player";
}

$totalPlayersResult = $connect->query($totalPlayersQuery);
$totalPlayers = $totalPlayersResult->fetch_assoc()['total'];
$totalPages = ceil($totalPlayers / $itemsPerPage);

// Generate pagination links
for ($i = 1; $i <= $totalPages; $i++) {
    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
            <a class="page-link" href="?page=' . $i . '&search=' . urlencode($searchQuery) . '">' . $i . '</a>
          </li>';
}
?>
