<?php
$servername = "localhost";
$username = "root";
$password = "meera_682005"; // your MySQL password
$database = "jason";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
