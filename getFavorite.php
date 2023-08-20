<?php
require_once("session/session.php");

// Function to send JSON responses with an optional status code
function sendJSON($data, $statuscode = 200) {
    header("Content-Type: application/json");
    http_response_code($statuscode);
    $json = json_encode($data);
    echo $json;
    exit();
}

// Check if user is logged in, otherwise send an unauthorized response
if (!isUserLoggedIn()) {
    $error = ["error" => "User not logged in."];
    sendJSON($error, 401);
}

// Display errors during development
ini_set("display_errors", 1);

$filename = "login2/data.json";
$requestMethod = $_SERVER["REQUEST_METHOD"];

$users = [];
$favoriteGames = [];

// Load user data from the data.json file
if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $users = json_decode($json, true);
}

if ($requestMethod == "GET") {
    if (isset($_SESSION["user"])) {
        $userId = $currentUserId; // Get the current user's ID
        
        // Find the user and retrieve their favorite games list
        foreach ($users as $user) {
            if ($user["id"] == $userId) {
                $favoriteGames = $user["favoriteGames"] ?? [];
                sendJSON($favoriteGames);
            }
        }
    } else {
        sendJSON(["error" => "User not logged in."], 401);
    }
} else {
    sendJSON(["error" => "Invalid request."], 400);
}
?>
