<?php
/**
 * Simple Test Script for WellMind LK Chatbot logic
 */

// Mock Session
session_start();

// Load Backend Services
// We assume they are in backend/app/Services/
require_once __DIR__ . '/../backend/app/Services/NlpService.php';

use App\Services\NlpService;

$nlp = new NlpService();

function test($message, $expectedCategory, $nlp, $lang = 'en') {
    $result = $nlp->analyze($message, $lang);
    $category = $result['category'];
    $confidence = $result['confidence'];
    
    echo "Input: [$message] ($lang)\n";
    echo "Detected: [$category] (Confidence: $confidence)\n";
    
    if ($category === $expectedCategory) {
        echo "✅ PASS\n";
    } else {
        echo "❌ FAIL (Expected: $expectedCategory)\n";
    }
    echo "---------------------------------\n";
}

echo "Running Chatbot Logic Tests...\n\n";

// English Tests
test("I am feeling very sad today", "sad", $nlp);
test("I have an exam tomorrow and I'm stressed", "exam", $nlp);
test("I really like a girl in my class, what should I do?", "crush", $nlp);
test("Tell me more about it", "more_steps", $nlp);

// Sinhala Tests
test("මට ගොඩක් දුකයි", "sad", $nlp, "si");
test("විභාග පීඩනය වැඩියි", "exam", $nlp, "si");
test("ගැහැණු ළමයෙක්ට crush එකක් තියෙනවා", "crush", $nlp, "si");

// Tamil Tests
test("நான் மிகவும் வருத்தமாக இருக்கிறேன்", "sad", $nlp, "ta");
test("தேர்வு பயமாக இருக்கிறது", "exam", $nlp, "ta");

echo "\nVerification Complete.\n";
