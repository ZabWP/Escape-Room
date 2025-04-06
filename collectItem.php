<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item'])) {
    $item = $_POST['item'];
    
    $inventory = isset($_COOKIE['inventory']) ? explode(',', $_COOKIE['inventory']) : [];

    if (!in_array($item, $inventory)) {
        $inventory[] = $item;
    }
    setcookie('inventory', implode(',', $inventory), time() + (86400 * 30), '/');
}

header("Location: classroom.php");
exit;
?>