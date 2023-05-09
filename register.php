<?php
//no pencil? i wanna hear pencil
session_start();
require 'config.php';
// require 'pencil pls thanku'; // This line will crash the program
// bro you remeber this line and I said it would crash the program
// it crashed the program woopsies
// fixed it tho. Thakn you fatehr

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false || $_SESSION['is_admin'] !== 1) {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // yes 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0; // U still being productive?

    $sql = "INSERT INTO users (username, password, is_admin) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql); //goodgood
    $stmt->bind_param("ssi", $username, $password, $is_admin); // I WROTE FUCKING BING AGAIN. true
    $stmt->execute(); //me brain is a lexicon, i dont meant that

    if ($stmt->affected_rows > 0) {
        $success = "User registered successfully."; // <-- Did I type successfully correct... goodgood thankyou queen thumbsup
    } else {
        $error = "Error registering user.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <!-- Bootstrap here too or sum other style -->
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($success)) echo "<p>$success</p>"; ?>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="is_admin">Admin:</label>
        <input type="checkbox" name="is_admin" id="is_admin">
        <br>
        <input type="submit" value="Register"> 
    </form>
</body>
</html>