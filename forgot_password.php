<?php
session_start(); // Start session at the top

include 'db_connection.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $_SESSION['reset_username'] = $_POST['username']; // Store username in session
    header("Location: forgot_password.php"); // Reload page to keep session
    exit();
}

// If session is not set, show error
if (!isset($_SESSION['reset_username'])) {
    die("<script>alert('No user session found. Please enter your username again.'); window.location='forgot_password_form.php';</script>");
}

$username = $_SESSION['reset_username'];
$reset_code = "682005"; // Hardcoded reset code

// Handle reset code verification and password reset
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code']) && isset($_POST['new_password'])) {
    if ($_POST['code'] === $reset_code) {
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Hash the password

        // Update password in database
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE username = ?");
        $stmt->bind_param("ss", $new_password, $username);
        
        if ($stmt->execute()) {
            session_destroy(); // Destroy session after password reset
            echo "<script>alert('Password reset successful! Please log in.'); window.location='login.php';</script>";
            exit();
        } else {
            echo "Error updating password.";
        }
    } else {
        echo "<script>alert('Invalid reset code.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        <h2>Reset Your Password</h2>
        <form method="POST">
            <label>Enter Reset Code:</label>
            <input type="text" name="code" required>
            <label>Enter New Password:</label>
            <input type="password" name="new_password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>