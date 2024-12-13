<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $dueDate = $_POST['dueDate'] ?? '';
    $status = $_POST['status'] ?? '';

    if ($id && $title && $description && $dueDate && $status) {
        $sql = "UPDATE tasks SET 
                title = '$title', 
                description = '$description', 
                due_date = '$dueDate', 
                status = '$status' 
                WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Task updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
