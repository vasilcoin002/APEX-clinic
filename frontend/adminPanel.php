<?php

    if (!isset($_GET["page"])) {
        header("Location: adminPanel.php?page=1");
        die();
    }
    $total_pages = 10;
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
            <!-- <?php for ($i = 0; $i < 5; $i++) { ?>
                <tr>
                    <td><?php echo htmlspecialchars("1"); ?></td>
                    <td><?php echo htmlspecialchars("Adam"); ?></td>
                    <td><?php echo htmlspecialchars("Novak"); ?></td>
                    <td><?php echo htmlspecialchars("adam@gmail.com"); ?></td>
                    <td><?php echo htmlspecialchars("USER"); ?></td>
                    <td>
                        <form action="adminPanel.php" method="post">
                            <input type="hidden" name="id" value="<?php echo 1; ?>">
                            <button type="submit" class="btn-del" name="action" value="delete-user">Delete</button>
                            <button type="submit" class="btn-admin" name="action" value="promote-user">Promote</button>
                        </form>
                    </td>
                </tr>
            <?php }; ?> -->
        </tbody>
    </table>

        <div class="pagination">
            <!-- <?php for ($i = 1; $i <= $total_pages; $i++){
                $is_first_or_last = ($i == 1) || ($i == $total_pages);
                $is_near_current = abs($i - $page) <= 1; #abs - расстояние
                if ($is_first_or_last || $is_near_current){
                    ?>
                    <a href="?page=<?php echo $i; ?>" class="<?php if ($i == $page) echo 'active'; ?>">
                <?php echo $i; ?>
                    </a>
                    <?php 
                }
                elseif ($i == $page - 2 || $i == $page + 2) {
                    echo "...";
                }
            } ?> -->
            <!-- <form action="adminPanel.php" method="get" style="display:inline-block; margin-left: 10px;">
                <input type="number" name="page" min="1" max="<?php echo $total_pages; ?>" placeholder="#" 
                    style="width: 50px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="padding: 5px 10px; cursor:pointer; background-color:#34495e; border:1px solid #ddddddff; border-radius:4px;">Go</button>
            </form> -->
        </div>
    <hr>
    <script src="js/adminPanel.js"></script>
</body>
</html>