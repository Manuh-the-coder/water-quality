<?php
// Database configuration
$host     = "localhost";
$dbname   = "water-quality";
$username = "root";
$password = "";

// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

// Retrieve data (GET or POST)
$user_id   = $_REQUEST['user_id'] ?? null;
$ph        = $_REQUEST['ph'] ?? null;
$turbidity = $_REQUEST['turbidity'] ?? null;
$tds       = $_REQUEST['tds'] ?? null;

// Validate input
if (!is_null($user_id) && !is_null($ph) && !is_null($turbidity) && !is_null($tds)) {

    // Prepare SQL statement to safely insert data
    $stmt = $conn->prepare("
        INSERT INTO sensor_data (user_id, ph, turbidity, tds, timestamp)
        VALUES (?, ?, ?, ?, NOW())
    ");

    if (!$stmt) {
        echo json_encode([
            "success" => false,
            "message" => "Prepare failed: " . $conn->error
        ]);
        exit;
    }

    // Bind and execute
    $stmt->bind_param("iddd", $user_id, $ph, $turbidity, $tds);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Data inserted successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Execute failed: " . $stmt->error
        ]);
    }

    $stmt->close();

} else {
    // Missing or incomplete input
    echo json_encode([
        "success" => false,
        "message" => "Missing required parameters: user_id, ph, turbidity, or tds"
    ]);
}

$conn->close();
?>
