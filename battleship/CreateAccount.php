<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Battleships Account</title>
    <link rel="stylesheet" href="css/create-styles.css">
    <script>
        // JavaScript to redirect after 3 seconds
        function redirectToLogin() {
            setTimeout(function() {
                window.location.href = 'Home.php';
            }, 3000); // 3000 milliseconds = 3 seconds
        }
    </script>
</head>
<body>
    <h1>Create Your Battleships Account</h1>

    <div class="form-container">
        <form action="CreateAccountHandler.php" method="post">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Register">
            <span id="error"><?php echo isset($_SESSION['register_error']) ? $_SESSION['register_error'] : "";?></span>
        </form>
    </div>

    <div id="registered">
        <?php
        if (isset($_SESSION['register_success'])) {
            echo "Successfully registered!<br> <br>";
            echo "<p>You will be redirected to the login page shortly.</p>";
            echo "<p>If you are not redirected, <a href='Home.php'>click here</a>.</p>";
            echo "<script>redirectToLogin();</script>"; // Call the redirect function
            unset($_SESSION['register_success']);
        }
        ?>
    </div>
</body>
</html>