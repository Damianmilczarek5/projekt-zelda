<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <title>Document</title>
</head>
<body>
    <?php

require_once("functions/functions.php");
require_once("session/session.php");
ini_set("display_errors", 1);

$filename = "game_database.json";
$games = [];

if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $games = json_decode($json, true);
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    $selectedGame = null;
    foreach ($games as $game) {
        if ($game["id"] == $id) {
            $selectedGame = $game;
            break;
        }
    }

    if ($selectedGame) {
        include 'header.php';
        ?>
<?php
    } else {
        $error = ["error" => "Game not found."];
        sendJSON($error, 404);
    }
} else {
    $error = ["error" => "Invalid request."];
    sendJSON($error, 400);
}
?>  

<div class="game-details">
    
    <img src="<?php echo $selectedGame["image"]; ?>" alt="<?php echo $selectedGame["name"]; ?>" class="game-image">
    <div class="game-description">
        <h2><?php echo $selectedGame["name"]; ?></h2>
        <h3>Description</h3>
        <p><?php echo $selectedGame["description"]; ?></p>

        <p>Release Date: <?php echo $selectedGame["release_date"]; ?></p>
    <?php if (in_array($selectedGame["id"], $currentUser["completedGames"])) { ?>
        <button id="removeCompleted" data-game-id="<?php echo $selectedGame["id"]; ?>">Remove from Completed Games</button>
    <?php } else { ?>
        <button id="addCompletedGame" data-game-id="<?php echo $selectedGame["id"]; ?>">Add to Completed Games</button>
    <?php } ?>

    <?php if (in_array($selectedGame["id"], $currentUser["favoriteGames"])) { ?>
        <button id="removeFavoriteGame" data-game-id="<?php echo $selectedGame["id"]; ?>">Remove from Favorite Games</button>
    <?php } else { ?>
        <button id="addFavoriteGame" data-game-id="<?php echo $selectedGame["id"]; ?>">Add to Favorite Games</button>
    <?php } ?>

    </div>
</div>

<div class="game-info">
    <p>Release Date: <?php echo $selectedGame["release_date"]; ?></p>
    </div>
</div>

<script src="scripts.js"></script>
</body>
</html>


