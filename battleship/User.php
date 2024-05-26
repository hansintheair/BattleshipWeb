<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: Home.php');
    exit;
}

// Include the necessary database operations
include "BattleshipsDB.php";

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'logout':
        session_destroy();
        header('Location: Home.php');
        exit;
    case 'account_info':
        header('Location: accountInfo.php');
        exit;
    case 'update_account':
        header('Location: updateAccount.php');
        exit;
    case 'play_game':
        header('Location: playGame.php');
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
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>User Dashboard</h1>
    <p>Select an option:</p>
    <form action="user.php" method="post">
        <button type="submit" name="action" value="account_info"><i class="fas fa-user-circle icon"></i>Account Info</button>
        <button type="submit" name="action" value="launch_game"><i class="fas fa-gamepad icon"></i>Launch Game</button>
        <button type="submit" name="action" value="update_account"><i class="fas fa-edit icon"></i>Update Account</button>
        <button type="submit" name="action" value="logout"><i class="fas fa-sign-out-alt icon"></i>Logout</button>
    </form>
</body>
</html>