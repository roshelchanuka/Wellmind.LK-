<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
    $feedback_text = isset($_POST['feedback_text']) ? trim($_POST['feedback_text']) : '';
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;

    if (empty($user_name) || empty($feedback_text)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO support_messages (user_name, feedback_text, rating, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("ssi", $user_name, $feedback_text, $rating);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
