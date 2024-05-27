
<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: Home.php');
    exit;
}

include "BattleshipsDB.php";

$store_db = new BattleshipsDB();
$store_db->connect();

$email = $_SESSION['user_email'];
$userData = $store_db->getUser($email);

$store_db->disconnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Info</title>
    <link rel="stylesheet" href="css/home-styles.css">
</head>
<body>
    <h1>Account Info</h1>
    <p>Email: <?php echo htmlspecialchars($userData['EMAIL']); ?></p>
    <p>Wins: <?php echo htmlspecialchars($userData['wins']); ?></p>
    <p>Losses: <?php echo htmlspecialchars($userData['losses']); ?></p>
</body>
</html>