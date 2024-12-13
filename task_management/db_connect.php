<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Default for XAMPP, adjust if needed
$dbname = 'task_management';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
