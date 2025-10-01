<?php
include 'db_connection.php'; // Use config.php for database connection

if (isset($_GET['room_number'])) {
    $room_number = $_GET['room_number'];
    $query = "SELECT roll_number, student_name FROM students WHERE room_number = ? ORDER BY roll_number";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $room_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $students = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }

    echo json_encode($students);
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["error" => "Room number not provided"]);
}
?>