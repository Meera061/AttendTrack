<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_name = $_POST['room_name'];
    $query = "INSERT INTO rooms (room_name) VALUES ('$room_name')";
    if ($conn->query($query)) {
        echo "Room added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Rooms</title>
</head>
<body>
    <h2>Add Room</h2>
    <form method="POST">
        <label>Room Name:</label>
        <input type="text" name="room_name" required>
        <button type="submit">Add Room</button>
    </form>
</body>
</html>