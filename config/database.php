<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'waste_collection');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
