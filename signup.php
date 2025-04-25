<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];

    // Validations
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        echo "<script>alert('Phone must be exactly 10 digits'); window.history.back();</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@gmail.com')) {
        echo "<script>alert('Email must be valid and end with @gmail.com'); window.history.back();</script>";
        exit();
    }

    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password)) {
        echo "<script>alert('Password must be at least 8 characters, include a number, a letter, and a symbol'); window.history.back();</script>";
        exit();
    }

    // Check if email or phone already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR phone = ?");
    $stmt->bind_param("ss", $email, $phone);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email or phone already exists!'); window.history.back();</script>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $insert = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
    $insert->bind_param("ssss", $name, $email, $phone, $hashed_password);

    if ($insert->execute()) {
        header("Location: login.html");
        exit();
    } else {
        echo "<script>alert('Signup failed: " . $insert->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $insert->close();
    $conn->close();
}
?>
