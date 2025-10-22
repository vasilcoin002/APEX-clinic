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
            <input type="submit" name="register" value="register">
            <input type="submit" name="login" value="login">
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

    session_start();
    // if (isset($_POST["register"])) {
    //     $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    //     $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    //     $user_repository = new UserRepository();
    //     $user = new User(null, $email, $password, Roles::USER);
        
    //     $user = $user_repository->add_user($user);
    // }

?>