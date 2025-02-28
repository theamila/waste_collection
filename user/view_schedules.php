<?php
// Database connection
include '../config/database.php';
session_start();

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
<body class="bg-yellow-100">

<div class="flex">
    <div class="flex-grow p-6">
        <div class="flex py-3 mb-5">
            <a href="../index.php" class="flex items-center text-yellow-600 hover:text-black text-2xl ml-2 font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-6 w-6 mr-2 mt-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M11 19l-7-7 7-7M4 12h16" />
                </svg>
                Back
            </a>
            <h1 class="text-3xl font-bold text-yellow-600 ml-28">Schedules</h1>
        </div>

        <div class="mb-6">
            <input type="text" id="search" placeholder="Search schedules..." class="px-4 py-2 rounded-lg w-[35%] border border-gray-300 " />
        </div>

        <div id="schedules">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-yellow-600">
                        <th class="px-6 py-3 border-b text-white">Lane No</th>
                        <th class="px-6 py-3 border-b text-white">Garbage Type</th>
                        <th class="px-6 py-3 border-b text-white">Vehicle No</th>
                        <th class="px-6 py-3 border-b text-white">Day</th>
                    </tr>
                </thead>
                <tbody id="scheduleResults">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="request-row">
                                <td class="px-6 py-3 border-b"><?php echo $row['lane_no']; ?></td>
                                <td class="px-6 py-3 border-b"><?php echo $row['garbage_type']; ?></td>
                                <td class="px-6 py-3 border-b"><?php echo $row['vehicle_no']; ?></td>
                                <td class="px-6 py-3 border-b"><?php echo $row['day']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-center">No schedules found.</td>
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
        const day = row.children[3].textContent.toLowerCase(); // Corrected variable name

        // Check if any column matches the search query
        if (laneNo.includes(searchText) || garbageType.includes(searchText) || vehicleNo.includes(searchText) || day.includes(searchText)) {
            row.style.display = ''; // Show the row
        } else {
            row.style.display = 'none'; // Hide the row
        }
    });
});
</script>

</body>
</html>

<?php $conn->close(); ?>
