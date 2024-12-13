<?php
include 'db_connect.php';

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? null; // Allow null for optional description
    $dueDate = $_POST['dueDate'] ?? '';
    $status = $_POST['status'] ?? '';

    // Validate that the due date is today or in the future
    $currentDate = date('Y-m-d');
    if ($dueDate < $currentDate) {
        die('Error: Due Date cannot be in the past.');
    }

    // Insert task into the database
    $sql = "INSERT INTO tasks (title, description, due_date, status) VALUES ('$title', " . 
           ($description ? "'$description'" : "NULL") . ", '$dueDate', '$status')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.html");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
