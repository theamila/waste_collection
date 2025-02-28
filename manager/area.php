<?php
include '../config/database.php';
session_start();

// Check if manager is logged in
if (!isset($_SESSION['manager'])) {
    header("Location: login.php");
    exit;
}

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'create') {
        $lane_no = $_POST['lane_no'];
        $unit_no = $_POST['unit_no'];  // Make sure this input exists in your form
        $description = $_POST['description'];
        $no_of_houses = $_POST['no_of_houses'];
        $query = $conn->prepare("INSERT INTO area (lane_no, unit_no, description, no_of_houses) VALUES (?, ?, ?, ?)"); // Four placeholders
        $query->bind_param('sssi', $lane_no, $unit_no, $description, $no_of_houses); // Four values bound
        $query->execute();
        
   		} elseif ($action === 'update') {
        $id = $_POST['update_id'];
        $lane_no = $_POST['update_lane_no'];
        $unit_no = $_POST['update_unit_no'];
        $description = $_POST['update_description'];
        $no_of_houses = $_POST['update_no_of_houses'];

        $query = $conn->prepare("UPDATE area SET lane_no = ?, unit_no = ?, description = ?, no_of_houses = ? WHERE id = ?");

        if ($query) { // Correctly nested if
            $query->bind_param('sssis', $lane_no, $unit_no, $description, $no_of_houses, $id);
            $result = $query->execute();

            if (!$result) {
                error_log("Update failed: " . $query->error . " SQL: UPDATE area SET lane_no = '$lane_no', unit_no = '$unit_no', description = '$description', no_of_houses = $no_of_houses WHERE id = $id");
            }

            $query->close();
        } else { // Correct else block
            error_log("Prepare failed: " . $conn->error . " SQL: UPDATE area SET lane_no = ?, unit_no = ?, description = ?, no_of_houses = ? WHERE id = ?");
        } // End of if ($query)

    } // End of elseif ($action === 'update')  <- Important!

    elseif ($action === 'delete') { // Correctly aligned with other actions
        $id = $_POST['id'];
        $query = $conn->prepare("DELETE FROM area WHERE id = ?");
        $query->bind_param('i', $id);
        $query->execute();
    } // End of elseif ($action === 'delete')

elseif ($action === 'send') { // Correctly aligned with other actions
        $id = $_POST['id'];
        
	// Prepare and execute SQL query
	$stmt = $conn->prepare("SELECT area.lane_no,house_no,mobile_number FROM area INNER JOIN household_registration ON area.lane_no = household_registration.lane_no WHERE area.id = ?");
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
    		// Iterate through the fetched entries
    		while($row = $result->fetch_assoc()) {
       		//echo "ID: " . $row["lane_no"]. " - Name: " . $row["house_no"]. " - Mobile: " . $row["mobile_number"]. "<br>";
		$url = 'https://app.notify.lk/api/v1/send?user_id=29099&api_key=04Q0g5ASxkJa6Y4IAWmf&sender_id=NotifyDEMO&to='. $row["mobile_number"].'&message=Waste Collection Tommorow. Lane'. $row["lane_no"];
		$data = file_get_contents($url);
			
    		}
    		echo "Message Sent successfully...!";
	} 
		     
    } // End of elseif ($action === 'send')
} // End of if ($_SERVER['REQUEST_METHOD'] === 'POST')



// Fetch Areas
$areas = $conn->query("SELECT * FROM area");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-300 p-6 min-h-screen">
    <!-- Back Button and Heading in the Same Row -->
    <div class="flex items-center space-x-4 py-3 mb-5">
        <!-- Back Button -->
        <a href="dashboard.php" class="flex items-center text-orange-500 hover:text-orange-700 text-2xl font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-6 w-6 mr-2 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M11 19l-7-7 7-7M4 12h16" />
            </svg>
        </a>
        <!-- Heading -->
        <h1 class="text-3xl font-bold text-orange-500">Area Management</h1>
    </div>

    <!-- Create Form -->
    <form method="POST" class="mb-4">
        <input type="hidden" name="action" value="create">
        <div class="grid grid-cols-4 gap-4">
            <input type="text" name="lane_no" placeholder="Lane No" class="border rounded-lg px-3 py-2" required>
            <input type="text" name="unit_no" placeholder="Unit No" class="border rounded-lg px-3 py-2" required>
            <input type="text" name="description" placeholder="Description" class="border rounded-lg px-3 py-2" required>
            <input type="number" name="no_of_houses" placeholder="No. of Houses" class="border rounded-lg px-3 py-2" required>
        </div>
        <button type="submit" class=" text-white px-4 py-2 rounded bg-orange-500 font-semibold mt-4 hover:bg-orange-600">Create an Area</button>
    </form>

    <!-- Area Table -->
    <table class="w-full bg-white shadow border">
        <thead>
            <tr class="bg-orange-500">
                <th class="border px-4 py-2 text-white">Lane No</th>
                <th class="border px-4 py-2 text-white">Unit No</th>
                <th class="border px-4 py-2 text-white">Description</th>
                <th class="border px-4 py-2 text-white">No. of Houses</th>
                <th class="border px-4 py-2 text-white">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($area = $areas->fetch_assoc()): ?>
                <tr>
                    <td class="border px-4 py-2"><?= $area['lane_no'] ?></td>
                    <td class="border px-4 py-2"><?= $area['unit_no'] ?></td>
                    <td class="border px-4 py-2"><?= $area['description'] ?></td>
                    <td class="border px-3 py-2"><?= $area['no_of_houses'] ?></td>
                    <td class="border px-3 py-2 flex space-x-2">
                    
                        <!-- Update Form -->
                        <form method="POST" class="flex">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="update_id" value="<?= $area['id'] ?>">  
                            <input type="text" name="update_lane_no" value="<?= $area['lane_no'] ?>" class="border rounded-lg px-2 py-1 w-30" required>
                            <input type="text" name="update_unit_no" value="<?= $area['unit_no'] ?>" class="border rounded-lg px-2 py-1 w-30" required> 
                            <input type="text" name="update_description" value="<?= $area['description'] ?>" class="border rounded-lg px-2 py-1 w-30" required>
                            <input type="number" name="update_no_of_houses" value="<?= $area['no_of_houses'] ?>" class="border rounded-lg px-2 py-1 w-30" required>
                            <button type="submit" class="bg-black text-white px-4 py-1 ml-10 hover:bg-gray-600">Update</button>
                        </form>

                        <form method="POST" onsubmit="return confirmDelete()">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $area['id'] ?>">
                            <button type="submit" class="bg-red-500 text-white px-4 py-1 ml-7 hover:bg-red-600">Delete</button>
                        </form>
                        						
						<!-- Send Message -->
						<form method="POST" onsubmit="return confirmSend()">
						    <input type="hidden" name="action" value="send">
						    <input type="hidden" name="id" value="<?= $area['id'] ?>">
						    <button type="submit" class="bg-red-500 text-white px-4 py-1 ml-7 hover:bg-red-600">Send</button>
						</form> 

                  
					</td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
        <!-- JavaScript Confirmation Script -->
    <script>
        // Function to ask for deletion confirmation
        function confirmDelete() {
            return confirm("Are you sure you want to delete this area?");
        }
    </script>
    
    
</body>
</html>
