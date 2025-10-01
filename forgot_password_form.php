<?php
session_start(); // Start session at the very beginning
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px gray;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="forgot_password.php" method="POST">
            <label for="username">Enter Your Username:</label>
            <input type="text" name="username" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>