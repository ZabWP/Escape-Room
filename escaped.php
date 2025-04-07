<?php 
 $current_time = time(); 

if (isset($_COOKIE['start_time'])) {
    $start_time = $_COOKIE['start_time']; 
   
    $time_diff = $current_time - $start_time;

    $hours = floor($time_diff / 3600);
    $minutes = floor(($time_diff % 3600) / 60);
    $seconds = $time_diff % 60;

    $formatted_time = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

} else {
    header("Location: newgame.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_time'])) {
    $name = trim($_POST['name']);
    
    if (!empty($name)) {
        $file_path = 'leaderboard.json';
        $leaderboard = [];

        if (file_exists($file_path)) {
            $leaderboard = json_decode(file_get_contents($file_path), true);
        }
        $leaderboard[] = [
            'name' => $name,
            'time' => $time_diff  
        ];

        file_put_contents($file_path, json_encode($leaderboard, JSON_PRETTY_PRINT));

        setcookie('game_in_progress', 'false', time() + (86400 * 30), '/');
        setcookie('start_time', '', time() - 3600, '/');
        header('Location: leaderboard.php');
        exit;
    } else {
        echo "Please enter a valid name.";
    }
}
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
        <h1>Congratulations!</h1>
        <p>You have successfully escaped the room!</p>
        <p>Your time: <?= htmlspecialchars($formatted_time) ?></p>
        <form method="POST">
        <label for="name">Enter your name:</label>
        <input type="text" name="name" id="name" required>
        <button type="submit" name="submit_time">Submit</button>
    </form>
    </div>

</body>
</html>