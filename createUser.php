<?php

// Display errors during development
ini_set("display_errors", 1);

// Include necessary functions or dependencies
require_once("../functions/functions.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];

$filename = "users.json";

// Retrieve JSON data from the request
$requestJSON = file_get_contents("php://input");
$requestData = json_decode($requestJSON, true);

// Check if users.json file exists
if (!file_exists($filename)) {
      // If the JSON file doesn't exist, redirect to a maintenance page
      header("location: maintaince/maintaince.php");
      exit(); // Stop further execution
}

$users = [];

// Load user data from users.json file
if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $users = json_decode($json, true);
}

// Check if the HTTP method is not POST
if ($requestMethod != "POST") {
    $error = ["error" => "Invalid HTTP-method."];
    sendJSON($error, 405);
    exit();
}

// Handle POST request
if ($requestMethod == "POST") {
    // Check if required fields are provided in the request
    if (!isset($requestData["username"], $requestData["password"])) {
        $error = ["error" => "Bad Request (missed field)."];
        sendJSON($error, 400);
    }

    // Check for empty data
    if ($requestData["username"] == "" or $requestData["password"] == "") {
        $error = ["error" => "Bad Request (empty data)."];
        sendJSON($error, 400);
        exit();
    }

    // Check if username is already taken
    foreach ((array)$users as $user) {
        if ($user["username"] == $requestData["username"]) {
            $error = ["error" => "Username is taken"];
            sendJSON($error,);
            exit();
        }
    }

    // Prepare data for the new user
    $username = $requestData["username"];
    $password = $requestData["password"];

    // Find the highest ID to assign the next ID
    $highestId = 0;
    foreach ((array)$users as $user) {
        if ($user["id"] > $highestId) {
            $highestId = $user["id"];
        }
    }
    $nextId = $highestId + 1;

    // Create a new user object
    $newUser = [
        "id" => $nextId,
        "username" => $username,
        "password" => $password,
        "profilePicture" => "",
        "favoriteGames" => [],
        "completedGames" => [],
        "ratedGames" => []
    ];

    // Add the new user to the users array
    $users[] = $newUser;

    // Save the updated user data to the users.json file
    $json = json_encode($users, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);

    // Send JSON response with the new user data
    sendJSON($newUser);
}

?>
