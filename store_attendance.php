<?php
include "db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['attendance'])) {
    echo json_encode(["error" => "Invalid data"]);
    exit();
}

foreach ($data['attendance'] as $entry) {
    $student_id = intval($entry['student_id']);
    $status = mysqli_real_escape_string($conn, $entry['status']);

    $query = "INSERT INTO attendance (student_id, status) VALUES ('$student_id', '$status')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo json_encode(["error" => "Database error: " . mysqli_error($conn)]);
        exit();
    }
}

echo json_encode(["success" => true]);
?>