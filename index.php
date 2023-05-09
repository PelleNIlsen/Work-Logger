<?php
session_start();
require 'config.php'; 

if(isset($_SESSION['logged']) && $_SESSION['loggedin'] === true) {
    header('Location: main.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}
?>