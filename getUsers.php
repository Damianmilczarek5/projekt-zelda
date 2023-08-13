<?php

require_once("functions.php");

ini_set("display_errors", 1);

$requestMethod = $_SERVER["REQUEST_METHOD"];
$allowedMethods = ["GET"];

$filename = "users.json";

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
    if (empty($games)) {
        sendJSON([], 200);
    }

    sendJSON($games);
}

?>