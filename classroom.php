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

if ($_COOKIE['total_visits'] > 50) {
    setcookie('puzzle2_complete', 'true', time() + 3600, '/');
}
$count = $_COOKIE['total_visits'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['openQuiz'])) {
    if ($_COOKIE['puzzle3_complete'] === 'false') {
        setcookie('is_quiz_screen_open', 'true', time() + 3600, '/');
        if($_COOKIE['isQ1Correct'] === 'false') {
            setcookie('question', '
            (1 / 3)
            I come in pairs, but I\'m not shoes.
            I tell the browser what to use.
            I wrap around words, that\'s my gig—
            What am I?'
            , time() + 3600, '/');
        } 
         header("Location: " . $_SERVER['REQUEST_URI']);

    } 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitAnswer'])) {
    $userAnswer = strtolower(trim($_POST['answer'])); 

    if($_COOKIE['isQ1Correct'] === 'false' ) {
        if ($userAnswer === "tag" || $userAnswer === "a tag" || $userAnswer === "tags") {
            setcookie('isQ1Correct', 'true', time() + 3600, '/');
            setcookie('question', '
            (2 / 3)
            I live in a box with margin and padding,
            With content inside, I\'m rarely lacking.
            I help you structure all you see,
            What HTML element could I be?'
            , time() + 3600, '/');
            setcookie('isWrongMessage','', time() + 3600, '/');

        } else {
            setcookie('isWrongMessage','Wrong answer. Try again!', time() + 3600, '/');
        }
    }
    if($_COOKIE['isQ2Correct'] === 'false' && $_COOKIE['isQ1Correct'] === 'true') {
        if ($userAnswer === "div" || $userAnswer === "div tag" || $userAnswer === "divs" || $userAnswer === "<div>") {
            setcookie('isQ2Correct', 'true', time() + 3600, '/'); 
            setcookie('question', '
            (3 / 3)
            I take you places far or near,
            Click on me and you\'ll disappear.
            Blue and underlined, I\'m the key—
            What HTML tag could I be?'
            , time() + 3600, '/');
            setcookie('isWrongMessage','', time() + 3600, '/');

        } else {
            setcookie('isWrongMessage','Wrong answer. Try again!', time() + 3600, '/');

        }
    }
    if($_COOKIE['isQ3Correct'] === 'false' && $_COOKIE['isQ2Correct'] === 'true') {
        if ($userAnswer === "link" || $userAnswer === "a link" || $userAnswer === "links" || $userAnswer === "<a>" || $userAnswer === "anchor" || $userAnswer === "anchor tag" || $userAnswer === "anchor tags" || $userAnswer === "a") {
            setcookie('isQ3Correct', 'true', time() + 3600, '/'); 
            setcookie('question', 'Thats correct! Quiz Completed!', time() + 3600, '/'); 
            setcookie('isWrongMessage','', time() + 3600, '/');
            setcookie('puzzle3_complete', 'true', time() + 3600, '/');
        } else {
            setcookie('isWrongMessage','Wrong answer. Try again!', time() + 3600, '/');
        }
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['closeQuizScreen'])) {
    setcookie('is_quiz_screen_open', 'false', time() + 3600, '/');
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

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
        setcookie('game_message', 'It\'s too early to leave right now', time() + 3600, '/');
        header("Location: " . $_SERVER['REQUEST_URI']);
    } else {
        header("Location: escaped.php");
    }

}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Escape the Classroom</title>
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
                    background-color: rgba(255, 255, 255, 0.89);
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
                <h2><?= htmlspecialchars($_COOKIE['game_message']) ?></h2>
                <form method="POST">
                    <button type="submit" name="dismissGameMessage">OK</button>
                </form>
            </div>
        <?php endif; ?>

        <?php if ($_COOKIE['is_quiz_screen_open'] === 'true'): ?>
            <div class="quizScreen"
                style="
                    position: absolute;
                    top: 40%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    width: 30%;
                    height: 200px;
                    background-color: rgb(255, 255, 255);
                    border-radius: 10px;
                    padding: 20px;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                    z-index: 100;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: space-between;
                "
            >

                <h3><?= htmlspecialchars($_COOKIE['question']) ?></h3>
                <?php if ($_COOKIE['isWrongMessage'] !== ''): ?>
                    <p style="color: red;"><?= htmlspecialchars($_COOKIE['isWrongMessage']) ?></p>
                <?php endif; ?>

                <?php if($_COOKIE['puzzle3_complete'] !== 'true'): ?>
                    <form method="POST">
                        <input type="text" name="answer" placeholder="Your answer here">
                        <button type="submit" name="submitAnswer">Submit</button>
                    </form>
                <?php endif; ?>

                <form method="POST" >
                    <button type="submit" name="closeQuizScreen">Close</button>
                </form>
            
            </div>
        <?php endif; ?>
    
        <div class="background" ></div>
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
                <?php if($_COOKIE['puzzle3_complete'] === 'false'): ?>
                    <button type="submit" name="openQuiz" 
                    style ="
                        width: 100%;
                        height: 100%;
                        background-color: transparent;
                        border: none;
                        cursor: pointer;
                        text-align: center;
                    ">
                    <p style ="
                        font-size: 15px;
                        padding: 5px 5px;
                        border-radius: 10px;
                        background-color: rgb(252, 153, 153);
                    ">
                        Take Quiz
                    </p>
                </button>
                <?php endif; ?>
                <?php if($_COOKIE['puzzle3_complete'] === 'true'): ?>
                    <div name="openQuiz" 
                    style ="
                        width: 100%;
                        height: 100%;
                        background-color: transparent;
                        border: none;
                        text-align: center;
                    ">
                    <p style ="
                        font-size: 15px;
                        margin-top 20px;
                        padding: 5px 5px;
                        border-radius: 10px;
                        background-color: aquamarine;
                    ">
                        Quiz Completed!
                    </p>
                </div>
                <?php endif; ?>
            </form>


            <form class="rightExit" method="POST" >
                <button type="submit" name="checkCompletion" class="ExitButton"></button>
            </form>

            <form class="leftExit" method="POST" >
                <button type="submit" name="checkCompletion" class="ExitButton"></button>
            </form>
            
            <div class="progressbarR">
                <div class="progress" style="width: <?php echo $count * 2; ?>%"></div>
            </div>
            <div class="progressbarL">
                <div class="progress" style="width: <?php echo $count * 2; ?>%"></div>
            </div>
        </div>
    </body>
</html>