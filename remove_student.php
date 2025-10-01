<?php
include "db_connection.php"; // Include database connection

// Check if a student is being removed
if (isset($_GET['remove'])) {
    $room_no = mysqli_real_escape_string($conn, $_GET['remove']);

    // Delete student from the database
    $query = "DELETE FROM students WHERE room_no = '$room_no'";
    if (mysqli_query($conn, $query)) {
        echo "<script>window.location.href='remove_student.php';</script>"; // Auto-refresh
        exit();
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch students sorted by room_no
$query = "SELECT * FROM students ORDER BY room_no ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Remove Student</title>
<style>
/* General Styling */
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #3498db, #2ecc71); /* Gradient Background */
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0;
    padding: 20px;
    color: white;
    text-align: center;
}
h2 {
    margin-top: 20px;
    font-size: 30px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

/* Student List Styling */
.student-list {
    width: 80%;
    margin-top: 20px;
}

.student-list table {
    width: 100%;
    border-collapse: collapse;
    color: black;
}

.student-list th, .student-list td {
    padding: 10px;
    text-align: center;
}

.student-list th {
    background: rgba(255, 255, 255, 0.3);
    font-weight: bold;
}

.student-list tr:nth-child(even) {
    background: rgba(255, 255, 255, 0.1);
}

/* Remove Button Styling */
.remove-btn {
    color: white;
    text-decoration: none;
    background: red;
    padding: 5px 10px;
    border-radius: 5px;
    transition: 0.3s;
    font-weight: bold;
}

.remove-btn:hover {
    background: darkred;
}
</style>
</head>
<body>
<h2>Remove Student</h2>

<div class="student-list">
    <table>
        <tr>
            <th>Room No</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>Section</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['room_no']); ?></td>
                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                <td><?php echo htmlspecialchars($row['class']); ?></td>
                <td><?php echo htmlspecialchars($row['section']); ?></td>
                <td>
                    <a href="remove_student.php?remove=<?php echo urlencode($row['room_no']); ?>" 
                       class="remove-btn" 
                       onclick="return confirm('Are you sure you want to remove this student?');">
                       Remove
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
