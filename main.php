<?php
session_start();
require 'config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT DISTINCT client FROM logs ORDER BY client ASC";
$result = $conn->query($sql);
$clients = array();
while ($row = $result->fetch_assoc()) {
    $clients[] = $row['client']; 
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

    </style>
</head>
<body> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 left-side">
                <h2>Log Work</h2>
                <form id="work-logging-form">
                    <label for="client">Client:</label>
                    <select name="client" id="client" onchange="checkNewClient(this)" required>
                        <option value="">Select a client</option>
                        <option value="new">New client</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client; ?>"><?php echo $client; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <label for="time_window">Time:</label>
                    <select name="time_window" id="time_window" required>
                        <option value="">Select time window</option>
                        <option value="5">5 minutes</option> 
                        <option value="10">10 minutes</option>
                        <option value="15">15 minutes</option>
                        <option value="30">30 minutes</option>
                        <option value="45">45 minutes</option>
                        <option value="60">1 hour</option>
                    </select>
                    <input type="text" name="new_client" id="new_client" style="display: none;" placeholder="Enter new client name">
                    <br>
                    <label for="notes">Notes:</label>
                    <textarea name="notes" id="notes" required></textarea> 
                    <br>
                    <input type="submit" value="Submit"> 
                </form>
            </div>
            <div class="col-md-4 right-side">
                <h2>Log Viewer</h2>
                <div id="log-viewer"></div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#work-logging-form").submit(function(event) {
                event.preventDefault(); 
                let formData = {
                    client: $("#client").val(),
                    time_window: $("#time_window").val(),
                    notes: $("#notes").val()
                };

                $.ajax({
                    type: "POST",
                    url: "log_work.php",
                    data: formData,
                    ssuccess: function(response) {
                        $("#log-work-status").html(response); 
                        $("#work-logging-form")[0].reset(); 
                        loadLogs();
                    }
                });
            });

            loadLogs();

            setInterval(loadLogs, 5000);
        });

        $("#client").on("click", function() {
            loadLogs();
        }); 

        function loadLogs() {
            let client = $("#client").val();

            $.ajax({
                type: "GET",
                url: "get_logs.php",
                data: { client: client },
                success: function(response) {
                    $("#log-viewer").html(response);
                } 
            });
        }

        function checkNewClient(select) {
            if (select.value == 'new') {
                document.getElementById('new_client').style.display = 'block';
            } else {
                document.getElementById('new_client').style.display = 'none';
            }
        }
    </script>
</body>
</html>