<?php
// Database configuration
$host = "localhost";           // Your server (localhost if hosted locally)
$dbname = "water-quality";     // Your database name
$username = "root";            // Your DB username (often 'root' for local servers)
$password = "";                // Your DB password

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the sensor_data table
$sql = "SELECT user_id, ph, turbidity, tds, timestamp FROM sensor_data ORDER BY timestamp DESC LIMIT 10";  // Adjust LIMIT as needed
$result = $conn->query($sql);

// Check if data exists
if ($result->num_rows > 0) {
    // Output the data in a JSON format for use in the front end
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo "No data found";
}

$conn->close();
?>
