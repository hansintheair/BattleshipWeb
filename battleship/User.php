<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: Home.php');
    exit;
}

include "BattleshipsDB.php";

$action = $_POST['action'] ?? '';

$store_db = new BattleshipsDB();
$store_db->connect();
$email = $_SESSION['user_email'];
$userData = $store_db->getUser($email);
$store_db->disconnect();

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
    case 'game_menu':
        header('Location: GameMenu.php');
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
    <link rel="stylesheet" href="css/home-styles.css">
    <link rel="stylesheet" href="css/iframe.css">

</head>
<body>
    <div class="header">
        <div class="top-space"></div>
        <div class="waves-container">
            <div id="waves-wrapper">
                <img src="images/waves.gif" alt="Waves" class="waves">
            </div>
        </div>
        <img src="images/logo.png" alt="Battleship Logo" class="logo">
    </div>
    <form id="userForm" method="post" target="iframe_content">
        <?php if ($userData["IS_ADMIN"]): ?>
            <button type="button" onclick="submitForm('admin')">Admin Menu</button>
        <?php endif; ?>
        <button type="button" onclick="submitForm('accountInfo')"><i class="fas fa-user-circle icon"></i> Account Info</button>
        <button type="button" onclick="submitForm('GameMenu')"><i class="fas fa-gamepad icon"></i> Launch Game</button>
        <button type="button" onclick="submitForm('updateAccount')"><i class="fas fa-edit icon"></i> Update Account</button>
        <button type="button" onclick="submitForm('logout')"><i class="fas fa-sign-out-alt icon"></i> Logout</button>
    </form>
    
    <iframe name="iframe_content" frameborder="0"></iframe>
    <script>
    function submitForm(action) {
        if (action === 'logout') {
            window.location.href = 'home.php';
        } else {
            document.getElementById('userForm').action = action + '.php';
            document.getElementById('userForm').submit();
        }
    }
</script>
    <script src="js/tile-waves.js"></script>
</body>
</html>