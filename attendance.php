<?php
include 'db_connection.php'; // Use your existing config file for connection

echo "<h2>Rooms</h2>";

// Fetch all rooms
$result = $conn->query("SELECT * FROM rooms");

echo "<table border='1'>";
echo "<tr><th>Room Number</th><th>Mark Attendance</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr onclick=\"window.location.href='attendance.php?room_id=" . $row['room_id'] . "'\" style='cursor:pointer;'>";
    echo "<td>" . htmlspecialchars($row['room_number']) . "</td>";
    echo "<td>Click to View</td></tr>";
}

echo "</table>";

if (isset($_GET['room_id'])) {
    $room_id = intval($_GET['room_id']);
    
    // Fetch students of the selected room
    $students = $conn->query("SELECT * FROM students WHERE room_id = $room_id ORDER BY roll_number");

    echo "<h2>Students in Room " . htmlspecialchars($room_id) . "</h2>";
    echo "<form method='POST' action='update_attendance.php'>";
    echo "<table border='1'>";
    echo "<tr><th>Roll Number</th><th>Name</th><th>Attendance</th></tr>";

    while ($row = $students->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['roll_number']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>
                <select name='attendance[" . $row['student_id'] . "]'>
                    <option value='Present'>Present</option>
                    <option value='Absent'>Absent</option>
                </select>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<input type='hidden' name='room_id' value='" . $room_id . "'>";
    echo "<button type='submit'>Update Attendance</button>";
    echo "</form>";
}

// Close the database connection
$conn->close();
?>