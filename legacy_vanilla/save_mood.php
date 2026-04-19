<?php
session_start();
require_once 'db_connect.php';

// Set header to return JSON
header('Content-Type: application/json');

// Get POST data
$rawData = file_get_contents('php://input');
$input = json_decode($rawData, true);

if ($input === null && json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => 'JSON Decode Error: ' . json_last_error_msg(), 'raw_data' => $rawData]);
    exit();
}

if (!$input || !isset($input['mood'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input - mood is required', 'received' => $input]);
    exit();
}

$mood = $input['mood'];
$note = isset($input['note']) ? $input['note'] : '';
$lang = isset($input['lang']) ? $input['lang'] : 'unknown';

// Log for debugging
file_put_contents('debug_log.txt', "[" . date('Y-m-d H:i:s') . "] Request received (lang: $lang): " . json_encode($input) . "\n", FILE_APPEND);

// Handle user_id (if logged in)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Save to database
$sql = "INSERT INTO mood_entries (user_id, mood, note) VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
    exit();
}

// "iss" -> user_id (int or null), mood (string), note (string)
// Note: mysqli bind_param doesn't support null for 'i' directly in a clean way without call_user_func_array if we want it to be truly NULL in DB, 
// but if we pass a variable that is null, it usually works if the column allows it.
$stmt->bind_param("iss", $user_id, $mood, $note);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Mood saved successfully',
        'id' => $stmt->insert_id
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error saving mood: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
