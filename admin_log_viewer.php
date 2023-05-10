<?php
session_start();
require 'config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false || $_SESSION['is_admin'] !== 1) {
    header('Location: main.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Log Viewer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Admin Log Viewer</h2>
        <form id="admin-log-viewer-form">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" required>
            <br>
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" required>
            <br>
            <input type="submit" value="Get Logs">
        </form>       
        <div id="admin-log-viewer-output"></div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#admin-log-viewer-form').submit(function(event) {
                event.preventDefault();

                let formData = {
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val()
                };

                $.ajax({
                    type: "POST",
                    url: "get_admin_logs.php",
                    data: formData,
                    success: function(response) {
                        $('#admin-log-viewer-output').html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>