<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'config.php'; 

if(isset($_SESSION['logged']) && $_SESSION['loggedin'] === false) {
    http_response_code(403); 
    echo "Not logged in.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $client = $_POST['client'] == 'new' ? $_POST['new_client'] : $_POST['client']; 
    $time_window = (int)$_POST['time_window'];
    $notes = $_POST['notes']; 

    $end_time = new DateTime();
    $start_time = clone $end_time;
    $start_time->sub(new DateInterval("PT{$time_window}M"));
    $start_time = $start_time->format('Y-m-d H:i:s');
    $end_time = $end_time->format('Y-m-d H:i:s');

    $sql = "INSERT INTO logs (user_id, client, start_time, end_time, notes) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $client, $start_time, $end_time, $notes); 

    if ($stmt->execute()) {
        echo "Work logged successfully.";
    } else {
        http_response_code(500);
        echo "Error logging work."; 
    }
    $stmt->close();
}
?>