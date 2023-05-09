<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "work_log";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} // I will create user for u, then send u link, then u try to log
// then I will see if I can see what u log
?> 