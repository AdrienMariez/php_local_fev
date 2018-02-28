<?php

//This file is used for all connexions to the database

$servername = "localhost";
$username = "root";
$password = "casio";
$dbname = "fev_php_local";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>