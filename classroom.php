<?php

if(!isset($_COOKIE['game_in_progress'])) {
    header("Location: newgame.php");
    exit();
}
if (isset($_COOKIE['game_in_progress']) && $_COOKIE['game_in_progress'] === 'false') {
    header("Location: newgame.php");
    exit();
}
if (isset($_COOKIE['game_in_progress']) && $_COOKIE['game_in_progress'] === 'true') {
    setcookie('total_visits', $_COOKIE['total_visits'] + 1, time() + (86400 * 30), '/');
}
if(!isset($_COOKIE['start_time'])) {
    header("Location: newgame.php");
    exit();
}
setcookie('game_message', '', time() + 3600, '/');


$inventory = isset($_COOKIE['inventory']) ? explode(',', $_COOKIE['inventory']) : [];

$items = ['backpack', 'laptop', 'phone']; 



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dismissGameMessage'])) {
    setcookie('game_message', '', time() + 3600, '/');
    setcookie('game_check', 'false', time() + 3600, '/');
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkCompletion'])) {
    
    setcookie('game_check', 'true', time() + 3600, '/');

    if ($_COOKIE['puzzle3_complete'] === 'false') {
        setcookie('game_message', 'You need to finish the quiz first!', time() + 3600, '/');
        header("Location: " . $_SERVER['REQUEST_URI']);
    } elseif ($_COOKIE['puzzle1_complete'] === 'false') {
        setcookie('game_message', 'You can\'t leave without your stuff!', time() + 3600, '/');
        header("Location: " . $_SERVER['REQUEST_URI']);
    } elseif ($_COOKIE['puzzle2_complete'] === 'false') {
        setcookie('game_message', 'It\'s not time to leave yet', time() + 3600, '/');
        header("Location: " . $_SERVER['REQUEST_URI']);
    } 

}
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
       
  
        <?php if ($_COOKIE['game_check'] === 'true' && isset($_COOKIE['game_message'])): ?>
            <div class="gameMessage"
                style ="
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    width: 20%;
                    height: 200px;
                    background-color: rgba(255, 255, 255, 0.8);
                    border-radius: 10px;
                    padding: 20px;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                    z-index: 100;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    font-size: 20px;
                "
            >
                <p><?= htmlspecialchars($_COOKIE['game_message']) ?></p>
                <form method="POST">
                    <button type="submit" name="dismissGameMessage">OK</button>
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

            <form class="puzzle3Screen" method="POST">
                <button type="submit" name="openQuiz" class="screenButton">
                    <p>
                    Take Quiz
                    </p>
                </button>
            </form>


            <form class="rightExit" method="POST" >
                <button type="submit" name="checkCompletion" class="ExitButton"></button>
            </form>

            <form class="leftExit" method="POST" >
                <button type="submit" name="checkCompletion" class="ExitButton"></button>
            </form>
            
           
        </div>
    </body>
</html>