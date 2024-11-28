<?php
include 'config.php'; // Include the database connection

// Get the type of data requested (player, news, or tournament)
$type = $_GET['type'];

if ($type == 'player') {
    // Query for player data
    $player_sql = "SELECT * FROM player";
    $player_result = $connect->query($player_sql);
    
    echo "<h2>Player Data</h2>";
    echo "<table class='table table-striped table-dark'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>NickName</th>
                    <th>Age</th>
                    <th>Carrer Type</th>
                </tr>
            </thead>
            <tbody>";
    if ($player_result->num_rows > 0) {
        while ($row = $player_result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["IdPlayer"] . "</td>
                    <td>" . $row["Name"] . "</td>
                    <td>" . $row["NickName"] . "</td>
                    <td>" . $row["Age"] . "</td>
                    <td>" . $row["CareerType"] . "</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No player data found.</td></tr>";
    }
    echo "</tbody></table>";
    
    // Query to count total players
    $count_sql = "SELECT COUNT(*) AS total_players FROM player";
    $count_result = $connect->query($count_sql);
    $total_players = 0; // Default value
    if ($count_result->num_rows > 0) {
        $count_row = $count_result->fetch_assoc();
        $total_players = $count_row['total_players'];
    }
    
    // Display total players
    echo "<div class='d-flex justify-content-center mt-3'>
            <h5>Total Players: " . $total_players . "</h5>
          </div>";
    
  // Add button link to CartPlayer.php after the table
    echo "<div class='d-flex justify-content-center mt-3'>
    <a href='ChartPlayer.php' class='btn btn-primary custom-btn'>View Player Chart</a>
    </div>";

  
} elseif ($type == 'news') {
    // Query for news data
    $news_sql = "SELECT IdNews, NewsTitle, ShortDescription, NewsDescription, NewsDate, NewsPicture, NewsLink FROM news";
    $news_result = $connect->query($news_sql);

    echo "<h2>News Data</h2>";
    echo "<table class='table table-striped table-dark'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>NewsDate</th>
                </tr>
            </thead>
            <tbody>";
    if ($news_result->num_rows > 0) {
        while ($row = $news_result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["IdNews"] . "</td>
                    <td>" . $row["NewsTitle"] . "</td>
                    <td>" . $row["NewsDate"] . "</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No news data found.</td></tr>";
    }
    echo "</tbody></table>";
    
    // Query to count total players
    $count_sql = "SELECT COUNT(*) AS total_news FROM news";
    $count_result = $connect->query($count_sql);
    $total_news = 0; // Default value
    if ($count_result->num_rows > 0) {
        $count_row = $count_result->fetch_assoc();
        $total_news = $count_row['total_news'];
    }
    
    // Display total players
    echo "<div class='d-flex justify-content-center mt-3'>
            <h5>Total News: " . $total_news . "</h5>
          </div>";
    
 
          
} elseif ($type == 'tournament') {
    // Query for tournament data
    $tournament_sql = "SELECT IdTournament, TournamentTitle, TournamentPlace, TournamentDate, TournamentImage, TournamentLinkDetails FROM tournament";
    $tournament_result = $connect->query($tournament_sql);

    echo "<h2>Tournament Data</h2>";
    echo "<table class='table table-striped table-dark'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Place</th>
                </tr>
            </thead>
            <tbody>";
    if ($tournament_result->num_rows > 0) {
        while ($row = $tournament_result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["IdTournament"] . "</td>
                    <td>" . $row["TournamentTitle"] . "</td>
                    <td>" . $row["TournamentDate"] . "</td>
                    <td>" . $row["TournamentPlace"] . "</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No tournament data found.</td></tr>";
    }
    echo "</tbody></table>";
    
   // Query to count total tournaments
    $count_sql = "SELECT COUNT(*) AS total_tournaments FROM tournament";
    $count_result = $connect->query($count_sql);
    $total_tournaments = 0; // Default value
    if ($count_result->num_rows > 0) {
        $count_row = $count_result->fetch_assoc();
        $total_tournaments = $count_row['total_tournaments'];
    }
    
     // Display total tournaments count
    echo "<div class='d-flex justify-content-center mt-3'>
            <h5>Total Tournaments: " . $total_tournaments . "</h5>
          </div>";
          
} elseif ($type == 'aboutus') {
    // Query for tournament data
    $aboutus_sql = "SELECT IdYoutube, YoutubeTitle, YoutubeLink FROM aboutus";
    $aboutus_result = $connect->query($aboutus_sql);

    echo "<h2>About Us Data</h2>";
    echo "<table class='table table-striped table-dark'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                </tr>
            </thead>
            <tbody>";
    if ($aboutus_result->num_rows > 0) {
        while ($row = $aboutus_result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["IdYoutube"] . "</td>
                    <td>" . $row["YoutubeTitle"] . "</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No Video data found.</td></tr>";
    }
    echo "</tbody></table>";
    
    // Query to count total aboutus videos
    $count_sql = "SELECT COUNT(*) AS total_aboutus FROM aboutus";
    $count_result = $connect->query($count_sql);
    $total_aboutus = 0; // Default value
    if ($count_result->num_rows > 0) {
        $count_row = $count_result->fetch_assoc();
        $total_aboutus = $count_row['total_aboutus'];
    }
    
    // Display total aboutus count
    echo "<div class='d-flex justify-content-center mt-3'>
            <h5>Total About Us Videos: " . $total_aboutus . "</h5>
          </div>";
}



// Close the connection
$connect->close();
