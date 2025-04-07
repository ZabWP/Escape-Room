<?php
    setcookie('name', '', time() + (86400 * 30), '/');
    setcookie('game_in_progress', 'true', time() + (86400 * 30), '/');
    setcookie('start_time', time(), time() + (86400 * 30), '/');

    setcookie('inventory', json_encode([]), time() + (86400 * 30), '/');
    setcookie('puzzle1_complete', 'false', time() + (86400 * 30), '/');

    setcookie('total_visits', 1, time() + (86400 * 30), '/');
    setcookie('puzzle2_complete', 'false', time() + (86400 * 30), '/');

    setcookie('puzzle3_complete', 'false', time() + (86400 * 30), '/');
    setcookie('is_quiz_screen_open', 'false', time() + (86400 * 30), '/');
    setcookie('question', '', time() + (86400 * 30), '/');
    setcookie('isWrongMessage', '', time() + (86400 * 30), '/');
    setcookie('isQ1Correct', 'false', time() + (86400 * 30), '/');
    setcookie('isQ2Correct', 'false', time() + (86400 * 30), '/');
    setcookie('isQ3Correct', 'false', time() + (86400 * 30), '/');
   

    setcookie('game_check', 'false', time() + (86400 * 30), '/');
    setcookie('game_message', '', time() + (86400 * 30), '/');

header("Location: classroom.php");
exit();
?>