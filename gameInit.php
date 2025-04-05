<?php
// Sets up the initial cookies on new game start. 
if ( !isset($_COOKIE['start_time']) ) {
    setcookie('start_time', time(), time() + (86400 * 30), '/');

    setcookie('inventory', json_encode([]), time() + (86400 * 30), '/');
    setcookie('puzzle1_complete', 'false', time() + (86400 * 30), '/');

    setcookie('total_visits', 1, time() + (86400 * 30), '/');
    setcookie('puzzle2_complete', 'false', time() + (86400 * 30), '/');

    setcookie('puzzle3_complete', 'false', time() + (86400 * 30), '/');
} 

header("Location: /classroom.php");
exit();
?>