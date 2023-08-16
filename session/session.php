<?php
session_start();

if(isset($_GET['logout'])){
    unset($_SESSION['user']);
    header("location: login2/login.php");	exit();
}

function isUserLoggedIn() {
    return isset($_SESSION['user']);
}



function getCurrentUser() {
    if (isUserLoggedIn()) {
        $username = $_SESSION['user'];
        $jsonData = file_get_contents('login2/data.json');
        $data = json_decode($jsonData, true);

        foreach ($data as $user) {
            if ($user['username'] === $username) {
                return $user;
            }
        }
    }

    return null;
}

function getCurrentUserId() {
    if (isUserLoggedIn()) {
        $username = $_SESSION['user'];
        $jsonData = file_get_contents('login2/data.json');
        $data = json_decode($jsonData, true);

        foreach ($data as $user) {
            if ($user['username'] === $username) {
                $cUId = $user["id"]; 
                return $cUId;
            }
        }
    }

    return null;
}

$currentUser = getCurrentUser();
$currentUserId = getCurrentUserId();
?>
