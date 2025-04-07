<?php
$file_path = 'leaderboard.json';
$leaderboard = [];

if (file_exists($file_path)) {
    $leaderboard = json_decode(file_get_contents($file_path), true);
}

function secondsToTime($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}


usort($leaderboard, function ($a, $b) {
    return $a['time'] - $b['time']; 
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Leaderboard</h1>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rank = 1;
                foreach ($leaderboard as $entry) {
                    // Convert the time from seconds to HH:MM:SS format
                    $formatted_time = secondsToTime($entry['time']);
                    echo "<tr>
                            <td>{$rank}</td>
                            <td>{$entry['name']}</td>
                            <td>{$formatted_time}</td>
                        </tr>";
                    $rank++;
                }
                ?>
            </tbody>
        </table>

        <a href="newgame.php" class="button"><button>Start New Game</button></a>
    </div>
</body>
</html>
