<?php
require 'db_connect.php';

// 1. Alter feedback_id to be auto-incrementing primary key
// We use MODIFY first to ensure it handles existing data if possible, 
// then ADD PRIMARY KEY if missing.
// Actually, it's safer to truncate if it's just garbage test data, but let's try to be non-destructive first.

$sql = "ALTER TABLE support_messages MODIFY COLUMN feedback_id INT AUTO_INCREMENT PRIMARY KEY";

if ($conn->query($sql)) {
    echo "Table support_messages updated successfully with PRIMARY KEY AUTO_INCREMENT.";
} else {
    echo "Error updating table: " . $conn->error;
    
    // If it failed because of existing PRI, try just MODIFY to add auto_increment
    $sql2 = "ALTER TABLE support_messages MODIFY COLUMN feedback_id INT AUTO_INCREMENT";
    if ($conn->query($sql2)) {
        echo "Auto-increment added successfully.";
    }
}

$conn->close();
?>
