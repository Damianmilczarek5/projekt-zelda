<?php
// Include the session functions
require_once("session/session.php");

// Function to send JSON response
function sendJSON($data, $statuscode = 200) {
    header("Content-Type: application/json");
    http_response_code($statuscode);
    $json = json_encode($data);
    echo $json;
    exit();
}

// Check if the user is logged in
if (!isUserLoggedIn()) {
    $error = ["error" => "User not logged in."];
    sendJSON($error, 401);
}

// Display errors during development
ini_set("display_errors", 1);

// Define the filename for user data
$filename = "login2/data.json";

// Get the HTTP request method
$requestMethod = $_SERVER["REQUEST_METHOD"];

$users = [];

// Load user data from the data.json file
if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $users = json_decode($json, true);
}

// Check if the request method is DELETE
if ($requestMethod == "DELETE") {
    $gameId = $_GET["id"]; // Get the game ID from the query parameter
    $gameId = (int) $gameId; // Convert the game ID to an integer

    if (isset($_SESSION["user"])) {
        $userId = getCurrentUserId(); // Get the current user's ID
        
        // Find the user and remove the game from their completed games list
        foreach ($users as &$user) {
            if ($user["id"] == $userId) {
                if (isset($user["completedGames"])) {
                    $index = array_search($gameId, $user["completedGames"]);
                    if ($index !== false) {
                        array_splice($user["completedGames"], $index, 1);
                    }
                }
                break;
            }
        }
        
        // Save the updated user data to the JSON file
        file_put_contents($filename, json_encode($users, JSON_PRETTY_PRINT));
        
        sendJSON(["message" => "Game removed from completed games."]);
    } else {
        sendJSON(["error" => "User not logged in."], 401);
    }
}
?>
