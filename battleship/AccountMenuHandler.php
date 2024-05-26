<?php
session_start();
require 'BattleshipsDB.php';

if (!isset($_SESSION['user_email'])) {
    header('Location: Home.php');
    exit;
}

$db = new BattleshipsDB();
$db->connect();
$user = $db->getUser($_SESSION['user_email']);
$action = $_POST['action'] ?? '';

switch ($action) {
    case 'change_email':
        $new_email = filter_input(INPUT_POST, 'new_email', FILTER_SANITIZE_EMAIL);
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['account_error'] = "Invalid email format";
            header('Location: accountMenu.php');
            exit;
        }
        $user['email'] = $new_email;
        $db->updateUser($user);
        $_SESSION['account_success'] = "Email has been updated.";
        break;
    case 'update_password':
        $new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);
        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{7,}$/', $new_password)) {
            $_SESSION['account_error'] = "Password must contain at least one lowercase letter, one uppercase letter, and one number.";
            header('Location: accountMenu.php');
            exit;
        }
        $user['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        $db->updateUser($user);
        $_SESSION['account_success'] = "Password has been updated.";
        break;
    case 'delete_account':
        $db->deleteUser($user['id_user']);
        session_destroy();
        header('Location: Home.php');
        exit;
    default:
        break;
}
$db->disconnect();
header('Location: accountMenu.php');
exit;


?>