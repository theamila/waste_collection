<?php
// Database connection
$conn = new mysqli('osi-ltsd-svr.mysql.database.azure.com', 'zbzqbabxgz', 'Ystp$1NYCd4nL5te', 'waste');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
