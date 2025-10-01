<?php
include 'db_connection.php'; // Database connection

// Fetch attendance history for absent students
$query = "SELECT student_name, date FROM attendance WHERE status = 'Absent' ORDER BY date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance History</title>
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
            margin-bottom: 20px;
            font-size: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Table Styling */
        .attendance-table {
            width: 80%;
            border-collapse: collapse;
            color: black;
            font-weight: black;
        }

        .attendance-table th, .attendance-table td {
            padding: 10px;
            text-align: center;
        }

        .attendance-table th {
            background: rgba(255, 255, 255, 0.3);
            font-weight: bold;
        }

        .attendance-table tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.1);
        }

        .attendance-table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>

<h2>Absent Students History</h2>

<table class="attendance-table">
    <tr>
        <th>Student Name</th>
        <th>Date</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
            <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>

<?php mysqli_close($conn); ?>