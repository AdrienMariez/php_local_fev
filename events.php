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

<?php include 'config/session.php';?>

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
        <option value="all_places">see entries in all places</option>
        <?php
        
        $place = "SELECT place FROM event_table";
        $place_result = $conn->query($place);

        if ($place_result->num_rows > 0) {
            // output data of each row
            while($row = $place_result->fetch_assoc()) {
            ?>
                <option <?php if($row["place"] == $tri_events) {echo "selected='selected'";} ?> value="<?php echo "" . $row["place"]. ""; ?>"><?php echo "" . $row["place"]. ""; ?></option>

            <?php
            }
        } else {
            echo "No places were found.";
        }
        ?>
        </select> 
        <input type="checkbox" name="history_check" value="1"> include history
        <input type="submit" value="Submit">
    </form>

        <?php

        // how many rows are in the table 
        $sql = "SELECT COUNT(*) FROM event_table";


        if (!isset($_POST['history_check'])){
            $history_check = '0';
        }else{
            $history_check = $_POST['history_check'];
        }
        //var_dump($history_check);

        include 'config/paginator.php';

            if(!isset($tri_events) && $history_check=='0') {
                //all places default + no history
                var_dump('A-1');
                $sql = "SELECT *
                        FROM event_table
                        WHERE ending_date>='". date("Y-m-d") ."'
                        ORDER BY ending_date ASC
                        LIMIT $offset, $rowsperpage";    
            }
            elseif(!isset($tri_events) && $history_check=='1') {
                //all places default + no history
                var_dump('A-2');
                $sql = "SELECT *
                        FROM event_table
                        WHERE ending_date>='". date("Y-m-d") ."'
                        ORDER BY ending_date ASC
                        LIMIT $offset, $rowsperpage";    
            }
            else {
                if($tri_events == "all_places"){
                
                    if($history_check=='1'){
                        //all places + history
                        var_dump('B-1');
                        $sql = "SELECT *
                            FROM event_table
                            ORDER BY ending_date ASC
                            LIMIT $offset, $rowsperpage";
                    }
                    else{
                        //all places + no history
                        var_dump('B-2');
                        $sql = "SELECT *
                                FROM event_table
                                WHERE ending_date>='". date("Y-m-d") ."'
                                ORDER BY ending_date ASC
                                LIMIT $offset, $rowsperpage";
                    }
                }
                if($tri_events !== "all_places"){                
                    if($history_check=='1'){
                        //specific + history
                        var_dump('C-1');
                        $sql = "SELECT *
                                FROM event_table
                                WHERE place='$tri_events'
                                ORDER BY ending_date ASC
                                LIMIT $offset, $rowsperpage";
                    }
                    else{
                        var_dump('C-2');
                        //specific + no history
                        $sql = "SELECT *
                                FROM event_table
                                WHERE ending_date>='". date("Y-m-d") ."'
                                AND place='$tri_events'
                                ORDER BY ending_date ASC
                                LIMIT $offset, $rowsperpage";
                    }
                }
                    ?>
                    <!--<div class="events_select_desc">
                        <p>Entries from <?php //$tri_events ?>.</p>
                    </div>-->
                    <?php
            }  

            //var_dump($_SESSION['tri']);

            //$sql = "SELECT * FROM event_table WHERE ending_date>='". date("Y-m-d") ."'";
            //var_dump($sql);

            $result = $conn->query($sql);
            
            //var_dump($row);
            
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