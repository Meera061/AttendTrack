<?php
include 'db_connection.php'; // Database connection

// Fetch today's absentees
$todayQuery = "SELECT student_name FROM attendance WHERE status = 'Absent' AND DATE(date) = CURDATE()";
$todayResult = mysqli_query($conn, $todayQuery);

echo "<h2>Currently Absent Students</h2>";

if (mysqli_num_rows($todayResult) > 0) {
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($todayResult)) {
        echo "<li>" . htmlspecialchars($row['student_name']) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No students are absent currently.</p>";
}

mysqli_close($conn);
?>