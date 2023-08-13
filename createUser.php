<?php

ini_set("display_errors", 1);

require_once("../functions/functions.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];

$filename = "users.json";

$requestJSON = file_get_contents("php://input");
$requestData = json_decode($requestJSON, true);

if (!file_exists($filename)) {
    $error = ["error" => "No users.json file exists."];
    sendJSON($error, );
    exit();
}

$users = [];

if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $users = json_decode($json, true);
}


if ($requestMethod != "POST") {
    $error = ["error" => "Invalid HTTP-method."];
    sendJSON($error, 405);
    exit();
}

if ($requestMethod == "POST") {
    if (!isset($requestData["username"], $requestData["password"])) {
        $error = ["error" => "Bad Request (missed field)."];
        sendJSON($error, 400);
    }

    if ($requestData["username"] == "" or $requestData["password"] == "") {
        $error = ["error" => "Bad Request (empty data)."];
        sendJSON($error, 400);
        exit();
    }

    
    // CHECK IF USERNAME IS TAKEN

    foreach ((array)$users as $user) {
        if ($user["username"] == $requestData["username"]) {
            $error = ["error" => "Username is taken"];
        sendJSON($error, );
        exit();
        }
    }

    $username = $requestData["username"];
    $password = $requestData["password"];

    $highestId = 0;

    foreach ((array)$users as $user) {
        if ($user["id"] > $highestId) {
            $highestId = $user["id"];
        }
    }

    $nextId = $highestId + 1;

    $newUser = ["id" => $nextId, "username" => $username, "password" => $password, "profilePicture" => "", "favoriteGames" => [], "completedGames" => [], "ratedGames" => []];
    $users[] = $newUser;

    $json = json_encode($users, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);

    sendJSON($newUser);


}


?>