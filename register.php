<!--

"Pour la création d'un compte, l'utilisateur doit choisir un nom d'utilisateur et un mot de passe. Le nom d'utilisateut doit être unique.
OK

Il doit saisir 2 fois son mot de passe afin d'éviter toute erreur de saisie.
OK

Pour des raisons de sécurité, il doit être impossible de retrouver le mot de passe des utilisateurs dans la base de données.
OK

Bonus: La vérification de l'unicité du nom utilisateur et la vérification de la correspondance des mots de passe seront en AJAX.
NIET (OK)
"

-->

<?php include 'config/server.php';?>

<?php include 'navigation/head.php';?>

  <title>Registration</title>
</head>

<body>

  <?php include 'navigation/header.php';?>
	<?php include 'navigation/nav.php';?>


	<div class="body_content_title">
    <h3>Register</h3>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('config/errors.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
	</form>
	
	<?php include 'navigation/footer.php';?>

</body>
</html>