
<?php require_once 'session/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://fonts.cdnfonts.com/css/the-wild-breath-of-zelda" rel="stylesheet">

</head>
<body>

<header>
    <div class="site-name">
        <nav id="siteTitle"> <a  id="siteTitle" href="index.php">Zelda DB</a> </nav>
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Games</a></li>
            <li><a href="collection.php">My Collection</a></li>
        </ul>
    </nav>
    <div class="user-info">
    <span class="username">
            <?php if (isUserLoggedIn()) : ?>
                <h2>Welcome <?php echo $currentUser['username'];?>   
       <a href="profile.php"><img id="profilePic" src="./images/profile/<?php echo $currentUser['profilePicture']; ?>" alt="User Avatar" class="avatar"></a>
</h2>
            <?php endif; ?>
        </span>
    </div>
</header>

</body>
</html>
