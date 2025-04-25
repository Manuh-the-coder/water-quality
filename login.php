<?php
session_start();
$_SESSION['user_id'] = $user_id_from_db; // Store user ID after login
include 'db_connect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if user exists in the database
    $stmt = $conn->prepare("SELECT id, name, email, phone, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the entered password with the hashed password in the database
        if (password_verify($password, $user["password"])) {
            // Start session and store user data
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["user_phone"] = $user["phone"];
            $_SESSION["login_time"] = date("Y-m-d H:i:s");

            // Redirect to the index page (Main page), instead of the customer profile page
            header("Location: index.html"); // Redirect to the main page (index.html)
            exit();
        } else {
            // Password incorrect
            echo "<script>alert('Incorrect password!'); window.history.back();</script>";
        }
    } else {
        // User not found
        echo "<script>alert('User not found!'); window.history.back();</script>";
    }
    $stmt->close();
    $conn->close();
}
?>
