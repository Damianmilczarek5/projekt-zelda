<?php
require_once("session/session.php");

// Function to send JSON response with given status code
function sendJSON($data, $statuscode = 200) {
    header("Content-Type: application/json");
    http_response_code($statuscode);
    $json = json_encode($data);
    echo $json;
    exit();
}

// Check if the user is logged in, otherwise send an error response
if (!isUserLoggedIn()) {
    $error = ["error" => "User not logged in."];
    sendJSON($error, 401);
}

// Display errors during development
ini_set("display_errors", 1);

$filename = "login2/data.json";
$requestMethod = $_SERVER["REQUEST_METHOD"];

$users = [];

// Load user data from JSON file
if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $users = json_decode($json, true);
}

if ($requestMethod == "PUT") {
    $gameId = $_GET["id"]; // Get the game ID from the query parameter
    $gameId = (int) $gameId; // Convert the game ID to an integer

    // Check if the user is logged in
    if (isset($_SESSION["user"])) {
        $userId = getCurrentUserId(); // Get the current user's ID
        
        // Find the user and update their favorite games list
        foreach ($users as &$user) {
            if ($user["id"] == $userId) {
                if (!isset($user["favoriteGames"])) {
                    $user["favoriteGames"] = [];
                }
                
                // Add the game to the user's favorite games list if not already present
                if (!in_array($gameId, $user["favoriteGames"])) {
                    $user["favoriteGames"][] = $gameId;
                }
                break;
            }
        }
        
        // Save the updated user data to the JSON file
        file_put_contents($filename, json_encode($users, JSON_PRETTY_PRINT));
        
        sendJSON(["message" => "Game added to favorite games."]);
    } else {
        sendJSON(["error" => "User not logged in."], 401);
    }
}
?>
