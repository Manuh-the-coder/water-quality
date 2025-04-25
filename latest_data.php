<?php
header('Content-Type: application/json');

// ✅ Define your database connection variables
$host = 'localhost';
$user = 'root';           // Default username for XAMPP
$pass = '';               // Default password is blank
$db   = 'water-quality'; // Replace this with your actual database name

// ✅ Create connection
$conn = new mysqli($host, $user, $pass, $db);

// ✅ Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// ✅ Fetch the latest sensor data
$sql = "SELECT ph, turbidity, tds, timestamp FROM sensor_data ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'No data found']);
}

$conn->close();
?>
