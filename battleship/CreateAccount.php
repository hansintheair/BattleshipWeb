<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create Your Battleships Account</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="errors.css">
    </head>
    <body>
        
        <h1>Create Your Battleships Account</h1>
        
        <div>
            <form action="CreateAccountHandler.php" method="post">
                E-mail: <input type="email" name="email" required><br>
                Password: <input type="password" name="password" required><br>
                <input type="submit">
                <span id="error"><?php echo isset($_SESSION['register_error']) ? $_SESSION['register_error'] : "";?></span>
            </form>
        </div>
        
        <div id="registered">
            <?php echo isset($_SESSION['register_success']) ? "Successfully registered" : "";?>
        </div>
        
    </body>
</html>
