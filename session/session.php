<?php
session_start();

$filename = "login2/data.json";

// Check if the JSON file exists
if (!file_exists($filename)) {
    // If the JSON file doesn't exist, redirect to a maintenance page
    header("location: maintaince/maintaince.php");
    exit(); // Stop further execution
}

// Handle logout
if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header("location: login2/login.php");
    exit();
}

// Check if a user is logged in
function isUserLoggedIn() {
    return isset($_SESSION['user']);
}

// Get the current user's data
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

// Get the ID of the current user
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
