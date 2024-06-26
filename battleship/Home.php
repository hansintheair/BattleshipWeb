<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Battleships</title>
    <link rel="stylesheet" href="css/home-styles.css">
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

    <form action="LoginHandler.php" method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Log in">
        <span id="error"><?php echo isset($_SESSION['login_error']) ? $_SESSION['login_error'] : "";?></span>
    </form>

    <div class="create-account">
        <h3>Don't have an account?</h3>
        <button type="button" onclick="location.href='CreateAccount.php'">Create Account</button>
    </div>

    <?php
        session_unset();
        session_destroy();
    ?>
    <script src="js/tile-waves.js"></script>
</body>
</html>
