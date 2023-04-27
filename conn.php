<?php

//connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_pwms";
//create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//error massage!
if ($conn->connect_error) {
    die("Connection failed..." . $conn->connect_error);
}
?>