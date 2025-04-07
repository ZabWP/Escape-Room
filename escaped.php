<?php 
 $current_time = time(); 

function secondsToTime($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}

if (isset($_COOKIE['start_time'])) {
    $start_time = $_COOKIE['start_time']; 
    $time_diff = $current_time - $start_time;

    $file_path = 'leaderboard.json';
    $leaderboard = [];

    if (file_exists($file_path)) {
        $leaderboard = json_decode(file_get_contents($file_path), true);
    }
    $leaderboard[] = [
        'name' => $_COOKIE['name'],
        'time' => $time_diff  
    ];

    file_put_contents($file_path, json_encode($leaderboard, JSON_PRETTY_PRINT));
    setcookie('game_in_progress', 'false', time() + (86400 * 30), '/');

} else {
    // header("Location: newgame.php");
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
    <title>Congrats!</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Congratulations <?= htmlspecialchars($_COOKIE['name']) ?>!</h1>

        <p>You have successfully escaped the room!</p>
        <p>Your time: <?= secondsToTime($time_diff)?></p>
        <p>Seconds:  <?= htmlspecialchars($time_diff) ?></p>
        <a href="newgame.php" class="button"><button>Start New Game</button></a>

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
    </div>

</body>
</html>