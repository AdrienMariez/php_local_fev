<!--
"Un événement contient :

    Un titre
    Une image
    Un texte d'intro
    Une date de début
    Une date de fin
    Un lieu
    Une date de publication
OK
La page Evénéments liste uniquement les événements à venir ou en cours. 
OK

Seul les utilisateurs connectés peuvent accéder à cette liste d'événements,
OK

si je ne suis pas connecté, je dois être redirigé sur la page de log in.
FAIT DIFFEREMENT (OK)

Bonus: Permettre à l'utilisateur de filtrer la liste des événements par lieu"
FAIT DIFFEREMENT

-->

<?php include 'config/bdd.php';

        if(!empty($_POST['select_events'])){
            $tri_events = $_POST['select_events'];
            $_SESSION['tri_events'] = $tri_events;
        }else{
            if(!isset($_SESSION['tri_events'])){
                $tri_events = "place";
            }else{
                $tri_events = $_SESSION['tri_events'];
            }
        }

include 'navigation/head.php';?>

    <title>Events</title>
</head>
<body>
    <?php include 'navigation/header.php';?>
    <?php include 'navigation/nav.php';?>
    <div class="body_content">
        <?php  if (isset($_SESSION['username'])) : ?>

    <div class="body_content_title">


        <h3>Events</h3>
    </div>

    <div class="body_content">

    <form method="post" action="" class="events_select">
        <select name="select_events">
            <option <?php if($tri_events == "place") {echo "selected='selected'";} ?> value="place">sort by place</option>
            <option <?php if($tri_events == "date") {echo "selected='selected'";} ?>  value="date">sort by date</option>
            <option <?php if($tri_events == "old") {echo "selected='selected'";} ?> value="old">see all entries</option>
        </select> 
        <input type="submit" value="Submit">
    </form>

        <?php 

        // how many rows are in the table 
        $sql = "SELECT COUNT(*) FROM event_table";
            
        include 'config/paginator.php';

            if(!isset($tri_events)) {
                //$tri = "unset";
                
                $sql = "SELECT *
                        FROM event_table
                        WHERE ending_date>='". date("Y-m-d") ."'
                        LIMIT $offset, $rowsperpage";    
            }
            else {

                if($tri_events == "place"){
                    $sql = "SELECT *
                            FROM event_table
                            WHERE ending_date>='". date("Y-m-d") ."'
                            ORDER BY place ASC
                            LIMIT $offset, $rowsperpage";
                    ?>
                    <div class="events_select_desc">
                        <p>Sorted by place.</p>
                    </div> 
                    <?php
                }
                elseif($tri_events == "date"){
                    $sql = "SELECT *
                            FROM event_table
                            WHERE ending_date>='". date("Y-m-d") ."'
                            LIMIT $offset, $rowsperpage"; 
                    ?>
                    <div class="events_select_desc">
                        <p>Sorted by date.</p>
                    </div> 
                    <?php
                }  
                else{
                    $sql = "SELECT *
                            FROM event_table
                            ORDER BY ending_date ASC
                            LIMIT $offset, $rowsperpage"; 
                    ?>
                    <div class="events_select_desc">
                        <p>All entries sorted by date.</p>
                    </div> 
                    <?php
                }
            }  

            //var_dump($_SESSION['tri']);

            //$sql = "SELECT * FROM event_table WHERE ending_date>='". date("Y-m-d") ."'";
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
        ?>
            <div class="blog_pager_links">

        <?php include 'config/paginator_links.php';?>
            
            </div>
        <?php
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
    <?php include 'navigation/footer.php';?>
    <script src="app.js"></script>
</body>
</html>