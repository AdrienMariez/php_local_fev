<!--Page for all blog posts clicked on
"La page article de blog affiche le contenu complet d'un billet."
OK
-->

<?php include 'config/session.php';?>

<?php include 'config/bdd.php';?>

<?php include 'navigation/head.php';?>

    <title>Article</title>
</head>
<body>
    <?php include 'navigation/header.php';?>
    <?php include 'navigation/nav.php';?>
    <div class="body_content">
        <p>article.php content</p>

        <?php

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
    <?php include 'navigation/footer.php'; ?>
    <script src="app.js"></script>
</body>
</html>