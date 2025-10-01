<?php
include 'db_connection.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['attendance'] as $student_id => $status) {
        $student_id = intval($student_id);
        $status = mysqli_real_escape_string($conn, $status);

        // ✅ Fetch student_name from students table
        $studentQuery = "SELECT student_name FROM students WHERE id = '$student_id'";
        $studentResult = mysqli_query($conn, $studentQuery);
        $studentRow = mysqli_fetch_assoc($studentResult);
        
        if (!$studentRow) {
            die("Error: Student not found for ID $student_id");
        }

        $student_name = mysqli_real_escape_string($conn, $studentRow['student_name']);

        // ✅ Insert into attendance table with student_name
        $query = "INSERT INTO attendance (student_id, student_name, status, date) 
                  VALUES ('$student_id', '$student_name', '$status', NOW())";

        if (!mysqli_query($conn, $query)) {
            die("Error saving attendance: " . mysqli_error($conn)); // Debugging message
        }
    }

    echo "<p>Attendance saved successfully.</p>";
}

mysqli_close($conn);
?>