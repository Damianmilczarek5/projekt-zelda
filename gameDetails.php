<?php
// Include necessary files and configurations for your data retrieval
require_once("session/session.php");

// Retrieve the game ID from the query parameter
$gameId = $_GET["id"];

// Example: Load the games data from a JSON file
$gamesData = file_get_contents('game_database.json'); // Replace with your data source

$games = json_decode($gamesData, true);

// Find the game with the specified ID
$gameDetails = null;
foreach ($games as $game) {
    if ($game['id'] == $gameId) {
        $gameDetails = $game;
        break;
    }
}

// Check if the game details were found
if ($gameDetails !== null) {
    // Send the game details as a JSON response
    sendJSON($gameDetails);
} else {
    // Game details not found
    sendJSON(["error" => "Game details not found."], 404);
}

// Function to send JSON response
function sendJSON($data, $statuscode = 200) {
    header("Content-Type: application/json");
    http_response_code($statuscode);
    $json = json_encode($data);
    echo $json;
    exit();
}
?>
