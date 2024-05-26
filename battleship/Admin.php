<?php
session_start();

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'view_users':
        header('Location: viewUsers.php');
        exit;
    case 'add_user':
        header('Location: addUser.php');
        exit;
    case 'delete_user':
        header('Location: deleteUser.php');
        exit;
    case 'modify_user':
        header('Location: modifyUser.php');
        exit;
    case 'logout':
        session_destroy();
        header('Location: Home.php');
        exit;
    default:
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu</title>
    <link rel="stylesheet" href="css/home-styles.css">
</head>
<body>
    <h1>Admin Menu</h1>
    <div class="menu-container">
        <form action="Admin.php" method="post">
            <button type="submit" name="action" value="view_users">View All Users</button>
        </form>
        <form action="Admin.php" method="post">
            <button type="submit" name="action" value="add_user">Add User</button>
        </form>
        <form action="Admin.php" method="post">
            <button type="submit" name="action" value="delete_user">Delete User</button>
        </form>
        <form action="Admin.php" method="post">
            <button type="submit" name="action" value="modify_user">Modify User</button>
        </form>
        <form action="Admin.php" method="post">
            <button type="submit" name="action" value="logout">Exit Menu</button>


        </form>
    </div>
</body>
</html>