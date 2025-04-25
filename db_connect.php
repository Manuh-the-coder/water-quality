<?php
$host = "localhost";
$user = "root";
$pass = ""; // Default is empty in XAMPP
$dbname = "water-quality"; // Ensure this matches EXACTLY with your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

echo "Database connection";
?>
