<?php

session_start();

include "BattleshipsDB.php";

$store_db = new BattleshipsDB();

// Sanitize for security
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

$pattern = '/^[^@.]+(?:\.[^@.]+)*@[^@.]+\.[^@.]{2,}(?:\.[^@.]{2,})*$/';
$passwordpattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{7,}$/';

if (!preg_match($pattern, $email)) {
    $_SESSION["register_error"] = "Invalid email format";
    header("Location: CreateAccount.php");
    exit;
}

if (!preg_match($passwordpattern, $password)) {
    $_SESSION["register_error"] = "Password must contain at least one lowercase letter, one uppercase letter, and one number";
    header("Location: CreateAccount.php");
    exit;
}

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

// Store user data
$password_hashed = password_hash($password, PASSWORD_DEFAULT);  // Hash password for security
$store_db->connect();
$store_db->addUser($email, $password_hashed);
$store_db->disconnect();

$_SESSION["register_success"] = true;
header("Location: CreateAccount.php");

 