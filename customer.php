<?php
session_start(); // Start the session

// Check if the user is logged in by verifying the session variables
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" href="customer.css">
</head>
<body>
    <div class="container">
        <h1>Customer Profile</h1>
        
        <!-- Display logged-in customer details -->
        <div class="customer-info">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION["user_name"]); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION["user_email"]); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($_SESSION["user_phone"]); ?></p>
            <p><strong>Last Login:</strong> <?php echo htmlspecialchars($_SESSION["login_time"]); ?></p>
        </div>

        <!-- Links to navigate -->
        <a href="index.html">Back to Main Page</a>

        <!-- Logout button (to destroy the session and logout) -->
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
