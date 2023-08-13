<?php 

require_once("functions.php");

ini_set("display_errors", 1);

$requestMethod = $_SERVER["REQUEST_METHOD"];

$filename = "game_database.json";

if ($requestMethod != "GET") {
    $error = ["Error" => "Invalid HTTP-method"];
    sendJSON($error, 405);
};

$games = [];

if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $games = json_decode($json, true);
}

if ($requestMethod == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        foreach ($games as $game) {
            if ($game["id"] == $id) {
                sendJSON($game);
            }
        }
        $error = ["error" => "Game(s) not found."];
        sendJSON($error, 404);
    }
    sendJSON($games);
}

