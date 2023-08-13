<?php 

require_once("functions.php");

ini_set("display_errors", 1);

$requestMethod = $_SERVER["REQUEST_METHOD"];

$filename = "users.json";

if ($requestMethod != "GET") {
    $error = ["Error" => "Invalid HTTP-method"];
    sendJSON($error, 405);
};

$users = [];

if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $users = json_decode($json, true);
}

if ($requestMethod == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        foreach ($users as $user) {
            if ($user["id"] == $id) {
                sendJSON($user);
            }
        }
        $error = ["error" => "user(s) not found."];
        sendJSON($error, 404);
    }
    sendJSON($users);
}

