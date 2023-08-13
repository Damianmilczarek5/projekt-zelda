<?php require_once 'session/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... (head content) ... -->
</head>
<body>

<header>
    <div class="site-name">
        <nav id="siteTitle"> <a  id="siteTitle" href="index.php">Zelda DB</a> </nav>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Games</a></li>
            <li><a href="collection/collection.php">My Collection</a></li>
        </ul>
    </nav>
    <div class="user-info">
    <span class="username">
            <?php if (isUserLoggedIn()) : ?>
                <?php $currentUser = getCurrentUser(); ?>
                <h2>Welcome <?php echo $currentUser['username']; ?></h2>
                <?php if (!empty($currentUser['favoriteGames'])) : ?>
                    <p>Your favorite games:</p>
                    <ul>
                        <?php foreach ($currentUser['favoriteGames'] as $favoriteGame) : ?>
                            <li><?php echo $favoriteGame; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <a href="profile/profile.php"><img id="profilePic" src="./images/profile/<?php echo $currentUser['profilePicture']; ?>" alt="User Avatar" class="avatar"></a>
            <?php endif; ?>
        </span>
    </div>
</header>
<!-- ... (rest of your HTML content) ... -->
</body>
</html>
