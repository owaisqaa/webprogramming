<?php
include 'db_connect.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "SELECT * FROM tasks WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['success' => false, 'message' => 'Task not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Task ID is required.']);
}
?>
