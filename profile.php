<?php require_once("session/session.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/styles.css">

    <title>Document</title>
</head>
<body>
<?php include("header.php");?>

    <div id="container">
    <div id="user-info">
    <a href="profile.php"><img id="profile-picture" src="./images/profile/<?php echo $currentUser['profilePicture']; ?>" alt="User Avatar" class="avatar"></a>
<div id="username-container">
        <p id="username" ><?php echo $currentUser["username"]; ?></p>
         <a id="logOut" href="?logout">Log out</a>	
         </div>  
</div>         


    
<div id="favorite-games"></div>


</div>
<script src="favoriteGames.js"></script>
<script src="scripts.js"></script>

</body>
</html>