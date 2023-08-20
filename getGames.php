<?php
require_once("functions/functions.php");

// Display errors during development
ini_set("display_errors", 1);

// Get the HTTP request method
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Define allowed HTTP methods
$allowedMethods = ["GET"];

// Define the filename for the game database
$filename = "game_database.json";

// Check if the request method is allowed
if (!in_array($requestMethod, $allowedMethods)) {
    $error = ["Error" => "Invalid HTTP-method"];
    sendJSON($error, 405);
}

$games = [];

// Load game data from the game_database.json file
if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $games = json_decode($json, true);
}

if ($requestMethod == "GET") {
    if (empty($games)) {
        sendJSON([], 200);
    }

    // Send the game data as a JSON response
    sendJSON($games);
}
?>
