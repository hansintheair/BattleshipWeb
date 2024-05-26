<?php
session_start();

require 'BattleshipsDB.php';

$store_db = new BattleshipsDB();
$store_db->connect();

$action = $_POST['action'] ?? '';

if ($action == 'add_user') {
    // Sanitize for security
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["register_error"] = "Invalid email format";
        header("Location: addUser.php");
        exit;
    }

    $passwordpattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{7,}$/';

    if (!preg_match($passwordpattern, $password)) {
        $_SESSION["register_error"] = "Password must contain at least one lowercase letter, one uppercase letter, and one number.";
        header("Location: addUser.php");
        exit;
    }

    // Check if user is already in the database
    $exists = $store_db->checkUserExists($email);
    if ($exists) {
        $_SESSION["register_error"] = "A user with that e-mail already exists";
        header("Location: addUser.php");
        exit;
    }

    // Since email and password are valid and user doesn't exist, set default values
    $wins = 0;
    $losses = 0;
    $isAdmin = false; // By default, users are not admins

    // Store user data
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);  // Hash password for security
    $result = $store_db->addUser($email, $password_hashed, $isAdmin, $wins, $losses);

    if (!$result) {
        $_SESSION["register_error"] = "Failed to register user. Please try again.";
        header("Location: addUser.php");
        exit;
    }

    // Clear error messages upon successful registration
    unset($_SESSION['register_error']);
    $_SESSION["register_success"] = "User added successfully!";
    header("Location: addUser.php");
    exit;
}

$store_db->disconnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="css/create-styles.css">
</head>
<body>
    <h1>Add User</h1>
    <div class="form-container">
        <form action="addUser.php" method="post">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="hidden" name="action" value="add_user">
            <input type="submit" value="Register">
            <span id="error"><?php echo isset($_SESSION['register_error']) ? $_SESSION['register_error'] : "";?></span>
        </form>
    </div>

    <div id="registered">
        <?php
        if (isset($_SESSION['register_success'])) {
            echo "User added successfully!<br> <br>";
            echo "<form action='Admin.php' method='post'>";
            echo "<input type='submit' value='Return to Admin Menu'>";
            echo "</form>";
            unset($_SESSION['register_success']);
        }
        ?>
    </div>
</body>
</html>