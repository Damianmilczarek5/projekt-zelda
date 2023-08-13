<?php
session_start();

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

 $currentUser = getCurrentUser(); 
?>
