<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php';?>
<?php include 'nav.php';?>
<div class="body_content">

    <div class="body_content_title">
        <h3>Contact</h3>
    </div>

    <div id="contact_callback" class="contact_callback">
        <?php
        if(isset($_POST['email'])) {

            //$email_to = "adrien.mariez@gmail.com";
            $email_to = ".com";
            $email_subject = "php localhost website feedback";

            function died($error) {
                ?>

                <div class="contact_failed">
                    <div>
                        <p>We are very sorry, but there were error(s) found with the form you submitted.</p>
                        <p>These errors appear below.</p>
                    </div>
                    <?php
                    echo $error;
                    ?>
                    <div>
                        <p>Please go back and fix these errors.</p>
                    </div>
                </div>
                <?php
                
            }
            function success($success_message,$object,$email_from,$message,$theme,$account_check,$your_age_int) {
                ?>
                    <div class="contact_success">
                        <?php
                            echo $success_message;
                        ?>
                    </div>
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

                    $sql = "INSERT INTO contact_requests (object, email, message, theme, account, age)
                    VALUES ('$object', '$email_from', '$message', '$theme','$account_check', '$your_age_int')";

                    if ($conn->query($sql) === TRUE) {
                        echo "";
                    } else {
                        echo "Error connecting database.";
                    }

                    $conn->close();
            }
        
            // validation expected data exists
            if(!isset($_POST['object']) ||
                // !isset($_POST['email']) ||
                // !isset($_POST['your_age']) ||
                !isset($_POST['message'])) {
                died('We are sorry, but there appears to be a problem with the form you submitted.');       
            }
        
            
        
            $object = $_POST['object']; // required
            $email_from = isset($_POST['email']) ? $_POST['email'] : ''; // not required
            $message = $_POST['message']; // required
            $theme = isset($_POST['theme']) ? $_POST['theme'] : ''; // not required
            $account_check = $_POST['account_check']; // not required
            $your_age = $_POST['your_age']; // not required

            $your_age_int = intval($your_age);

            $forbidden    = 'simplon';

            $check_forbidden = stripos($object, $forbidden);
        
            $error_message = "";
        
            $success_message = "";

            $string_exp = "/^[A-Za-z .'-]+$/";


        if(!preg_match($string_exp,$object)) {
            $error_message .= 'The object of your message is not valid.<br />';
        }  

        if(strlen($message) < 1) {
            $error_message .= 'Your message do not appear to be valid.<br />';
        }

        //var_dump($check_forbidden);

        if ($check_forbidden !== false) {
            $error_message .= 'The object of your message contains forbidden words. Be polite !<br />';
        }

        if(strlen($error_message) > 0) {
            died($error_message);
        }

        if(strlen($error_message) == 0) {
            $success_message = "<p>Your following message :</p>
            <p>
                '$message'
            </p>
            <p>Has been correctly sent.</p>
            <p>Thank you for contacting us. We will be in touch with you very soon.</p>";
            success($success_message,$object,$email_from,$message,$theme,$account_check,$your_age_int);
        }
        
            $email_message = "Form details below.\n\n";
        
            
            function clean_string($string) {
            $bad = array("content-type","bcc:","to:","cc:","href");
            return str_replace($bad,"",$string);
            }
        
            
        
            $email_message .= "Object : ".clean_string($object)."\n";
            $email_message .= "Email : ".clean_string($email_from)."\n";
            $email_message .= "your_age : ".clean_string($your_age)."\n";
            $email_message .= "Message : ".clean_string($message)."\n";
        
        // create email headers
        $headers = 'From: '.$email_from."\r\n".
        'Reply-To: '.$email_from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        @mail($email_to, $email_subject, $email_message, $headers);  
        ?>
        <?php
        }
        ?>
    </div>

    <div class="contact_required">
        <p>All fields with * are required.</p>
    </div>

    <form id="contactform" name="contactform" method="post">
        <table width="450px">
            <tr>
                <td valign="top">
                    <input  type="text" name="object" maxlength="50" size="30" placeholder="Object *">
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <input  type="text" name="email" maxlength="80" size="30" placeholder="Email Address">
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <textarea  name="message" maxlength="1000" cols="25" rows="6" placeholder="Your message *"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <select name="theme">
                        <option disabled selected="selected" value="theme">Theme</option>
                        <option value="css">CSS</option>
                        <option value="html">HTML</option>
                    </select> 
                </td>
            </tr>
            <tr class="contact_account">
                <td valign="top">
                    <p>Do you have an account here ?</p>
                </td>
                <td colspan="2"class="contact_account_checkboxes">
                <input type="radio" name="account_check" value="1"> Yes<br>
                <input type="radio" name="account_check" value="0" checked="checked"> No<br>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <input  type="number" name="your_age" min="0" maxlength="3" size="30" placeholder="Your age">
                </td>
            </tr>
            <tr class="contact_submit">
                <td colspan="2" style="text-align:left">
                    <button onclick="document.getElementById('contactform').reset(); return false;">
                        Reset
                    </button>
                </td>
                <td colspan="2" style="text-align:right">
                    <input type="submit" value="Submit">
                </td>
            </tr>
        </table>
    </form>

</div>
<?php include 'footer.php';?>
<script src="app.js"></script>
</body>
</html>