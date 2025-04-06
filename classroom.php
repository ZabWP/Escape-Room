<?php

$puzzle1_completed  = isset($_COOKIE['puzzle1_complete']) && $_COOKIE['puzzle1_complete'] === 'true';
$puzzle2_completed  = isset($_COOKIE['puzzle2_complete']) && $_COOKIE['puzzle2_complete'] === 'true';
$puzzle3_completed  = isset($_COOKIE['puzzle3_complete']) && $_COOKIE['puzzle3_complete'] === 'true';

$inventory = isset($_COOKIE['inventory']) ? explode(',', $_COOKIE['inventory']) : [];

$items = ['image1', 'image2', 'image3']; // Replace with your actual item IDs or filenames

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

        
        <div class="backpack">
            <h3>Backpack</h3>
            <?php foreach ($inventory as $item): ?>
            <img src="images/<?= $item ?>.png" width="40">
            <?php endforeach; ?>
        </div>
        
        <?php if (!in_array('item1', $inventory)): ?>
            <form method="POST" action="collect_item.php" style="position:absolute; top:150px; left:100px;" class="backpackContainer">
                <input type="hidden" name="item" value="item1">
                <input type="image" src="assets/backpack.png" class="backpack" alt="item1">
            </form>
        <?php endif; ?>

        <?php if (!in_array('item2', $inventory)): ?>
            <form method="POST" action="collect_item.php" style="position:absolute; top:300px; left:200px;" class="laptopContainer">
                <input type="hidden" name="item" value="item2">
                <input type="image" src="assets/laptop.png" class="laptop" alt="item2">
            </form>
        <?php endif; ?>

        <?php if (!in_array('item3', $inventory)): ?>
            <form method="POST" action="collect_item.php" style="position:absolute; top:400px; left:350px;" class="phoneContainer">
                <input type="hidden" name="item" value="item3">
                <input type="image" src="assets/phone.png" class="phone" alt="item3">
            </form>
        <?php endif; ?>
            </div>
    </body>
</html>