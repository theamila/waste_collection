<?php
// Database connection
include '../config/database.php';
session_start();

/// Initialize search variables
$searchOption = null;
$searchValue = null;

// Check if search parameters are set
if (isset($_POST['search'])) {
    $searchOption = $_POST['search_option'];
    $searchValue = $_POST['search_value'];
}
$sql = "SELECT date, lane_no, bin_no, unit_no, CASE WHEN remaining_weight < 400 THEN 'Empty' ELSE GREATEST(remaining_weight - 300, 0) END AS remaining_weight FROM garbage_collection_status WHERE 1=1 ";

$stmt = $conn->prepare($sql); // Prepare the statement *ONCE*

if ($searchOption !== null && $searchValue !== null) {
    switch ($searchOption) {
        case 'date':
            $sql .= " AND date = ?";
            break;
        case 'lane_no':
            $sql .= " AND lane_no = ?";
            break;
        case 'bin_no':
            $sql .= " AND bin_no = ?";
            break;
        case 'unit_no':
            $sql .= " AND unit_no = ?";
            break;
    }

    // Now, bind the parameter to the *already prepared* statement
    $stmt->bind_param("s", $searchValue); 
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch garbage statusfor listing
$sql = "SELECT date, time, lane_no, bin_no, unit_no, phone_number, CASE WHEN remaining_weight < 400 THEN 'Empty' ELSE GREATEST(remaining_weight - 300, 0) END AS remaining_weight FROM garbage_collection_status";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garbage Collection Status</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<div class="flex">
    <div class="flex-grow p-6">
        <div class="flex items-center space-x-4 py-3 mb-5">
            <a href="admindashboard.php" class="flex items-center text-blue-500 hover:text-blue-700 text-2xl font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-6 w-6 mr-2 mt-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M11 19l-7-7 7-7M4 12h16" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-blue-500">Garbage Collection Status</h1>
        </div>


        <!-- Display existing managers -->
        <h3 class="text-2xl font-bold text-blue-500 mb-4">Collection Status</h3>
        
  		<div class="flex items-center space-x-4 py-3 mb-5">
    		<label for="search-option" class="block text-white font-bold py-2 px-4 rounded-md bg-blue-600" style="width: 30ch;">Search by</label>
			<select id="search-option" name="search_option" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
   				 <option value="">Select Option</option>
   				 <option value="date" <?php if (isset($_POST['search_option']) && $_POST['search_option'] == 'date') echo 'selected'; ?>>Date</option>
   				 <option value="lane_no" <?php if (isset($_POST['search_option']) && $_POST['search_option'] == 'lane_no') echo 'selected'; ?>>Lane No</option>
  				 <option value="house_no" <?php if (isset($_POST['search_option']) && $_POST['search_option'] == 'bin_no') echo 'selected'; ?>>Bin No</option>
  				 <option value="house_no" <?php if (isset($_POST['search_option']) && $_POST['search_option'] == 'unit_no') echo 'selected'; ?>>Unit No</option>

  				  
			</select>  		
			<input type="text" name="search_value" id="search_value" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter search term">
    		<button type="submit" name="search" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Search</button>
		</div>
		


        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-blue-500">
                    <th class="px-6 py-3 border-b text-white">Date</th>
                    <th class="px-6 py-3 border-b text-white">Time</th>
                    <th class="px-6 py-3 border-b text-white">Lane No</th>
                    <th class="px-6 py-3 border-b text-white">Bin No</th>
                    <th class="px-6 py-3 border-b text-white">Unit No</th>
                    <th class="px-6 py-3 border-b text-white">Phone Number</th>
                    <th class="px-6 py-3 border-b text-white">Remaining Weight</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="px-6 py-3 border-b"><?php echo $row['date']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['time']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['lane_no']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['bin_no']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['unit_no']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['phone_number']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['remaining_weight']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
