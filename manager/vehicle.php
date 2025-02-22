<?php
// Database connection
include '../../config/database.php';
session_start();

// Handle Create, Update, and Delete operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        // Create operation
        $vehicle_no = $_POST['vehicle_no'];
        $capacity = $_POST['capacity'];
        $date = $_POST['date'];
        $status = $_POST['status'];
        
        $sql = "INSERT INTO vehicle (vehicle_no, capacity, date, status)
                VALUES ('$vehicle_no', '$capacity', '$date', '$status')";
        $conn->query($sql);
    } elseif (isset($_POST['update'])) {
        // Update operation
        $id = $_POST['id'];
        $vehicle_no = $_POST['vehicle_no'];
        $capacity = $_POST['capacity'];
        $date = $_POST['date'];
        $status = $_POST['status'];
        
        $sql = "UPDATE vehicle SET vehicle_no='$vehicle_no', capacity='$capacity', date='$date', status='$status'
                WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        // Delete operation
        $id = $_POST['id'];
        $sql = "DELETE FROM vehicle WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch existing vehicles
$sql = "SELECT * FROM vehicle";
$result = $conn->query($sql);

// Check if we're updating an existing vehicle
$vehicle = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_vehicle = "SELECT * FROM vehicle WHERE id = $id";
    $result_vehicle = $conn->query($sql_vehicle);
    if ($result_vehicle->num_rows > 0) {
        $vehicle = $result_vehicle->fetch_assoc();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

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
            <h1 class="text-3xl font-bold text-orange-500">Manage Vehicles</h1>
        </div>

        <!-- Create or Update Vehicle Form -->
        <div class="flex items-center justify-center">
            <form action="vehicle.php" method="POST" class="bg-white p-6 rounded-lg shadow-md mb-6 w-3/4">
                <h3 class="text-xl font-semibold mb-4 text-orange-500"><?php echo $vehicle ? "Update Vehicle" : "Create New Vehicle"; ?></h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="vehicle_no" class="block mb-2">Vehicle No</label>
                        <input type="text" name="vehicle_no" id="vehicle_no" value="<?php echo $vehicle ? $vehicle['vehicle_no'] : ''; ?>" required class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="capacity" class="block mb-2">Capacity</label>
                        <input type="number" name="capacity" id="capacity" value="<?php echo $vehicle ? $vehicle['capacity'] : ''; ?>" required class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="date" class="block mb-2">Date of Issue</label>
                        <input type="date" name="date" id="date" value="<?php echo $vehicle ? $vehicle['date'] : ''; ?>" required class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="status" class="block mb-2">Status</label>
                        <select name="status" id="status" required class="w-full p-2 border border-gray-300 rounded-lg">
                            <option value="" disabled selected>Select an option</option>    
                            <option value="Available" <?php echo ($vehicle && $vehicle['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                            <option value="Out of service" <?php echo ($vehicle && $vehicle['status'] == 'Out of service') ? 'selected' : ''; ?>>Out of service</option>
                            <option value="In service" <?php echo ($vehicle && $vehicle['status'] == 'In service') ? 'selected' : ''; ?>>In service</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="<?php echo $vehicle ? 'update' : 'create'; ?>" class="text-white px-4 py-2 rounded bg-orange-500 font-semibold mt-4 hover:bg-orange-600">
                    <?php echo $vehicle ? 'Update Vehicle' : 'Create Vehicle'; ?>
                </button>
                <?php if ($vehicle): ?>
                    <input type="hidden" name="id" value="<?php echo $vehicle['id']; ?>">
                <?php endif; ?>
                <!-- Cancel Button (Only visible in update mode) -->
                <?php if (isset($vehicle)): ?>
                    <a href="vehicle.php"><button type="button" id="cancel-btn" class="text-gray-600 px-4 py-2 rounded bg-gray-300 font-semibold mt-4 ml-4 hover:bg-gray-400" onclick="cancelEdit()">Cancel</button></a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Display existing vehicles -->
        <h3 class="text-2xl font-bold text-orange-500 mb-4">Existing Vehicles</h3>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-orange-500">
                    <th class="px-6 py-3 border-b text-white">Vehicle No</th>
                    <th class="px-6 py-3 border-b text-white">Capacity</th>
                    <th class="px-6 py-3 border-b text-white">Date of Issue</th>
                    <th class="px-6 py-3 border-b text-white">Status</th>
                    <th class="px-6 py-3 border-b text-white">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="px-6 py-3 border-b"><?php echo $row['vehicle_no']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['capacity']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['date']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['status']; ?></td>
                    <td class="px-6 py-3 border-b">
                        <!-- Update and Delete buttons -->
                        <a href="vehicle.php?id=<?php echo $row['id']; ?>" class="bg-black text-white px-4 py-1  ml-10 hover:bg-gray-600">Update</a>
                        <form action="vehicle.php" method="POST" class="inline-block">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete" class="bg-red-600 text-white px-4 py-1 hover:bg-red-500">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
