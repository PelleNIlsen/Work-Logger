<?php
session_start();
require 'config.php';
// require 'another pencil?';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
    header('Location: login.php');
    exit;
}

// I dont remeber how to set cookies :( percentage is space %20
// idk browsers weird "what is 10% og 50" = "what%20is%2010%%20of%2050 fair

$sql = "SELECT DISTINCT client FROM logs ORDER BY client ASC";
$result = $conn->query($sql);
$clients = array();
while ($row = $result->fetch_assoc()) { // lol fetch another sock
    $clients[] = $row['client']; // nah // I need to hire u as layouter ys, no much money for u $$$$ //  do that lmfao
} // NOW the fun part starts tihi,,, nono I meant now we add functionality etc so now we can test and so stuff yeyes
// yesyes and database is fun
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main Page</title>
    <!-- Prolly some bootstrap here , yes -->
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
                    <select name="client" id="client" required>
                        <option value="">Select a client</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client; ?>"><?php echo $client; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <label for="time-window">Time:</label>
                    <select name="time-window" id="time-window" required>
                        <option value="">Select time window</option>
                        <option value="5">5 minutes</option> 
                        <option value="10">10 minutes</option>
                        <option value="15">15 minutes</option>
                        <option value="30">30 minutes</option>
                        <option value="45">45 minutes</option>
                        <option value="60">1 hour</option>
                    </select>
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
                // think I found it
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
        }); //nah u good now deeper test LMFAO
        // ok so the function loadLogs is supposed to run
        // thsi one
        function loadLogs() {
            // so lets see if it even runds
            // Now we display the loadLogs bro / it runs then what is wrong
            let client = $("#client").val();

            $.ajax({
                type: "GET",
                url: "get_logs.php",
                data: { client: client },
                success: function(response) {
                    //oh no
                    $("#log-viewer").html(response);
                } //father? WHTS IA WROnt
            });
        }
    </script>
</body>
</html>