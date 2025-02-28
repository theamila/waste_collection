<?php
// Database configuration
include '../config/database.php';
$id = $_GET['id'];


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute SQL query
	$stmt = $conn->prepare("SELECT area.lane_no,house_no,mobile_number FROM area INNER JOIN household_registration ON area.lane_no = household_registration.lane_no WHERE area.unit_no = ?");
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
    		// Iterate through the fetched entries
    		while($row = $result->fetch_assoc()) {
       		//echo "ID: " . $row["lane_no"]. " - Name: " . $row["house_no"]. " - Mobile: " . $row["mobile_number"]. "<br>";
		$url = 'https://app.notify.lk/api/v1/send?user_id=29099&api_key=04Q0g5ASxkJa6Y4IAWmf&sender_id=NotifyDEMO&to='. $row["mobile_number"].'&message=Waste Collection Started. Lane'. $row["lane_no"];
		$data = file_get_contents($url);
			
    		}
    		echo "Message Sent successfully...!";
	}
// Close statement and connection
$stmt->close();
$conn->close();
?>
