<?php
include 'db_connect.php'; // Include database connection

$sql = "SELECT name, phone, address, email FROM users"; // Get users (excluding passwords)
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link rel="stylesheet" href="login.css"> <!-- Add CSS file for styling -->
</head>
<body>
    <h1>Registered Users</h1>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Email</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['email']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No users found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
