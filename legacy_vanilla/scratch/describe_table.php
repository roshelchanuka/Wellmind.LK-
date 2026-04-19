<?php
require 'db_connect.php';
$res = $conn->query("DESCRIBE mood_entries");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
?>
