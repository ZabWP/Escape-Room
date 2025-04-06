<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item']) && $_COOKIE['game_check'] === 'false') {
    $item = $_POST['item'];
    
    $inventory = isset($_COOKIE['inventory']) ? explode(',', $_COOKIE['inventory']) : [];

    if (!in_array($item, $inventory)) {
        $inventory[] = $item;
    }
    setcookie('inventory', implode(',', $inventory), time() + (86400 * 30), '/');

    $required_items = ['backpack', 'laptop', 'phone'];
    if (empty(array_diff($required_items, $inventory))) {
        setcookie('puzzle1_complete', 'true', time() + (86400 * 30), '/');
    }
}

header("Location: classroom.php");
exit;
?>