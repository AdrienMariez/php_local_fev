<?php include 'config/bdd.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navigation/header.php';?>
    <?php include 'navigation/nav.php';?>
    <div class="body_content">
        <div class="body_content_title">
            <h3>Blog</h3>
        </div>

    <form method="post" action="" class="blog_select">
        <select name="select">
            <option value="croissant">croissant</option>
            <option value="decroissant">decroissant</option>
        </select> 
        <input type="submit" value="Submit">
    </form>

        <?php

            if(!isset($_POST['select'])) {
                $sql = "SELECT * FROM blog_table";    
            }
            if(isset($_POST['select'])) {
                $tri = $_POST['select'];       
                if($tri == "croissant"){
                    $sql = "SELECT * FROM blog_table ORDER BY date ASC"; 
                }     
                else{
                    $sql = "SELECT * FROM blog_table ORDER BY date DESC"; 
                }
            }  

            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $datepublication = date_create($row["date"]);
                    ?>
                
                    <a href="article.php?id=<?php echo $row["id"]; ?>">
                        <div class="blog_content">
                            <div class="blog_img_container">
                                <img class="blog_img" src="<?php echo $row["image"]; ?>" alt="">
                            </div>
                            <div class="blog_text_container">
                                <h3><?php echo $row["titre"]; ?></h3>
                                <h6><?php echo $row["intro"]; ?></h6>
                                <p class="blog_dates"><?php echo date_format($datepublication, 'd  m  Y'); ?></p>
                            </div>
                        </div>
                    </a>
                <?php
                }
            } else {
                echo "No blog pages were found.";
            }
            $conn->close();
        ?>
    </div>

    <?php

    
    include 'navigation/footer.php';?>
    <script src="app.js"></script>
</body>
</html>