<?php

if(!isset($_COOKIE['game_in_progress'])) {
    header("Location: gameInit.php");
    exit();
}
if (isset($_COOKIE['game_in_progress']) && $_COOKIE['game_in_progress'] === 'false') {
    header("Location: gameInit.php");
    exit();
}
if (isset($_COOKIE['game_in_progress']) && $_COOKIE['game_in_progress'] === 'true') {
    setcookie('total_visits', $_COOKIE['total_visits'] + 1, time() + (86400 * 30), '/');
}
if(!isset($_COOKIE['start_time'])) {
    header("Location: gameInit.php");
    exit();
}

$puzzle1_completed  = isset($_COOKIE['puzzle1_complete']) && $_COOKIE['puzzle1_complete'] === 'true';
$puzzle2_completed  = isset($_COOKIE['puzzle2_complete']) && $_COOKIE['puzzle2_complete'] === 'true';
$puzzle3_completed  = isset($_COOKIE['puzzle3_complete']) && $_COOKIE['puzzle3_complete'] === 'true';

$inventory = isset($_COOKIE['inventory']) ? explode(',', $_COOKIE['inventory']) : [];

$items = ['backpack', 'laptop', 'phone']; 




?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Classroom</title>
        <link rel="stylesheet" href="classroom.css">
    </head>
    <body>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dismiss_puzzle1_message'])) {
            setcookie('puzzle1_message', 'false', time() + 3600, '/');
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        }
        ?>

        <?php if (
            isset($_COOKIE['puzzle1_complete']) && $_COOKIE['puzzle1_complete'] === 'false' &&
            isset($_COOKIE['puzzle1_message']) && $_COOKIE['puzzle1_message'] === 'true'
        ): ?>
            <div class="puzzle1-message">
                <p>You can't leave without your stuff!</p>
                <form method="POST">
                    <button type="submit" name="dismiss_puzzle1_message">OK</button>
                </form>
            </div>
        <?php endif; ?>


        <div class="classroomContainer">

            <?php if (!in_array('backpack', $inventory)): ?>
                <form method="POST" action="collectItem.php" class="backpackContainer" >
                    <input type="hidden" name="item" value="backpack">
                    <input type="image" src="assets/backpack.png" class="backpack" alt="backpack" style=" width: 31%; position: absolute; bottom: 0; right: 0%; cursor: default;">
                </form>
            <?php endif; ?>

            <?php if (!in_array('laptop', $inventory)): ?>
                <form method="POST" action="collectItem.php" style="position:absolute; top:300px; left:200px;" class="laptopContainer">
                    <input type="hidden" name="item" value="laptop">
                    <input type="image" src="assets/laptop.png" class="laptop" alt="laptop">
                </form>
            <?php endif; ?>

            <?php if (!in_array('phone', $inventory)): ?>
                <form method="POST" action="collectItem.php" style="position:absolute; top:400px; left:350px;" class="phoneContainer">
                    <input type="hidden" name="item" value="phone">
                    <input type="image" src="assets/phone.png" class="phone" alt="phone">
                </form>
            <?php endif; ?>

            <div class="rightExit">
                
            </div>

            <div class="leftExit">
                
                </div>
        </div>
    </body>
</html>