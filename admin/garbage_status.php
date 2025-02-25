<?php
// Database connection
include '../../config/database.php';
session_start();


// Start building the query
$sql = "SELECT date, time, bin_no, CASE WHEN remaining_weight < 400 THEN 'Empty' ELSE GREATEST(remaining_weight - 300, 0) END AS remaining_weight FROM garbage_collection_status WHERE 1=1 ";


// Prepare the statement *AFTER* building the complete SQL query
$stmt = $conn->prepare($sql);


$stmt->execute();
$result = $stmt->get_result();// Fetch garbage statusfor listing
$sql = "SELECT date, time, bin_no, CASE WHEN remaining_weight < 400 THEN 'Empty' ELSE GREATEST(remaining_weight - 300, 0) END AS remaining_weight FROM garbage_collection_status";
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


        <!-- Display status -->
        <h3 class="text-2xl font-bold text-blue-500 mb-4">Collection Status</h3>
        
        <!-- Search Form -->
		<div class="mb-6 flex items-center h-[48px]">  <input type="text" id="search" placeholder="Search schedules..." class="px-6 py-3 rounded-lg w-1/4 border border-gray-300 mr-20 h-full" />  
		</div> 



        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">           
         	<thead>
                <tr class="bg-blue-500">
                    <th class="px-6 py-3 border-b text-white">Date</th>
                    <th class="px-6 py-3 border-b text-white">Time</th>
                    <th class="px-6 py-3 border-b text-white">Bin No</th>
                    <th class="px-6 py-3 border-b text-white">Remaining Weight</th>
                </tr>
            </thead>
            <tbody>
               <?php while ($row = $result->fetch_assoc()): ?>
               <tr class="table-row">  <td class="px-6 py-3 border-b"><?php echo $row['date']; ?></td>
                   <td class="px-6 py-3 border-b"><?php echo $row['time']; ?></td>
                   <td class="px-6 py-3 border-b"><?php echo $row['bin_no']; ?></td>
                   <td class="px-6 py-3 border-b"><?php echo $row['remaining_weight']; ?></td>
               </tr>
             <?php endwhile; 
             ?>            
            </tbody>

        </table>
    </div>
</div>


    <script>
        document.getElementById('search').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('.table-row'); // Select by the correct class

            rows.forEach(function(row) {
                const date = row.children[0].textContent.toLowerCase();
                const time = row.children[1].textContent.toLowerCase(); // Get time as well
                const bin_no = row.children[2].textContent.toLowerCase();
                const remaining_weight = row.children[3].textContent.toLowerCase(); // Corrected index

                if (date.includes(searchText) || time.includes(searchText) || bin_no.includes(searchText) || remaining_weight.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>


</body>
</html>

<?php $conn->close(); ?>
