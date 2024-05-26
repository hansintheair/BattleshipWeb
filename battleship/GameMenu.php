<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Menu</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Game Menu</h1>
    <div class="form-container">
        <form action="GameMenuHandler.php" method="post">
            <button type="submit" name="action" value="new_campaign">New Campaign</button>
            <button type="submit" name="action" value="load_campaign">Load Campaign</button>
            <button type="submit" name="action" value="delete_campaign">Delete Campaign</button>
            <button type="submit" name="action" value="go_back">Go Back</button>
        </form>
        <span id="error"><?php echo isset($_SESSION['game_error']) ? $_SESSION['game_error'] : "";?></span>


    </div>
</body>
</html>