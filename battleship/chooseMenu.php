<?php
session_start();

// Check if there's a user logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: Home.php'); // Redirect to login page if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Choose Menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?></h1>
    <p>Choose your interface:</p>
    <div class="button-container">
        <form action="Admin.php" method="post">
            <button type="submit">Admin Menu</button>
        </form>
        <form action="User.php" method="post">
            <button type="submit">User Menu</button>
        </form>
    </div>
</body>
</html>

