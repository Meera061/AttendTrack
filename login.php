<?php
session_start();
include 'db_connection.php'; // Make sure this file connects correctly to your 'jason' DB

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Case-insensitive username check
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify hashed password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            echo "<script>alert('Login successful!'); window.location='dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid password'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.location='login.php';</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3498db, #2ecc71);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
            width: 350px;
            text-align: center;
        }
        h2 {
            color: white;
            font-size: 28px;
            margin-bottom: 15px;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.3);
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background: rgba(255,255,255,0.2);
            color: white;
            outline: none;
        }
        input::placeholder {
            color: rgba(255,255,255,0.7);
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #ffffff;
            color: #3498db;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #2ecc71;
            color: white;
        }
        a {
            display: block;
            margin-top: 15px;
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <a href="forgot_password.php">Forgot Password?</a>
</div>
</body>
</html>
