<?php include 'config/bdd.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Events</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navigation/header.php';?>
    <?php include 'navigation/nav.php';?>
    <div class="body_content">
        <?php  if (isset($_SESSION['username'])) : ?>

    <div class="body_content_title"><?php include 'config/bdd.php';?>


        <h3>Events</h3>
    </div>

    <div class="body_content">

    <form method="post" action="" class="events_select">
        <select name="select">
            <option value="place">sort by place</option>
            <option value="date">sort by date</option>
            <option value="old">see all entries</option>
        </select> 
        <input type="submit" value="Submit">
    </form>

        <?php 
            if(!isset($_POST['select'])) {
                $sql = "SELECT * FROM event_table WHERE ending_date>='". date("Y-m-d") ."'";    
            }
            if(isset($_POST['select'])) {
                $tri = $_POST['select'];       
                if($tri == "place"){
                    $sql = "SELECT * FROM event_table WHERE ending_date>='". date("Y-m-d") ."' ORDER BY place ASC";
                    ?>
                    <div class="events_select_desc">
                        <p>Sorted by place.</p>
                    </div> 
                    <?php
                }
                elseif($tri == "date"){
                    $sql = "SELECT * FROM event_table WHERE ending_date>='". date("Y-m-d") ."'"; 
                    ?>
                    <div class="events_select_desc">
                        <p>Sorted by date.</p>
                    </div> 
                    <?php
                }  
                else{
                    $sql = "SELECT * FROM event_table ORDER BY ending_date ASC"; 
                    ?>
                    <div class="events_select_desc">
                        <p>ALl entries sorted by date.</p>
                    </div> 
                    <?php
                }
            }  

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