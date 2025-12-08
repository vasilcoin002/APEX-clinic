<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <!-- TODO make errors occure not sequenly but at one response -->
    <h2>UserController</h2>
    <p>Post methods</p>
    <form action="users/userController.php" method="post" enctype="multipart/form-data">
        <div><label>email:<input type="text" name="email"></label></div>
        <div><label>password:<input type="password" name="password"></label></div>
        <div><label>name: <input type="text" name="name"></label></div>
        <div><label>surname: <input type="text" name="surname"></label></div>
        <div><label>phone number: <input type="tel" name="phone_number"></label></div>
        <div>
            <input type="submit" name="action" value="register">
            <input type="submit" name="action" value="login">
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
        <div>
            <label>comment: <input type="textarea" name="comment"></label>
        </div>
        <div>
            <input type="submit" name="action" value="update-comment">
        </div>
    </form>
    <p>Get methods</p>
    <form action="users/userController.php" method="get" enctype="multipart/form-data">
        <div>
            <input type="submit" name="action" value="check-if-logined">
            <input type="submit" name="action" value="get-session-user-info">
        </div>
    </form>
    <br>
    <h2>AdminController</h2>
    <p>Post methods</p>
    <form action="admins/adminController.php" method="post" enctype="multipart/form-data">
        <div>
            <div>
                <label>email: <input type="text" name="email"></label>
            </div>
            <input type="submit" name="action" value="delete-user">
            <input type="submit" name="action" value="promote-user">
        </div>
    </form>
    <p>Get methods</p>
    <form action="admins/adminController.php" method="get" enctype="multipart/form-data">
        <div>
            <div>
                <label>from: <input type="text" name="from"></label>
                <label>to: <input type="text" name="to"></label>
            </div>
            <input type="submit" name="action" value="get-number-of-users">
            <input type="submit" name="action" value="get-range-of-users">
        </div>
    </form>
</body>
</html>

<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
?>