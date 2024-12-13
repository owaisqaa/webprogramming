<?php
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$taskId = $data['id'] ?? null;

if ($taskId) {
    $sql = "DELETE FROM tasks WHERE id = $taskId";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Task deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Task ID is required.']);
}
?>
