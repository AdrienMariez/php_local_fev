<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php';?>
    <?php include 'nav.php';?>
    <div class="body_content">
        <?php  if (isset($_SESSION['username'])) : ?>

    <div class="body_content_title">
        <h3>Events</h3>
    </div>

    <div class="body_content">
        <?php
        
            //Connexion to the database

            $servername = "localhost";
            $username = "root";
            $password = "casio";
            $dbname = "fev_php_local";
        
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 


            $sql = "SELECT * FROM event_table WHERE ending_date>='". date("Y") ."-". date("m") ."-". date("d") ."'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $datebegin = date_create($row["beginning_date"]);
                    $dateend = date_create($row["ending_date"]);
                    $datepublication = date_create($row["publication_date"]);
                    ?>
                    <div class="event_content">

                        <div class="event_title">
                            <h3><?php echo "" . $row["title"]. ""; ?></h3>
                        </div>
                        <div class="event_img">
                            <img class="event_img" src="<?php echo "" . $row["image"]. ""; ?>" alt="">
                        </div>
                        <div class="event_text">
                            <p><?php echo "" . $row["description"]. ""; ?></p>
                        </div>
                        <div class="event_place">
                            <p><?php echo "" . $row["place"]. ""; ?></p>
                        </div>
                        <div class="event_dates_container">
                            <div>
                                <p>starting date :</p>
                                <p><?php echo date_format($datebegin, 'd  m  Y'); ?></p>
                            </div>
                            <div>
                                <p>ending date :</p>
                                <p><?php echo date_format($dateend, 'd  m  Y'); ?></p>
                            </div>
                        </div>
                        <div class="event_publication_date">
                            <p><?php echo date_format($datepublication, 'd  m  Y'); ?></p>
                        </div>
                    </div>
                <?php
                }
            } else {
                echo "No events were found.";
            }
            $conn->close();
        ?>
    </div>

        <?php endif ?>


        <?php  if (!isset($_SESSION['username'])) : ?>

            <p>You need to be logged in to access this page !</p>
            <a href="login.php">Login now !</a>
            <a href="register.php">Or register right now !</a>

        <?php endif ?> 
    </div>
    <?php include 'footer.php';?>
    <script src="app.js"></script>
</body>
</html>