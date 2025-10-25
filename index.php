<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <form action="users/userController.php" method="post">
        <div><label>email:<input type="email" name="email"></label></div>
        <div><label>password:<input type="password" name="password"></label></div>
        <div>
            <input type="submit" name="action" value="register">
            <input type="submit" name="action" value="login">
            <input type="submit" name="action" value="check-if-logined">
            <input type="submit" name="action" value="logout">
            <input type="submit" name="action" value="delete-account">
            <input type="submit" name="action" value="update-email">
        </div>
    </form>
</body>
</html>

<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // $whoami = exec('whoami');
    // echo "This script is running as user: <strong>" . $whoami . "</strong><br>";

    require_once "./users/User.php";
    require_once "./users/UserDTO.php";
    require_once "./users/UserRepository.php";
    require_once "./users/Roles.php";

    // session_start();
?>