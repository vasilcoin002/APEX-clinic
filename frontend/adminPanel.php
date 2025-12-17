<?php
    session_start();

    // если роль в сессии не найдена, значит пользователь не залогинился, переадресация на логин
    if (!isset($_SESSION["user_role"])) {
        header("Location: frmLogin.php");
        die();
    }

    // если пользователь не админ, то переадресация на страницу ошибки
    if ($_SESSION["user_role"] !== "ADMIN") {
        header("Location: error.php");
        die();
    }

    // если на эту страницу зашли без параметров, то перенаправляем на страницу с параметром
    if (!isset($_GET["page"])) {
        header("Location: adminPanel.php?page=1");
        die();
    }

    $page = $_GET["page"];

?>
<!doctype html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="css/adminPanel.css">
</head>
<body>

    <h1>Users List</h1>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Surname</th>
                <th>E-mail</th>
                <th>Role</th>
                <th width="300">Actions</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>

        <div class="pagination">

        </div>
    <hr>
    <script src="js/adminPanel.js"></script>
</body>
</html>