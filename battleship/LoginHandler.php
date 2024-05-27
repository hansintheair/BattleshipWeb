<?php
session_start();

include "BattleshipsDB.php";

$store_db = new BattleshipsDB();
 
// Sanitize for security
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

//echo "email: ".$email."<br>";  //DEBUG
//echo "PASSWORD: ".$password."<br>";  //DEBUG
 
// Verify user credentials
$store_db->connect();
$userdata = $store_db->getUser($email);
$store_db->disconnect();     
if (!($userdata["EMAIL"] == $email && password_verify($password, $userdata["PASSWORD"]))) {
    $_SESSION["login_error"] = "Invalid email or password";
    header("Location: Home.php");
   exit;
}
//redirect to user.php - admin display is managed there
$_SESSION["user_email"] = $email; // Store user email in session for further use
header("Location: User.php");

exit;
?>


