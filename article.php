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
        <p>article.php content</p>

        <?php

            $servername = "localhost";
            $username = "root";
            $password = "casio";
            $dbname = "fev_php_local";

            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            //get the id from the link in the blog page
            if(isset($_GET['id'])) {


                $sql = "SELECT * FROM blog_table WHERE id = ".$_GET['id'];

                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        $datepublication = date_create($row["date"]);
                        ?>
                        <form method="post" action="">
                                <div class="blog_content">
                                    <div class="blog_img_container">
                                        <img class="blog_img" src="<?php echo $row["image"]; ?>" alt="">
                                    </div>
                                    <div class="blog_text_container">
                                        <h3><?php echo $row["titre"]; ?></h3>
                                        <p><?php echo $row["texte"]; ?></p>
                                        <p class="blog_dates"><?php echo date_format($datepublication, 'd  m  Y'); ?></p>
                                    </div>
                                </div>
                        </form>
                    <?php
                    }
                } else {
                    echo "No blog pages were found.";
                }
                $conn->close();
            }
            
?>

    </div>
    <?php include 'footer.php'; ?>
    <script src="app.js"></script>
</body>
</html>