<?php
session_start();
require 'config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false || $_SESSION['is_admin'] !== 1) {
    http_response_code(403);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'] . ' 00:00:00';
    $end_date = $_POST['end_date'] . ' 23:59:59';

    $sql = "SELECT logs .*, users.username FROM logs
            INNER JOIN users ON logs.user_id = users.id
            WHERE logs.start_time BETWEEN ? AND ?
            ORDER BY logs.client, logs.start_time ASC";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('prepare() failed: ' . htmlspecialchars($conn->error));
    } 
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $current_client = '';
        while ($row = $result->fetch_assoc()) { 
            if ($current_client != $row['client']) {
                if ($current_client != '') echo '<hr>';
                $current_client = $row['client'];
                echo "<h3>{$current_client}</h3>";
            }
            $date = date("d/m/Y", strtotime($row['start_time']));
            $time_window = date("H:i", strtotime($row['start_time'])) . " - " . date("H:i", strtotime($row['end_time']));
            echo "<p>{$date} - {$time_window} - {$row['username']} - {$row['notes']}</p>"; 
        }
    } else {
        echo "No logs found.";
    }
    $stmt->close();
}
?>