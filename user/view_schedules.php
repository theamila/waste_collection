<?php 
// Database connection
include '../config/database.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Log out user
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");  // Redirect to login page after logout
    exit();
}

$sql = "SELECT * FROM schedule";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Schedules</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-100">

<div class="flex">
    <!-- Main Content -->
    <div class="flex-grow p-6">
        <!-- Heading and Log Out Button -->
        <div class="flex items-center justify-between py-3 mb-5">
            <h1 class="text-3xl font-bold text-green-600">Schedules</h1>
            <a href="?logout=true" class="text-white bg-red-600 px-4 py-2 rounded-lg hover:bg-red-700">Log Out</a>
        </div>

       		 <!-- Search Form -->
			<div class="mb-6 flex items-center h-[48px]">  <input type="text" id="search" placeholder="Search schedules..." class="px-6 py-3 rounded-lg w-1/4 border border-gray-300 mr-20 h-full" />  
				<ul class="font-semibold text-lg">
       			 	<li>
            			<a href="https://mon-backend.azurewebsites.net/worldmap/" class="block px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700"> See Live Location </a>
        			</li>
   			 	</ul>
			</div> 
				
        <!-- Display schedules -->
        <div id="schedules">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-green-600">
                        <th class="px-6 py-3 border-b text-white">Lane No</th>
                        <th class="px-6 py-3 border-b text-white">Garbage Type</th>
                        <th class="px-6 py-3 border-b text-white">Vehicle No</th>
                        <th class="px-6 py-3 border-b text-white">Week</th>
                        <th class="px-6 py-3 border-b text-white">Date</th>
                    </tr>
                </thead>
                <tbody id="scheduleResults">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="request-row">
                                <td class="px-6 py-3 border-b"><?php echo $row['lane_no']; ?></td>
                                <td class="px-6 py-3 border-b"><?php echo $row['garbage_type']; ?></td>
                                <td class="px-6 py-3 border-b"><?php echo $row['vehicle_no']; ?></td>
                                <td class="px-6 py-3 border-b"><?php echo $row['week']; ?></td>
                                <td class="px-6 py-3 border-b"><?php echo $row['day']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-center">No schedules found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// JavaScript for search functionality
document.getElementById('search').addEventListener('keyup', function() {
  const searchText = this.value.toLowerCase();
  const rows = document.querySelectorAll('.request-row');
  
  rows.forEach(function(row) {
    const laneNo = row.children[0].textContent.toLowerCase();
    const garbageType = row.children[1].textContent.toLowerCase();
    const vehicleNo = row.children[2].textContent.toLowerCase();
    const week = row.children[3].textContent.toLowerCase();
    const day = row.children[4].textContent.toLowerCase();

    // Check if any column matches the search query
    if (laneNo.includes(searchText) || garbageType.includes(searchText) || vehicleNo.includes(searchText) || week.includes(searchText) || day.includes(searchText)) {
      row.style.display = '';  // Show the row
    } else {
      row.style.display = 'none';  // Hide the row
    }
  });
});
</script>

</body>
</html>

<?php $conn->close(); ?>
