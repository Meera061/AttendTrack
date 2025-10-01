<?php
include "db_connection.php"; // Include database connection

// Handle Add Student
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_no = trim($_POST['room_no']);
    $student_name = trim($_POST['student_name']);
    $class = trim($_POST['class']);
    $section = trim($_POST['section']);

    if (empty($room_no) || empty($student_name) || empty($class) || empty($section)) {
        $message = "All fields are required!";
    } else {
        // Check for duplicate room_no
        $checkQuery = "SELECT * FROM students WHERE room_no = ?";
        $stmtCheck = $conn->prepare($checkQuery);
        $stmtCheck->bind_param("s", $room_no);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            $message = "Room number already exists!";
        } else {
            // Insert student
            $insertQuery = "INSERT INTO students (room_no, student_name, class, section) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssss", $room_no, $student_name, $class, $section);

            if ($stmt->execute()) {
                $message = "Student added successfully!";
            } else {
                $message = "Error adding student: " . $stmt->error;
            }
            $stmt->close();
        }
        $stmtCheck->close();
    }
}

// Fetch all students sorted by class, section, room_no
$query = "SELECT room_no, student_name, class, section FROM students ORDER BY class ASC, section ASC, room_no ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Student</title>
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
    color: white;
    text-align: center;
}
h2 { margin-top: 20px; font-size: 30px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }

form {
    background: rgba(0, 0, 0, 0.34);
    padding: 20px;
    border-radius: 10px;
    backdrop-filter: blur(5px);
    display: flex;
    flex-direction: column;
    width: 300px;
    gap: 10px;
}

label { font-size: 16px; font-weight: bold; }
input { padding: 8px; border: none; border-radius: 5px; width: 100%; }
input[type="submit"] {
    background: black;
    color: #3498db;
    padding: 12px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    transition: 0.3s;
}
input[type="submit"]:hover {
    background: rgba(125,114,114,0.34);
    color: black;
}

.message {
    margin: 15px 0;
    padding: 10px;
    border-radius: 8px;
    font-weight: bold;
    width: 300px;
    background: rgba(255,255,255,0.2);
    color: #fff;
}

.student-list {
    width: 90%;
    max-width: 800px;
    margin-top: 30px;
    color: black;
}

.student-list table { width: 100%; border-collapse: collapse; }
.student-list th, .student-list td { padding: 10px; text-align: center; }
.student-list th { background: rgba(255, 255, 255, 0.3); font-weight: bold; }
.student-list tr:nth-child(even) { background: rgba(255, 255, 255, 0.1); }
</style>
</head>
<body>

<h2>Add Student</h2>

<?php if(!empty($message)) echo "<div class='message'>{$message}</div>"; ?>

<form method="POST">
    <label>Room No:</label> 
    <input type="text" name="room_no" required>
    <label>Student Name:</label> 
    <input type="text" name="student_name" required>
    <label>Class:</label>
    <input type="text" name="class" required>
    <label>Section:</label>
    <input type="text" name="section" required>
    <input type="submit" value="Add Student">
</form>

<h2>Student List</h2>
<div class="student-list">
    <table>
        <tr>
            <th>Room No</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>Section</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['room_no']); ?></td>
                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                <td><?php echo htmlspecialchars($row['class']); ?></td>
                <td><?php echo htmlspecialchars($row['section']); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
