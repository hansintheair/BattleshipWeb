<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: Home.php');
    exit;
}

include "BattleshipsDB.php";

$store_db = new BattleshipsDB();
$store_db->connect();

$current_email = $_SESSION['user_email'];
$new_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// Check if new email is valid
if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["update_error"] = "Invalid email format";
    header("Location: updateAccount.php");
    exit;
}

// Check if the new email already exists in the database
$query = "SELECT * FROM `entity_users` WHERE `email` = ?";
$stmt = $store_db->getDb()->prepare($query);
$stmt->bind_param("s", $new_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0 && $new_email !== $current_email) {
    $_SESSION["update_error"] = "A user with that e-mail already exists";
    header("Location: updateAccount.php");
    exit;
}

$passwordpattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{7,}$/';

if (!empty($password) && !preg_match($passwordpattern, $password)) {
    $_SESSION["update_error"] = "Password must contain at least one lowercase letter, one uppercase letter, and one number.";
    header("Location: updateAccount.php");
    exit;
}

if (!empty($password)) {
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE `entity_users` SET `email` = ?, `password` = ? WHERE `email` = ?";
    $stmt = $store_db->getDb()->prepare($query);
    if ($stmt === false) {
        $_SESSION["update_error"] = "Failed to prepare the SQL statement.";
        header("Location: updateAccount.php");
        exit;
    }
    $stmt->bind_param("sss", $new_email, $password_hashed, $current_email);
} else {
    $query = "UPDATE `entity_users` SET `email` = ? WHERE `email` = ?";
    $stmt = $store_db->getDb()->prepare($query);
    if ($stmt === false) {
        $_SESSION["update_error"] = "Failed to prepare the SQL statement.";
        header("Location: updateAccount.php");
        exit;
    }
    $stmt->bind_param("ss", $new_email, $current_email);
}

if ($stmt->execute()) {
    $_SESSION['user_email'] = $new_email; // Update session email
    $_SESSION["update_success"] = "Account updated successfully!";
} else {
    $_SESSION["update_error"] = "Failed to update account. Please try again.";
}

$stmt->close();
$store_db->disconnect();

header("Location: updateAccount.php");
exit;
?>