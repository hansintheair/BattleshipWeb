<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: Home.php');
    exit;
}

// Include the necessary database operations
include "BattleshipsDB.php";

$store_db = new BattleshipsDB();
$store_db->connect();

// Retrieve all users from the database
$query = "SELECT email, wins, losses, isAdmin FROM entity_users";
$result = $store_db->getDb()->query($query);

$users = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$store_db->disconnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/home-styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f9;
        }
        td {
            text-align: center;
        }
        td + td {
            padding-left: 20px; /* Add more space between the columns, did not want to modify home-styles, might mess with other files */
        }
    </style>
</head>
<body>
    <h1>View All Users</h1>
    <?php if (empty($users)): ?>
        <p>No users found.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Wins</th>
                    <th>Losses</th>
                    <th>Admin</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['wins']); ?></td>
                        <td><?php echo htmlspecialchars($user['losses']); ?></td>
                        <td><?php echo $user['isAdmin'] ? 'Yes' : 'No'; ?></td>
                    </tr> 
                <?php endforeach; ?>
            <br><br>
            </tbody>
        </table>
    <?php endif; ?>
    <form action="admin.php" method="post">
        <button type="submit"><i class="fas fa-arrow-left icon"></i> Back to Admin Menu</button>
    </form>
</body>
</html>