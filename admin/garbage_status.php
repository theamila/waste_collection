<?php
// Database connection
include '../config/database.php';
session_start();



// Fetch existing managers for listing
$sql = "SELECT date, lane_no, house_no, CASE WHEN remaining_weight < 400 THEN 'Empty' ELSE GREATEST(remaining_weight - 300, 0) END AS remaining_weight FROM garbage_collection_status";
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
        
  


			<ul class="space-y-5 font-semibold flex-grow text-center text-lg mt-6">
    			<li>
        			<a href="managers.php" class="block px-4 py-3 bg-blue-600 rounded-lg hover:bg-blue-700 relative">  Manage Managers
            		<span class="absolute left-full top-1/2 transform -translate-y-1/2 ml-2 px-2 py-1 bg-blue-600 rounded-md text-white text-sm whitespace-nowrap" 
                  style="width: 40ch;">  (Some Label Text)  </span>
       			 </a>
    			</li>
			</ul>
  

        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-blue-500">
                    <th class="px-6 py-3 border-b text-white">Date</th>
                    <th class="px-6 py-3 border-b text-white">Lane No</th>
                    <th class="px-6 py-3 border-b text-white">House No</th>
                    <th class="px-6 py-3 border-b text-white">Remaining Weight</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="px-6 py-3 border-b"><?php echo $row['date']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['lane_no']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['house_no']; ?></td>
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
