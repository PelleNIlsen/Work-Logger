<?php
session_start();
require 'config.php'; 

if(isset($_SESSION['logged']) && $_SESSION['loggedin'] === true) {
    header('Location: main.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // I wonder
    $password = $_POST['password']; // tihi

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); //I made a typo smh... bing not bind wow
    $stmt->execute();
    $result = $stmt->get_result(); // U productive? damn gjgj

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // lol fetch a sock

        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id']; // as u should
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin']; // :D

            header('Location: main.php'); // if u porud me porud
            exit; // tihi soccer mom? FORK YEAH sock mom
        } else {
            $error = "Invalid password."; // idk
        }
    } else { // My code is gonna be littered in these comments
        $error = "User not found."; // My co-workers better not read this code istg
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- bootstrap and main css here, bootstrap is styling, like colors n shit -->
</head>
<body>
    <!-- head body knees and toes, knees and toes mb -->
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>