<?php
include 'db_connection.php';  

if (isset($_GET['room'])) {
    $roomNumber = $_GET['room'];
    
    $sql = "SELECT roll_no, student_name FROM students WHERE room_number = '$roomNumber'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<form action='submit_attendance.php' method='POST'>";
        echo "<table border='1'>";
        echo "<tr><th>Roll No</th><th>Student Name</th><th>Present</th><th>Absent</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['roll_no']}</td>";
            echo "<td>{$row['student_name']}</td>";
            echo "<td><input type='radio' name='attendance[{$row['roll_no']}]' value='Present' required></td>";
            echo "<td><input type='radio' name='attendance[{$row['roll_no']}]' value='Absent' required></td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<input type='hidden' name='room_number' value='$roomNumber'>";
        echo "<button type='submit'>Submit Attendance</button>";
        echo "</form>";
    } else {
        echo "<p>No students found in this room.</p>";
    }
}

$conn->close();
?>