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
<body
style="
    background-image: url('assets/gsu.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
"
>
    <div class="overlay" style= "
    width: 60%;
    overflow: auto; 
    ">
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
        
        <a href="index.html" class="game-button" style="margin-top: 20px">Back to Home</a>
    </div>
</body>
</html>
