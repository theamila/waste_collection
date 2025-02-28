<?php 
// Database connection
include '../../config/database.php';
session_start();

// Handle Create, Update, and Delete operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        // Create operation
        $lane_no = $_POST['lane_no'];
        $garbage_type = $_POST['garbage_type'];
        $day = $_POST['date'];
        // $week = $_POST['week'];
        $vehicle_no = $_POST['vehicle_no'];

        $sql = "INSERT INTO schedule (lane_no, garbage_type, day, vehicle_no)
                VALUES ('$lane_no', '$garbage_type', '$day', '$vehicle_no')";
        $conn->query($sql);
    } elseif (isset($_POST['update'])) {
        // Update operation
        $id = $_POST['id'];
        $lane_no = $_POST['lane_no'];
        $garbage_type = $_POST['garbage_type'];
        $day = $_POST['date'];
        // $week = $_POST['week'];
        $vehicle_no = $_POST['vehicle_no'];

        $sql = "UPDATE schedule SET lane_no='$lane_no', garbage_type='$garbage_type', day='$day', vehicle_no='$vehicle_no'
                WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        // Delete operation
        $id = $_POST['id'];
        $sql = "DELETE FROM schedule WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch existing schedules
$sql = "SELECT * FROM schedule";
$result = $conn->query($sql);

// Fetch available lane numbers from area table
$sql_lane = "SELECT lane_no FROM area";
$lanes_result = $conn->query($sql_lane);

// Fetch available vehicle numbers from vehicle table
$sql_vehicle = "SELECT vehicle_no, status FROM vehicle WHERE status IN ('In service', 'Available')";
$vehicles_result = $conn->query($sql_vehicle);

// Fetch the schedule details if we're updating
$schedule = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_schedule = "SELECT * FROM schedule WHERE id = $id";
    $result_schedule = $conn->query($sql_schedule);
    if ($result_schedule->num_rows > 0) {
        $schedule = $result_schedule->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Management</title>
    <script src="https://cdn.tailwindcss.com"></script>   
</head>
<body class="bg-gray-300">

<div class="flex">
    <!-- Main Content -->
    <div class="flex-grow p-6">
        <!-- Back Button and Heading in the Same Row -->
        <div class="flex items-center space-x-4 py-3 mb-5">
            <!-- Back Button -->
            <a href="dashboard.php" class="flex items-center text-orange-500 hover:text-orange-700 text-2xl font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-6 w-6 mr-2 mt-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M11 19l-7-7 7-7M4 12h16" />
                </svg>
            </a>
            <!-- Heading -->
            <h1 class="text-3xl font-bold text-orange-500">Manage Schedules</h1>
        </div>

        <!-- Create or Update Schedule Form -->
        <div class="flex items-center justify-center">
            <form action="schedule.php" method="POST" class="bg-white p-6 rounded-lg shadow-md mb-6 w-3/4">
                <h3 class="text-xl font-semibold mb-4 text-orange-500"><?php echo $schedule ? "Update Schedule" : "Create New Schedule"; ?></h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="lane_no" class="block mb-2">Lane No</label>
                        <select name="lane_no" id="lane_no" required class="w-full p-2 border border-gray-300 rounded-lg">
                            <option value="" disabled selected>Select an option</option>
                            <?php while ($row_lane = $lanes_result->fetch_assoc()): ?>
                                <option value="<?php echo $row_lane['lane_no']; ?>" <?php echo ($schedule && $schedule['lane_no'] == $row_lane['lane_no']) ? 'selected' : ''; ?>>
                                    <?php echo $row_lane['lane_no']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div>
                        <label for="garbage_type" class="block mb-2">Garbage Type</label>
                        <select name="garbage_type" id="garbage_type" required class="w-full p-2 border border-gray-300 rounded-lg">
                            <option value="" disabled selected>Select an option</option>
                            <option value="Plastic" <?php echo ($schedule && $schedule['garbage_type'] == 'Plastic') ? 'selected' : ''; ?>>Plastic</option>
                            <option value="Biodegradable" <?php echo ($schedule && $schedule['garbage_type'] == 'Biodegradable') ? 'selected' : ''; ?>>Biodegradable</option>
                            <option value="E-waste" <?php echo ($schedule && $schedule['garbage_type'] == 'E-waste') ? 'selected' : ''; ?>>E-waste</option>
                        </select>
                    </div>
                    <div>
                        <label for="vehicle_no" class="block mb-2">Vehicle No</label>
                        <select name="vehicle_no" id="vehicle_no" required class="w-full p-2 border border-gray-300 rounded-lg">
                            <option value="" disabled selected>Select an option</option>
                            <?php while ($row_vehicle = $vehicles_result->fetch_assoc()): ?>
                                <option value="<?php echo $row_vehicle['vehicle_no']; ?>" <?php echo ($schedule && $schedule['vehicle_no'] == $row_vehicle['vehicle_no']) ? 'selected' : ''; ?>>
                                    <?php echo $row_vehicle['vehicle_no'] . ' (' . $row_vehicle['status'] . ')'; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <!-- <div>
                        <label for="week" class="block mb-2">Week</label>
                        <select name="week" id="week" required class="w-full p-2 border border-gray-300 rounded-lg">
                            <option value="" disabled selected>Select an option</option>    
                            <option value="Every week" <?php echo ($schedule && $schedule['week'] == 'Every week') ? 'selected' : ''; ?>>Every week</option>
                            <option value="First week" <?php echo ($schedule && $schedule['week'] == 'First week') ? 'selected' : ''; ?>>First week</option>
                            <option value="Second week" <?php echo ($schedule && $schedule['week'] == 'Second week') ? 'selected' : ''; ?>>Second week</option>
                            <option value="Third week" <?php echo ($schedule && $schedule['week'] == 'Third week') ? 'selected' : ''; ?>>Third week</option>
                            <option value="Fourth week" <?php echo ($schedule && $schedule['week'] == 'Fourth week') ? 'selected' : ''; ?>>Fourth week</option>
                        </select>
                    </div> -->
                    <div>
                        <label for="date" class="block mb-2">Date</label>
                        <input type="date" name="date" id="date" required class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo $schedule ? $schedule['day'] : ''; ?>">
                    </div>
                </div>
                <button type="submit" name="<?php echo $schedule ? 'update' : 'create'; ?>" class="text-white px-4 py-2 rounded bg-orange-500 font-semibold mt-4 hover:bg-orange-600"><?php echo $schedule ? 'Update Schedule' : 'Create Schedule'; ?></button>
                <!-- Cancel Button (Only visible in update mode) -->
                <?php if (isset($schedule)): ?>
                    <a href="schedule.php"><button type="button" id="cancel-btn" class="text-gray-600 px-4 py-2 rounded bg-gray-300 font-semibold mt-4 ml-4 hover:bg-gray-400" onclick="cancelEdit()">Cancel</button></a>
                <?php endif; ?>    
                <?php if ($schedule): ?>
                    <input type="hidden" name="id" value="<?php echo $schedule['id']; ?>">
                <?php endif; ?>
            </form>
        </div>

        <!-- Display existing schedules -->
        <h3 class="text-2xl font-bold text-orange-500 mb-4">Existing Schedules</h3>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-orange-500">
                    <th class="px-6 py-3 border-b text-white">Lane No</th>
                    <th class="px-6 py-3 border-b text-white">Garbage Type</th>
                    <th class="px-6 py-3 border-b text-white">Vehicle No</th>
                    <!-- <th class="px-6 py-3 border-b text-white">Week</th> -->
                    <th class="px-6 py-3 border-b text-white">Date</th>
                    <th class="px-6 py-3 border-b text-white">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="px-6 py-3 border-b"><?php echo $row['lane_no']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['garbage_type']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['vehicle_no']; ?></td>
                    <!-- <td class="px-6 py-3 border-b"><?php echo $row['week']; ?></td> -->
                    <td class="px-6 py-3 border-b"><?php echo $row['day']; ?></td>
                    <td class="px-6 py-3 border-b">
                        <!-- Update and Delete buttons -->
                        <a href="schedule.php?id=<?php echo $row['id']; ?>" class="bg-black text-white px-4 py-1  ml-10 hover:bg-gray-600">Update</a>
                        <form action="schedule.php" method="POST" class="inline-block" onsubmit="return confirmDelete()">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete" class="bg-red-600 text-white px-4 py-1 hover:bg-red-500">Delete</button>
                        </form>                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this schedule?");
    }
</script>

</body>
</html>

<?php $conn->close(); ?>
