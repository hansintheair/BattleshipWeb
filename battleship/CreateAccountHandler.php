<?php

session_start();

include "BattleshipsDB.php";

$store_db = new BattleshipsDB();

// Sanitize for security
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

//echo "PASSWORD: ".$password."<br>";  //DEBUG
//echo "EMAIL: ".$email."<br>";  //DEBUG

// Check if user is already in the database
$store_db->connect();
$exists = $store_db->checkUserExists($email);
$store_db->disconnect();
if ($exists) {
    $_SESSION["register_error"] = "A user with that e-mail already exists";
    header("Location: CreateAccount.php");
    exit;
}

// Validate password
if (!$password) {  //TODO: Could use some extra validation
    $_SESSION["register_error"] = "Bad password";
    header("Location: CreateAccount.php");
    exit;
}

// Store user data
$password_hashed = password_hash($password, PASSWORD_DEFAULT);  // Hash password for security
$store_db->connect();
$store_db->addUser($email, $password_hashed);
$store_db->disconnect();

$_SESSION["register_success"] = true;
header("Location: CreateAccount.php");

 