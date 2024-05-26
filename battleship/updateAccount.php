<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
    <title>Update Account</title>
    <link rel="stylesheet" href="css/update-styles.css">
    <script>
        function redirectToHome() {
            setTimeout(function() {
                window.location.href = 'Home.php';
            }, 3000); // 3000 milliseconds = 3 seconds
        }
    </script>

</head>
<body>
    <h1>Update Account</h1>
    <form action="updateAccountHandler.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['EMAIL']); ?>" required><br>
        <label for="password">Password (leave blank if not changing):</label>
        <input type="password" id="password" name="password"><br>
        <button type="submit" name="action" value="update">Update</button>
        <button type="submit" name="action" value="delete">Delete Account</button>

        <span id="error"><?php echo isset($_SESSION['update_error']) ? $_SESSION['update_error'] : ""; ?></span>
        <span id="success"><?php echo isset($_SESSION['update_success']) ? $_SESSION['update_success'] : ""; ?></span>
    </form>
    <button onclick="window.location.href='user.php'">Back to Dashboard</button>

    <div id="updated">
        <?php
        if (isset($_SESSION['update_success'])) {
            echo $_SESSION['update_success'] . "<br> <br>";
            unset($_SESSION['update_success']);
        }
        ?>
    </div>
    <div id="deleted">
        <?php
        if (isset($_SESSION['delete_success'])) {
            echo $_SESSION['delete_success'] . "<br> <br>";
            echo "<script>redirectToHome();</script>";
            unset($_SESSION['delete_success']);
        }
        ?>
    </div>
</body>
</html>

<?php
unset($_SESSION['update_error']);
?>