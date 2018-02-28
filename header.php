<?php

  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
?>

<div class="header">
    <div class="header_aside">

    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    	<p> <a href="logout.php" style="color: red;">logout</a> </p>
    <?php endif ?>

    <?php  if (!isset($_SESSION['username'])) : ?>
    <a class="header_signin_link" href="register.php">sign up</a>
    <?php endif ?> 

    </div>  
    <h1>PHP localhost</h1>
</div>