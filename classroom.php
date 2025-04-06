<?php

$puzzle1_completed  = isset($_COOKIE['puzzle1_complete']) && $_COOKIE['puzzle1_complete'] === 'true';
$puzzle2_completed  = isset($_COOKIE['puzzle2_complete']) && $_COOKIE['puzzle2_complete'] === 'true';
$puzzle3_completed  = isset($_COOKIE['puzzle3_complete']) && $_COOKIE['puzzle3_complete'] === 'true';

$inventory = isset($_COOKIE['inventory']) ? explode(',', $_COOKIE['inventory']) : [];

$items = ['backpack', 'laptop', 'phone']; // Replace with your actual item IDs or filenames

if ($puzzle1_completed && !isset($_COOKIE['puzzle1_complete'])) {
    setcookie('puzzle1_complete', 'true', time() + 3600, '/');
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
        <div class="classroomContainer">

        
   
            <form method="POST" action="collect_item.php" class="backpackContainer" >
                <input type="hidden" name="item" value="backpack">
                <input type="image" src="assets/backpack.png" class="backpack" alt="backpack" style=" width: 20%; position: absolute; bottom: 0; right: 20%; cursor: default;">
            </form>
      

        <?php if (!in_array('laptop', $inventory)): ?>
            <form method="POST" action="collect_item.php" style="position:absolute; top:300px; left:200px;" class="laptopContainer">
                <input type="hidden" name="item" value="laptop">
                <input type="image" src="assets/laptop.png" class="laptop" alt="laptop">
            </form>
        <?php endif; ?>

        <?php if (!in_array('phone', $inventory)): ?>
            <form method="POST" action="collect_item.php" style="position:absolute; top:400px; left:350px;" class="phoneContainer">
                <input type="hidden" name="item" value="phone">
                <input type="image" src="assets/phone.png" class="phone" alt="phone">
            </form>
        <?php endif; ?>
            </div>
    </body>
</html>