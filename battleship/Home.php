<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Battleships</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="errors.css">
    </head>

    <body>
        <h1>Battleships</h1>
        
        <div>
            <form action="LoginHandler.php" method="post">
                E-mail: <input type="email" name="email" required><br>
                Password: <input type="password" name="password" required><br>
                <input type="submit" value="Log in">
                <span id="error"><?php echo isset($_SESSION['login_error']) ? $_SESSION['login_error'] : "";?></span>
            </form>
        </div>

        <div>
            <h3>Don't have an account?</h3>
            <button type="button" onclick="location.href='\CreateAccount.php'">Create Account</button>
        </div>
        
        <?php
            session_unset();
            session_destroy();
        ?>
        
    </body>
    
</html>

