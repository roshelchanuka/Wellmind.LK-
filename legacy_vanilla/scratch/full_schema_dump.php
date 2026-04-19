<?php
$conn = new mysqli('localhost', 'root', '', 'wellmind_db');
if ($conn->connect_error) die("Connect failed: " . $conn->connect_error);

$tables = [];
$res = $conn->query("SHOW TABLES");
while ($row = $res->fetch_array()) {
    $tables[] = $row[0];
}

foreach ($tables as $table) {
    echo "--- TABLE: $table ---\n";
    $res = $conn->query("DESCRIBE $table");
    while ($row = $res->fetch_assoc()) {
        print_r($row);
    }
    echo "\n";
}
?>
