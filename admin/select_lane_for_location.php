<?php
// Database connection
include '../config/database.php';
session_start();

// Fetch available lane numbers and their links from the location table
$sql_lane = "SELECT lane_no, link FROM location"; // No need for GROUP BY if each lane has only one link.
$lanes_result = $conn->query($sql_lane);

// Check for database errors
if (!$lanes_result) {
    die("Database error: " . $conn->error); // Handle errors properly
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Location</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function handleLaneSelection(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const link = selectedOption.getAttribute('data-link');

            if (link) {
                const iframeContainer = document.getElementById('iframe-container');
                iframeContainer.innerHTML = `<iframe src="${link}" width="100%" height="600px"></iframe>`;
                iframeContainer.style.display = "block";
                const linkDisplay = document.getElementById('link-display');
                linkDisplay.innerHTML = "";
            } else {
                const linkDisplay = document.getElementById('link-display');
                linkDisplay.innerHTML = "No link available for this lane.";
                const iframeContainer = document.getElementById('iframe-container');
                iframeContainer.style.display = "none";
            }
        }
    </script>
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
            <h1 class="text-3xl font-bold text-blue-500">Live Location</h1>
        </div>

        <div class="grid grid-cols-4 gap-4">
            <label for="lane_no" class="block mb-2 text-white bg-blue-500 p-2 rounded text-lg font-bold">Select Your Lane Number</label>
            <select name="lane_no" id="lane_no" required class="w-full p-2 border border-gray-300 rounded-lg" onchange="handleLaneSelection(this)">
                <option value="" disabled selected>Select an option</option>
                <?php if ($lanes_result): ?>
                    <?php while ($row_lane = $lanes_result->fetch_assoc()): ?>
                        <option value="<?php echo $row_lane['lane_no']; ?>"
                            data-link="<?php echo $row_lane['link']; ?>">
                            <?php echo $row_lane['lane_no']; ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="mt-5">
            <h3 class="text-2xl font-bold text-blue-500 mb-4 font-bold">Vehicle Location of Your Lane</h3>
            <div id="link-display" class="mt-2"></div>
            <div id="iframe-container" class="mt-2" style="display:none;"></div>
        </div>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
