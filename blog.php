<!--
    -Page for all the blog-

"La page blog liste par ordre décroissant date de publication tous les billets de blog présent en base de donnée.
OK

Un article de blog contient :

    Un titre
    Une image
    Un texte d'intro
    Le texte complet
    Une date de publication
OK

La liste affiche pour chaque billet de blog le titre, l'image, le texte d'intro et la date du publication. Au clic sur un billet de blog amène sur l'article complet Article de blog.
OK

Bonus: L'utilisateur doit pourvoir changer l'ordre d'affichage des billets de blog (croissant ou décroissant sur la date de publication).
OK

Bonus: Ajouter un pager pour afficher que 5 articles par page
OK"

Les utilisateurs connectés pourront écrire de nouveaux articles de blogs et modifier les articles dont ils sont les auteurs.

-->

<?php include 'config/session.php';?>

<?php include 'config/bdd.php';

    if(!empty($_POST['select_blog'])){
        $tri_blog = $_POST['select_blog'];
        $_SESSION['tri_blog'] = $tri_blog;
    }else{
        if(!isset($_SESSION['tri_blog'])){
            $tri_blog = "croissant";
        }else{
            $tri_blog = $_SESSION['tri_blog'];
        }
    }

include 'navigation/head.php';?>

    <title>blog</title>
</head>
<body>
    <?php include 'navigation/header.php';?>
    <?php include 'navigation/nav.php';?>
    <div class="body_content">
        <div class="body_content_title">
            <h3>Blog</h3>
        </div>

    <form method="post" action="" class="blog_select">
        <select name="select_blog">
            <option <?php if($tri_blog == "croissant") {echo "selected='selected'";} ?> value="croissant">croissant</option>
            <option <?php if($tri_blog == "decroissant") {echo "selected='selected'";} ?> value="decroissant">decroissant</option>
        </select> 
        <input type="submit" value="Submit">
    </form>


    <?php

    // how many rows are in the table 
    $sql = "SELECT COUNT(*) FROM blog_table";

    include 'config/paginator.php';

    if(!isset($tri_blog)) {
        $sql = "SELECT * FROM blog_table LIMIT $offset, $rowsperpage";    
    }
    else {      
        if($tri_blog == "croissant"){
            $sql = "SELECT * FROM blog_table ORDER BY date ASC LIMIT $offset, $rowsperpage"; 
        }     
        else{
            $sql = "SELECT * FROM blog_table ORDER BY date DESC LIMIT $offset, $rowsperpage"; 
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
    ?>
        <div class="blog_pager_links">

<?php include 'config/paginator_links.php';?>

        </div>
    <?php

    $conn->close();
?>

</div>

<?php
  
include 'navigation/footer.php';?>
    <script src="app.js"></script>
</body>

</html>