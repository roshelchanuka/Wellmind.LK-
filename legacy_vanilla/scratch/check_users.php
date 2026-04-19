<?php
require 'db_connect.php';

echo "Database Name: " . DB_NAME . "\n";

$result = $conn->query("SHOW TABLES LIKE 'users'");
if ($result->num_rows == 0) {
    echo "ERROR: Table 'users' does not exist!\n";
} else {
    echo "Table 'users' exists.\n";
    $result = $conn->query("DESCRIBE users");
    echo "Structure:\n";
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
    
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $result->fetch_assoc();
    echo "Total users: " . $row['count'] . "\n";
}
?>
