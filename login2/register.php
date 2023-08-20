<?php require("register.class.php") ?>
<?php
	if(isset($_POST['submit'])){
		$user = new RegisterUser($_POST['username'], $_POST['password']);

		if ($user->success === "Your registration was successful") {
			echo '<script>window.location.href = "login.php";</script>';
			exit();
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <link rel="stylesheet" href="styles.css">
	<title>Register form</title>
</head>	
<body>


<div></div>
	<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
		<h2>Register form</h2>
		<h4>Both fields are <span>required</span></h4>

		<label>Username</label>
		<input type="text" name="username">

		<label for="password">Password:</label>
<input type="password" id="password" name="password">
<div class="password-toggle">
    <label for="togglePassword">Show Password</label>
</div>
<span class="error"><?php echo $error; ?></span>

		<button type="submit" name="submit">Register</button>

		

		<p class="error"><?php echo @$user->error ?></p>
		<p class="success"><?php echo @$user->success ?></p>
		<p>Already registered? <a href="login.php">Click here to log in</a></p>
	</form>

	<script src="register.js"></script>

</body>
</html>