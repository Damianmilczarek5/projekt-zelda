<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>
    <?php

require_once("functions/functions.php");
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
    </div>
</div>
<!-- ... Your existing code ... -->

<div class="game-info">
    <p>Release Date: <?php echo $selectedGame["release_date"]; ?></p>
    <div class="rating">
        <p>Rating: <?php echo $selectedGame["rating"]; ?> ★</p>
        <div class="user-rating">
            <label for="rating">Rate this game:</label>
            <select id="rating" name="rating">
                <option value="1">1 star</option>
                <option value="2">2 stars</option>
                <option value="3">3 stars</option>
                <option value="4">4 stars</option>
                <option value="5">5 stars</option>
            </select>
            <button id="submit-rating">Submit</button>
        </div>
    </div>
    <p>Players: <?php echo $selectedGame["players"]; ?></p>
</div>

<script src="scripts.js"></script>
<script src="createGameIcons.js"></script>
</body>
</html>


