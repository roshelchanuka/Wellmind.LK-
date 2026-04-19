<?php
require 'db_connect.php';
$res = $conn->query("DESCRIBE support_messages");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
?>
