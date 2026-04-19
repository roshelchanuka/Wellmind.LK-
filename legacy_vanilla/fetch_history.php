<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$startDate = !empty($_GET['startDate']) ? $_GET['startDate'] : null;
$endDate = !empty($_GET['endDate']) ? $_GET['endDate'] : null;

$query = "SELECT mood, note, created_at FROM mood_entries WHERE user_id = ?";
$params = [$user_id];
$types = "i";

if ($startDate) {
    $query .= " AND DATE(created_at) >= ?";
    $params[] = $startDate;
    $types .= "s";
}

if ($endDate) {
    $query .= " AND DATE(created_at) <= ?";
    $params[] = $endDate;
    $types .= "s";
}

$query .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$history = [];
while ($row = $result->fetch_assoc()) {
    $timestamp = strtotime($row['created_at']);
    $history[] = [
        'date' => date('Y-m-d', $timestamp),
        'time' => date('H:i:s', $timestamp),
        'mood' => $row['mood'],
        'note' => $row['note'],
        'timestamp' => $timestamp
    ];
}

echo json_encode($history);
$stmt->close();
$conn->close();
?>
