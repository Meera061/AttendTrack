<?php
header("Content-Type: application/json");

// Database connection (update credentials as needed)
$host = "localhost";
$user = "root"; // Change if using a different database user
$pass = "";
$dbname = "your_database_name"; // Change to your actual database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Check if 'ro_ber' is set in the request
if (!isset($_GET['ro_ber'])) {
    echo json_encode(["error" => "Room number is missing"]);
    exit();
}

$roomNumber = intval($_GET['ro_ber']); // Convert to integer for security

// Fetch students based on the room number
$sql = "SELECT id, name FROM students WHERE room_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $roomNumber);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

$stmt->close();
$conn->close();

// Return JSON response
echo json_encode(["status" => "success", "students" => $students]);
?>