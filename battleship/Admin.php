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
    case 'launch_game':
        header('Location: gameMenu.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/home-styles.css">
</head>
<body>
    <h1>Admin Menu</h1>
    <div class="menu-container">
        <form action="Admin.php" method="post">
            <button type="submit" name="action" value="view_users">
                <i class="fas fa-users"></i> View All Users
            </button>
        </form>
        <form action="Admin.php" method="post">
            <button type="submit" name="action" value="add_user">
                <i class="fas fa-user-plus"></i> Add User
            </button>
        </form>
        <form action="Admin.php" method="post">
            <button type="submit" name="action" value="delete_user">
                <i class="fas fa-user-minus"></i> Delete User
            </button>
        </form>
        <form action="Admin.php" method="post">
            <button type="submit" name="action" value="modify_user">
                <i class="fas fa-user-edit"></i> Modify User
            </button>
        </form>
    </div>
</body>
</html>