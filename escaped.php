<?php 
 $current_time = time(); 


if($_COOKIE['puzzle1_complete'] === 'false' || $_COOKIE['puzzle2_complete'] === 'false' || $_COOKIE['puzzle3_complete'] === 'false'|| $_COOKIE['game_in_progress'] === 'false' ) {
    header("Location: index.html");
    exit();
}

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
<body style="
    background-image: url('assets/line.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
"
>
    <div class="overlay">
        <h1 class="escapedh1">You did it <?= htmlspecialchars($_COOKIE['name']) ?>!</h1>

        <p>You made it to the cafeteria! But did you make it in time? 👀</p>
        <p>Your time: <?= secondsToTime($time_diff)?></p>
        <a href="newgame.php" class="game-button">Start New Game</a>
        <a href="index.html" class="game-button">Home</a>
        

        <h1>Leaderboard</h1>
        <table style="
        width: 100%; border-collapse: collapse;
        background-color: #f2f2f2;
        color: black;
        border-radius: 10px;
        ">
            <thead>
                <tr>
                    <th style="
                    width: 15%;
                    background-color:#ff3c38;
                    border-top-left-radius: 10px;
                    ">Rank</th>
                    <th style="
                    width: 35%;
                    background-color:#ff3c38;

                    ">Name</th>
                    <th style="width: 35%;
                    background-color:#ff3c38;
                    border-top-right-radius: 10px;
                    
                    ">Time</th>
                </tr>
                </tr>
            </thead>
            <tbody>
                <?php
                $top_20 = array_slice($leaderboard, 0, 20);
                $rank = 1;
                foreach ($top_20 as $entry) {
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