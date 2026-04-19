<?php
require 'db_connect.php';
$result = $conn->query("DESCRIBE support_messages");
while($row = $result->fetch_assoc()) {
    print_r($row);
}
?>
