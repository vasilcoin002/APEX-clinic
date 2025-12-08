<?php
require "users.lib.php";

// 1. Обработка действий (сохранение, удаление, редактирование)
$action = isset($_REQUEST["action"]) ? $_REQUEST["action"] : null;

if ($action) {
    switch ($action) {
        case "add":
            add_user($_POST["name"], $_POST["email"], $_POST["avatar"]); 
            break;
        case "edit":
            edit_user($_POST["id"], $_POST["name"], $_POST["email"], $_POST["avatar"]); 
            break;
        case "delete":
            delete_user($_POST["id"]); 
            break;
        case "make_admin":
            // ВАЖНО: Тебе нужно создать функцию set_admin($id) в users.lib.php
            // if (function_exists('set_admin')) { set_admin($_POST["id"]); }
            break;
    }
    
    // Если мы не просто открыли форму просмотра ("view"), то перегружаем страницу,
    // чтобы сбросить данные формы и обновить таблицу.
    if ($action != "view") { 
        header("Location: index.php"); 
        exit; 
    }
}

$all_users = list_users();
$total_users = count($all_users);
$limit = 5; // Лимит: 5 пользователей на страницу
// Получаем номер страницы
$page = 1;
if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
}
if ($page < 1) {
    $page = 1;
}

// Считаем отступ
$offset = ($page - 1) * $limit;

// Берем часть массива
$users_on_page = array_slice($all_users, $offset, $limit);

$total_pages = ceil($total_users / $limit); #округление в большую сторону
?> 


<!doctype html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="php_style.css">
</head>
<body>

    <h1>Users List</h1>

    <table>
        <thead>
            <tr>
                <th>Avatar</th>
                <th>Name</th>
                <th>E-mail</th>
                <th width="300">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users_on_page as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user["avatar"]); ?></td>
                    <td><?php echo htmlspecialchars($user["name"]); ?></td>
                    <td><?php echo htmlspecialchars($user["email"]); ?></td>
                    <td>
                        <form action="index.php">
                            <input type="hidden" name="action" value="view">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn-edit">Edit</button>
                        </form>
                        
                        <form action="index.php" method="post" onsubmit="return confirm('Are you sure you want to delete?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn-del">Delete</button>
                        </form>

                        <form action="index.php" method="post">
                            <input type="hidden" name="action" value="make_admin">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn-admin" title="Сделать админом">★ Admin</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($total_pages > 1) { ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++){
                $is_first_or_last = ($i == 1) || ($i == $total_pages);
                $is_near_current = abs($i - $page) <= 1; #abs - расстояние
                if ($is_first_or_last || $is_near_current){
                    ?>
                    <a href="?page=<?php echo $i; ?>" class="<?php if ($i == $page) echo 'active'; ?>">
                <?php echo $i; ?>
                    </a>
                    <?php 
                }
                elseif ($i == $page - 3 || $i == $page + 3) {
                    echo "...";
                }
            } ?>
            <form action="index.php" method="get" style="display:inline-block; margin-left: 10px;">
                <input type="number" name="page" min="1" max="<?php echo $total_pages; ?>" placeholder="#" 
                    style="width: 50px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="padding: 5px 10px; cursor:pointer; background-color:#34495e; border:1px solid #ddddddff; border-radius:4px;">Go</button>
            </form>
        </div>
    <?php } ?>
    <hr>

    <?php if ($action == "view") { ?>
        
        <?php 
            $user = get_user($_GET["id"]); 
            if ($user) {
        ?>
            <h2>Edit User</h2>
            <div class="user-form">
                <form action="index.php" method="post">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    
                    <label>Avatar (emoji):</label>
                    <input name="avatar" maxlength="2" size="1" value="<?php echo htmlspecialchars($user['avatar']); ?>">
                    
                    <label>Name:</label>
                    <input name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
                    
                    <label>E-mail:</label>
                    <input name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                    
                    <button type="submit" class="btn-save">Save Changes</button>
                    <a href="index.php" style="margin-left:10px; color:#777;">Cancel</a>
                </form>
            </div>
        <?php } else { ?>
            <p>User not found.</p>
        <?php } ?>

    <?php } else { ?>

        <h2>Add User</h2>
        <div class="user-form">
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="add">
                
                <label>Avatar (emoji):</label>
                <input name="avatar" maxlength="2" size="1" placeholder="🙂">
                
                <label>Name:</label>
                <input name="name" placeholder="Иван Иванов">
                
                <label>E-mail:</label>
                <input name="email" placeholder="ivan@example.com">
                
                <button type="submit" class="btn-save">Add User</button>
            </form>
        </div>

    <?php } ?>

</body>
</html>