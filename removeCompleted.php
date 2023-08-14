<?php
require_once("session/session.php");

function sendJSON($data, $statuscode = 200) {
    header("Content-Type: application/json");
    http_response_code($statuscode);
    $json = json_encode($data);
    echo $json;
    exit();
}

if (!isUserLoggedIn()) {
    $error = ["error" => "User not logged in."];
    sendJSON($error, 401);
}

ini_set("display_errors", 1);

$filename = "login2/data.json";
$requestMethod = $_SERVER["REQUEST_METHOD"];

$users = [];

if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $users = json_decode($json, true);
}

if ($requestMethod == "DELETE") {
    $gameId = $_GET["id"]; // Get the game ID from the query parameter
    $gameId = (int) $gameId; // Convert the game ID to an integer

    if (isset($_SESSION["user"])) {
        $userId = getCurrentUserId(); // Get the current user's ID
        
        // Find the user and remove the game from their favorite games list
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
        
        sendJSON(["message" => "Game removed from favorite games."]);
    } else {
        sendJSON(["error" => "User not logged in."], 401);
    }
}
?>
