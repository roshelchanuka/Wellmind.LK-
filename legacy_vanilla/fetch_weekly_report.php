<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in', 'redirect' => 'login.php']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the date 7 days ago at start of day
$sevenDaysAgo = date('Y-m-d 00:00:00', strtotime('-7 days'));
$todayEnd = date('Y-m-d 23:59:59');

$query = "SELECT mood, DATE(created_at) as log_date FROM mood_entries WHERE user_id = ? AND created_at >= ? AND created_at <= ? ORDER BY created_at ASC";

$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
    exit();
}

$stmt->bind_param("iss", $user_id, $sevenDaysAgo, $todayEnd);
$stmt->execute();
$result = $stmt->get_result();

$moodCounts = [];
$totalEntries = 0;
$loggedDates = [];

while ($row = $result->fetch_assoc()) {
    $mood = $row['mood'];
    $date = $row['log_date'];
    
    // Count for dominant mood and chart
    if (!isset($moodCounts[$mood])) {
        $moodCounts[$mood] = 0;
    }
    $moodCounts[$mood]++;
    $totalEntries++;
    
    // Track dates for streak
    if (!in_array($date, $loggedDates)) {
        $loggedDates[] = $date;
    }
}

// 1. Calculate Dominant Mood
$dominantMood = '-';
$maxCount = 0;
foreach ($moodCounts as $m => $c) {
    if ($c > $maxCount) {
        $maxCount = $c;
        $dominantMood = $m;
    }
}

// 2. Calculate Current Streak
// A streak is the number of consecutive days logged, counting backward from today or yesterday.
$streak = 0;
$currentDate = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));

// If today isn't logged, check if yesterday was. If neither, streak is 0.
$checkDate = $currentDate;
if (!in_array($currentDate, $loggedDates)) {
    if (in_array($yesterday, $loggedDates)) {
        $checkDate = $yesterday;
    } else {
        $checkDate = null; // No streak
    }
}

if ($checkDate !== null) {
    // Count days backward
    while (in_array($checkDate, $loggedDates)) {
        $streak++;
        $checkDate = date('Y-m-d', strtotime($checkDate . ' -1 day'));
        if ($streak > 365) break; // sanity safeguard
    }
}

// 3. Prepare Chart Data
// Return sorted so the highest columns aren't randomly placed, or just random order.
$chartData = [];
foreach ($moodCounts as $mood => $count) {
    // Generate a color based on mood roughly, or default
    $color = '#2ECC71'; // Default green
    $mLower = strtolower($mood);
    if (strpos($mLower, 'sad') !== false || strpos($mLower, 'cry') !== false) $color = '#3498DB';
    elseif (strpos($mLower, 'angry') !== false || strpos($mLower, 'mad') !== false) $color = '#E74C3C';
    elseif (strpos($mLower, 'stress') !== false || strpos($mLower, 'anxious') !== false) $color = '#E67E22';
    elseif (strpos($mLower, 'happy') !== false || strpos($mLower, 'excited') !== false) $color = '#F1C40F';
    elseif (strpos($mLower, 'calm') !== false || strpos($mLower, 'relax') !== false) $color = '#9B59B6';

    $chartData[] = [
        'mood' => ucfirst($mood),
        'count' => $count,
        'percentage' => $totalEntries > 0 ? round(($count / $totalEntries) * 100) : 0,
        'color' => $color
    ];
}

// Sort chart data ascending by count for better visual
usort($chartData, function($a, $b) {
    return $b['count'] <=> $a['count'];
});

// 4. Determine AI Text
$aiText = "You haven't logged any moods in the past 7 days. Start logging to uncover your emotional patterns!";
if ($totalEntries > 0) {
    if ($streak >= 3) {
        $aiText = "Amazing consistency! Tracking your mood regularly helps build robust emotional self-awareness. Your dominant mood lately is '$dominantMood'.";
    } else {
        $aiText = "Based on your logs this week, your most frequent emotional state is '$dominantMood'. Remember, every feeling is valid. Try tracking more consistently to see clearer patterns.";
    }
}

echo json_encode([
    'status' => 'success',
    'data' => [
        'dominantMood' => $dominantMood,
        'totalEntries' => $totalEntries,
        'streak' => $streak,
        'chartData' => $chartData,
        'aiText' => $aiText
    ]
]);

$stmt->close();
$conn->close();
?>
