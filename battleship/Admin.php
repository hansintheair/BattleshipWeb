<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu</title>
    <link rel="stylesheet" href="css/home-styles.css">
</head>
<body>
    <h1>Admin Menu</h1>
    <div class="menu-container">
        <form action="viewUsers.php" method="post">
            <button type="submit">View All Users</button>
        </form>
        <form action="addUser.php" method="post">
            <button type="submit">Add User</button>
        </form>
        <form action="deleteUser.php" method="post">
            <button type="submit">Delete User</button>
        </form>
        <form action="modifyUser.php" method="post">
            <button type="submit">Modify User</button>
        </form>
        <form action="Home.php" method="post">
            <button type="submit">Exit Menu</button>
        </form>
    </div>
</body>
</html>