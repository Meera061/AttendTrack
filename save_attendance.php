<?php
include 'db_connection.php'; // Database connection

// --------------------
// 1. Create tables if not exists
// --------------------

// Attendance table
$createAttendanceTable = "
CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_no VARCHAR(50) NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    class VARCHAR(50) NOT NULL,
    section VARCHAR(50) NOT NULL,
    status ENUM('Present','Absent') NOT NULL,
    date DATETIME NOT NULL,
    UNIQUE KEY unique_attendance (room_no, date)
)";
mysqli_query($conn, $createAttendanceTable);

// Absent students history table
$createAbsentTable = "
CREATE TABLE IF NOT EXISTS absent_students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_no VARCHAR(50) NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    class VARCHAR(50) NOT NULL,
    section VARCHAR(50) NOT NULL,
    date DATETIME NOT NULL
)";
mysqli_query($conn, $createAbsentTable);

// --------------------
// 2. Handle POST attendance submission
// --------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['attendance'])) {
    foreach ($_POST['attendance'] as $room_no => $status) {
        $room_no = mysqli_real_escape_string($conn, $room_no);
        $status = mysqli_real_escape_string($conn, $status);

        // Get student details
        $studentQuery = "SELECT student_name, class, section FROM students WHERE room_no = '$room_no'";
        $studentResult = mysqli_query($conn, $studentQuery);

        if ($studentRow = mysqli_fetch_assoc($studentResult)) {
            $studentName = $studentRow['student_name'];
            $class = $studentRow['class'];
            $section = $studentRow['section'];
        } else {
            continue; // Skip if student not found
        }

        // Insert or update attendance
        $query = "INSERT INTO attendance (room_no, student_name, class, section, status, date)
                  VALUES ('$room_no', '$studentName', '$class', '$section', '$status', NOW())
                  ON DUPLICATE KEY UPDATE status='$status', date=NOW()";
        mysqli_query($conn, $query);

        // Insert into absent_students if absent
        if ($status === "Absent") {
            $historyQuery = "INSERT INTO absent_students (room_no, student_name, class, section, date)
                             VALUES ('$room_no', '$studentName', '$class', '$section', NOW())";
            mysqli_query($conn, $historyQuery);
        }
    }

    echo "<p style='text-align:center; font-size:18px; color: green;'>Attendance saved successfully!</p>";
}

// --------------------
// 3. Fetch today's absent students
// --------------------
$absentQuery = "
SELECT s.student_name, s.class, s.section
FROM students s
LEFT JOIN attendance a ON s.room_no = a.room_no AND DATE(a.date) = CURDATE()
WHERE a.status = 'Absent'";
$absentResult = mysqli_query($conn, $absentQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Today's Absent Students</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #3498db, #2ecc71);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0;
    padding: 20px;
    text-align: center;
    color: black;
}
h2 {
    font-size: 32px;
    text-shadow: 2px 2px 5px rgba(0,0,0,0.3);
    margin-bottom: 20px;
}
ul {
    list-style-type: none;
    padding: 0;
    margin: 20px 0;
    background: rgba(255,255,255,0.1);
    padding: 15px;
    border-radius: 10px;
    max-width: 400px;
    width: 90%;
}
ul li {
    font-size: 18px;
    padding: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}
ul li:last-child {
    border-bottom: none;
}
p {
    font-size: 18px;
    background: rgba(255,255,255,0.1);
    padding: 10px 15px;
    border-radius: 8px;
    max-width: 400px;
    width: 90%;
}
</style>
</head>
<body>

<h2>Today's Absent Students</h2>

<?php
if (mysqli_num_rows($absentResult) > 0) {
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($absentResult)) {
        echo "<li>" . htmlspecialchars($row['student_name']) . 
             " - Class: " . htmlspecialchars($row['class']) . 
             " - Section: " . htmlspecialchars($row['section']) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No students are absent today.</p>";
}

mysqli_close($conn);
?>
</body>
</html>
