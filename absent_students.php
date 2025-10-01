<?php
include 'config.php'; // Include database connection

// Fetch all students
$studentsQuery = "SELECT id, student_name FROM students";
$studentsResult = mysqli_query($conn, $studentsQuery);

$absentStudents = [];

while ($row = mysqli_fetch_assoc($studentsResult)) {
    $student_id = $row['id'];

    // Check if the student was marked as Absent today
    $checkAttendance = "SELECT status FROM attendance WHERE student_id = '$student_id' AND DATE(date) = CURDATE()";
    $result = mysqli_query($conn, $checkAttendance);
    $attendance = mysqli_fetch_assoc($result);

    if (!$attendance || $attendance['status'] === 'Absent') {
        $absentStudents[] = $row['student_name'];
    }
}

echo "<h2>Absent Students</h2>";
if (count($absentStudents) > 0) {
    echo "<ul>";
    foreach ($absentStudents as $student) {
        echo "<li>" . htmlspecialchars($student) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No absent students today.</p>";
}

mysqli_close($conn);
?>