<!--This page is needed for any page with interraction with the ddb-->

<?php

//all connexions to the database

$servername = "localhost";
$username = "root";
$password = "casio";
$dbname = "fev_php_local";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection for errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>