<?php
include("db_connection.php");

$result = $conn->query("SELECT s.name, s.room_no FROM attendance a JOIN students s ON a.student_id = s.id WHERE a.status = 'Absent' AND date = CURDATE()");

$absentees = [];
while ($row = $result->fetch_assoc()) {
    $absentees[] = "{$row['name']} (Room {$row['room_no']})";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h3>Attendance Submitted Successfully!</h3>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Final Attendance</title>
</head>
<body>
    <h2>Final Absentees List</h2>
    <?php if (!empty($absentees)): ?>
        <ul>
            <?php foreach ($absentees as $absent): ?>
                <li><?php echo $absent; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No absentees today.</p>
    <?php endif; ?>

    <form method="post">
        <button type="submit">Submit Final Attendance</button>
    </form>
</body>
</html>