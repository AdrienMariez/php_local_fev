  <?php

    session_start();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    //disconnects the user
    session_destroy();
    //resets all 
    $_SESSION = "";
    header('refresh:3; http://bacasable.dev/index.php');
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Logout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navigation/header.php';?>
    <?php include 'navigation/nav.php';?>
    <div class="body_content">


        <p>You log out successfully. You will be redirected shortly...</p>


    </div>
    <?php include 'navigation/footer.php';?>
    <script src="app.js"></script>
</body>
</html>