<?php include('config/server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <?php include 'navigation/header.php';?>
		<?php include 'navigation/nav.php';?>
	
	<div class="body_content_title">
    <h3>Login</h3>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('config/errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
	</form>
	
	<?php include 'navigation/footer.php';?>

</body>
</html>