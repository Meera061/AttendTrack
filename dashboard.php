<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3498db, #2ecc71);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        /* Dashboard Container */
        .dashboard-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }

        /* Heading */
        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Button Styling */
        .menu {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn {
            text-decoration: none;
            background: #3498db;
            color: white;
            padding: 12px;
            border-radius: 5px;
            transition: 0.3s;
            font-size: 16px;
        }

        .btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <div class="menu">
            <a href="take_attendance.php" class="btn">Take Attendance</a>
            <a href="add_student.php" class="btn">Add Student</a>
            <a href="remove_student.php" class="btn">Remove Student</a>
            <a href="history.php" class="btn">History of Attendance</a>
        </div>
    </div>
</body>
</html>