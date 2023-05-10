<?php
session_start();
require 'config.php'; 

if(isset($_SESSION['logged']) && $_SESSION['loggedin'] === false) {
    http_response_code(403); 
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['client'])) {
    $client = $_GET['client'];
    $sql = "SELECT logs.*, users.username FROM logs
            INNER JOIN users on logs.user_id = users.id
            WHERE logs.client = ?
            ORDER BY logs.start_time DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $client);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            $date = date("d/m/y", strtotime($row['start_time']));
            $time_window = date("H:i", strtotime($row['start_time'])) . " - " . date("H:i", strtotime($row['end_time']));
            echo "<li>{$date} - {$time_window} - {$row['username']} - {$row['notes']}</li>";
        }
        echo "</ul>";
    } else {
        echo "No logs founds.";
    }
    $stmt->close();
}