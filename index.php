<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <form action="users/userController.php" method="post" enctype="multipart/form-data">
        <div><label>email:<input type="text" name="email"></label></div>
        <div><label>password:<input type="password" name="password"></label></div>
        <div><label>name: <input type="text" name="name"></label></div>
        <div><label>surname: <input type="text" name="surname"></label></div>
        <div><label>phone number: <input type="tel" name="phone_number"></label></div>
        <div>
            <input type="submit" name="action" value="register">
            <input type="submit" name="action" value="login">
            <input type="submit" name="action" value="check-if-logined">
            <input type="submit" name="action" value="logout">
            <input type="submit" name="action" value="delete-account">
            <input type="submit" name="action" value="update-email">
            <input type="submit" name="action" value="update-name">
            <input type="submit" name="action" value="update-surname">
            <input type="submit" name="action" value="update-phone-number">
            <input type="submit" name="action" value="update-password">
        </div>
        <br>
        <div><input type="file" accept="image/*" name="avatar"></div>
        <div>
            <input type="submit" name="action" value="update-avatar">
            <input type="submit" name="action" value="delete-avatar">
        </div>
        <br>
    </form>
    <form action="admins/adminController.php" method="post" enctype="multipart/form-data">
        <div>
            <p>Admin panel</p>
            <div><label>email: <input type="text" name="email"></label></div>
            <input type="submit" name="action" value="delete-user">
        </div>
    </form>
    <br>
    <form action="services/serviceController.php" method="post" enctype="multipart/form-data">
        Service panel
        <div>
            <div style="display: flex; flex-direction: column;">
                <label>from: <input type="text" name="from"></label>
                <label>to: <input type="text" name="to"></label>
            </div>
            <input type="submit" name="action" value="get-services">
        </div>
        <br>
        <div>
            <div style="display: flex; flex-direction: column;">
                <label>name: <input type="text" name="name"></label>
                <label>category: <input type="text" name="category"></label>
                <label>doctor: <input type="text" name="doctor"></label>
                <label>price: <input type="text" name="price"></label>
            </div>
            <input type="submit" name="action" value="add-service">
        </div>
        <br>
        <div>
            <div>
                <label>id: <input type="text" name="id"></label>
            </div>
            <input type="submit" name="action" value="update-service">
        </div>
    </form>
</body>
</html>

<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once "./users/User.php";
    require_once "./users/UserDTO.php";
    require_once "./users/UserRepository.php";
    require_once "./users/Roles.php";
?>