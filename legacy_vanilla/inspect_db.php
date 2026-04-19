<?php
require 'config.php';
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$res = $conn->query("SELECT * FROM mood_entries ORDER BY id DESC LIMIT 5");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
?>
