<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['timestamp'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit();
}

$user_id = $_SESSION['user_id'];
$timestamp = $input['timestamp'];
$dateStr = date('Y-m-d H:i:s', $timestamp);

// Delete the entry matching the user and the timestamp (approximate to the second)
$stmt = $conn->prepare("DELETE FROM mood_entries WHERE user_id = ? AND created_at = ?");
$stmt->bind_param("is", $user_id, $dateStr);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$stmt->close();
$conn->close();
?>
