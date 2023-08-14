<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("location: login.php");	exit();
	}

    if (isset($_SESSION['profilePicture'])) {
        $userAvatar = $_SESSION['profilePicture'];
    }

    if (isset($_SESSION['favoriteGames'])) {
        $favoriteGames = $_SESSION['favoriteGames'];
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Game Library</title>
    <link href="https://fonts.cdnfonts.com/css/the-wild-breath-of-zelda" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<?php include 'header.php'; ?>
<h1 class="page-title">All Games</h1>
<div id="gameList">

    <!-- Games will be dynamically added here -->
</div>



<script src="scripts.js"></script>
</body>
</html>
