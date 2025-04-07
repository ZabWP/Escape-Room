<?php

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Escape Room</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <div class="overlay">
      <h1>Escape the Room</h1>
      <div class="button-container">
        <a href="story.html" class="game-button">New Game</a>
        <?php if (isset($_COOKIE['game_in_progress']) && $_COOKIE['game_in_progress'] === 'true') : ?>
          <a href="classroom.php" class="game-button">Continue Game</a>
        <?php endif; ?>
        <a href="index.html" class="game-button">Back</a>
      </div>
    </div>
  </body>
</html>
