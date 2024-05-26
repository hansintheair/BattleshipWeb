<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: Home.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Menu</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/accountMenu.js"></script>
</head>
<body>
    <h1>Account Menu</h1>
    <div class="form-container">
        <form action="AccountMenuHandler.php" method="post" id="account-menu-form">
            <label for="new_email">Change Email:</label>
            <input type="email" name="new_email" required>
            <button type="submit" name="action" value="change_email">Update Email</button>
        </form>
        <form action="AccountMenuHandler.php" method="post" id="account-menu-form">
            <label for="new_password">Update Password:</label>
            <input type="password" name="new_password" required>
            <button type="submit" name="action" value="update_password">Update Password</button>
        </form>
        <form action="AccountMenuHandler.php" method="post" id="account-menu-form">
            <button type="submit" name="action" value="delete_account">Delete Account</button>
        </form>
        <form action="userDashboard.php" method="post">
            <button type="submit">Go Back</button>
        </form>
        <span id="error"><?php echo isset($_SESSION['account_error']) ? $_SESSION['account_error'] : "";?></span>


    </div>
</body>
</html>