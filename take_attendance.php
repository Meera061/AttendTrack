<?php
include 'db_connection.php'; // Include database connection

// Fetch all students
$query = "SELECT room_no, student_name, class, section FROM students ORDER BY class, section, student_name";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Take Attendance</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg,rgb(62, 156, 218), #2ecc71);
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
    font-size: 32px;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    margin-bottom: 20px;
    font-weight: bold;
    color: rgb(250, 239, 239);
}

table {
    width: 90%;
    max-width: 800px;
    border-collapse: collapse;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 20px;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    text-align: center;
    font-weight: bold;
    color: black;
}

th {
    background: rgba(255, 255, 255, 0.2);
}

tr:nth-child(even) {
    background: rgba(255, 255, 255, 0.15);
}

input[type="radio"] {
    transform: scale(1.3);
    margin: 5px;
}

button {
    background: rgb(0, 6, 190);
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s;
    font-weight: bold;
}

button:hover {
    background: #0056b3;
    box-shadow: 0px 0px 10px #007bff;
}
</style>
</head>
<body>

<h2>Take Attendance</h2>

<form action="save_attendance.php" method="POST">
    <table>
        <tr>
            <th>Room No</th>
            <th>Name</th>
            <th>Class - Section</th>
            <th>Present</th>
            <th>Absent</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['room_no']); ?></td>
                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                <td><?php echo htmlspecialchars($row['class'] . " - " . $row['section']); ?></td>
                <td><input type="radio" name="attendance[<?php echo $row['room_no']; ?>]" value="Present" checked></td>
                <td><input type="radio" name="attendance[<?php echo $row['room_no']; ?>]" value="Absent"></td>
            </tr>
        <?php } ?>
    </table>
    <button type="submit">Submit Attendance</button>
</form>

</body>
</html>
