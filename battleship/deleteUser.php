<?php
session_start();

require 'BattleshipsDB.php';


$store_db = new BattleshipsDB();
$store_db->connect();

$action = $_POST['action'] ?? '';

if ($action == 'delete_user') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if ($email == $_SESSION['user_email']) {
        $_SESSION['delete_error'] = "You cannot delete your own account.";
        header("Location: deleteUser.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['delete_error'] = "Invalid email format";
        header("Location: deleteUser.php");
        exit;
    }

    $exists = $store_db->checkUserExists($email);
    if (!$exists) {
        $_SESSION['delete_error'] = "User does not exist.";
        header("Location: deleteUser.php");
        exit;
    }

    $result = $store_db->deleteUserByEmail($email);
    if ($result) {
        unset($_SESSION['delete_error']);
        $_SESSION['delete_success'] = "User account has been deleted.";
    } else {
        $_SESSION['delete_error'] = "Failed to delete user. Please try again.";
    }

    header("Location: deleteUser.php");
    exit;
}

$store_db->disconnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="css/create-styles.css">
</head>
<body>
    <h1>Delete User</h1>
    <div class="form-container">
        <form action="deleteUser.php" method="post">
            <label for="email">Enter User E-mail to Delete:</label>
            <input type="email" id="email" name="email" required>
            <input type="hidden" name="action" value="delete_user">
            <input type="submit" value="Delete">
            <span id="error"><?php echo isset($_SESSION['delete_error']) ? $_SESSION['delete_error'] : "";?></span>
        </form>
    </div>

    <div id="deleted">
        <?php
        if (isset($_SESSION['delete_success'])) {
            echo "User account has been deleted.<br> <br>";
            echo "<form action='Admin.php' method='post'>";
            echo "<input type='submit' value='Return to Admin Menu'>";
            echo "</form>";
            unset($_SESSION['delete_success']);
        }
        ?>
    </div>
</body>
</html>