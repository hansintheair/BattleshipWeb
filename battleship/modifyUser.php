<?php
session_start();

require 'BattleshipsDB.php';

// Check if user is logged in and is an admin
//if (!isset($_SESSION['user_email']) || !$_SESSION['is_admin']) {
  //  header('Location: Home.php');
    //exit;
//}

$store_db = new BattleshipsDB();
$store_db->connect();

$action = $_POST['action'] ?? '';
$email = $_POST['email'] ?? '';

if ($action == 'find_user') {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['modify_error'] = "Invalid email format";
        header("Location: modifyUser.php");
        exit;
    }

    if ($email == $_SESSION['user_email']) {
        $_SESSION['modify_error'] = "You cannot update your own account here. Refer to the user menu.";
        header("Location: modifyUser.php");
        exit;
    }

    $user = $store_db->getUser($email);
    if (!$user) {
        $_SESSION['modify_error'] = "User does not exist.";
        header("Location: modifyUser.php");
        exit;
    }

    $_SESSION['modify_user'] = $user;
    header("Location: modifyUser.php");
    exit;
}

if ($action == 'update_user') {
    $user = $_SESSION['modify_user'];

    // Update only the fields that have been changed
    if (isset($_POST['new_email']) && !empty($_POST['new_email'])) {
        $new_email = filter_input(INPUT_POST, 'new_email', FILTER_SANITIZE_EMAIL);
        if (filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $user['email'] = $new_email;
        } else {
            $_SESSION['modify_error'] = "Invalid email format";
        }
    } else {
        $user['email'] = $_SESSION['modify_user']['email']; // retain original email
    }

    if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
        $new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);
        $passwordpattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{7,}$/';
        if (preg_match($passwordpattern, $new_password)) {
            $user['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        } else {
            $_SESSION['modify_error'] = "Password must contain at least one lowercase letter, one uppercase letter, and one number.";
        }
    } else {
        $user['password'] = $_SESSION['modify_user']['password']; // retain original password
    }

    if (isset($_POST['is_admin'])) {
        $user['isAdmin'] = 1;
    } else {
        $user['isAdmin'] = 0;
    }

    if (isset($_POST['wins'])) {
        $user['wins'] = filter_input(INPUT_POST, 'wins', FILTER_VALIDATE_INT);
    }

    if (isset($_POST['losses'])) {
        $user['losses'] = filter_input(INPUT_POST, 'losses', FILTER_VALIDATE_INT);
    }

    // Update user in the database
    $result = $store_db->updateUser($user);

    if ($result) {
        $_SESSION['modify_user'] = $user;
        $_SESSION['modify_success'] = "User account has been updated.";
    } else {
        $_SESSION['modify_error'] = "Failed to update user. Please try again.";
    }

    header("Location: modifyUser.php");
    exit;
}

$store_db->disconnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify User</title>
    <link rel="stylesheet" href="css/modify-styles.css">
</head>
<body>
    <h1>Modify User</h1>
    <div class="form-container">
        <form action="Admin.php" method="post" style="margin-bottom: 20px;">
            <input type="submit" value="Return to Admin Menu">
        </form>
        <?php if (!isset($_SESSION['modify_user'])): ?>
        <form action="modifyUser.php" method="post">
            <label for="email">Enter User E-mail to Modify:</label>
            <input type="email" id="email" name="email" required>
            <input type="hidden" name="action" value="find_user">
            <input type="submit" value="Find User">
            <span id="error"><?php echo isset($_SESSION['modify_error']) ? $_SESSION['modify_error'] : "";?></span>
        </form>
        <?php else: ?>
        <?php $user = $_SESSION['modify_user']; ?>
        <p><strong>User Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <form action="modifyUser.php" method="post">
            <label for="new_email">New Email:</label>
            <input type="email" id="new_email" name="new_email">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password">
            <label for="is_admin">Admin Status:</label>
            <input type="checkbox" id="is_admin" name="is_admin" <?php echo isset($user['isAdmin']) && $user['isAdmin'] ? 'checked' : ''; ?>>
            <label for="wins">Wins:</label>
            <input type="number" id="wins" name="wins" value="<?php echo htmlspecialchars($user['wins'] ?? 0); ?>">
            <label for="losses">Losses:</label>
            <input type="number" id="losses" name="losses" value="<?php echo htmlspecialchars($user['losses'] ?? 0); ?>">
            <input type="hidden" name="action" value="update_user">
            <input type="submit" value="Update User">
            <span id="error"><?php echo isset($_SESSION['modify_error']) ? $_SESSION['modify_error'] : "";?></span>
        </form>
        <?php endif; ?>
    </div>

    <div id="updated">
        <?php
        if (isset($_SESSION['modify_success'])) {
            echo "User account has been updated.<br> <br>";
            unset($_SESSION['modify_success']);
        }
        ?>
    </div>
</body>
</html>