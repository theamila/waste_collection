<?php
// Database connection
include '../../config/database.php';
session_start();

// Handle Create, Update, and Delete operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        // Create operation
        $employee_no = $_POST['employee_no'];
        $vehicle_no = $_POST['vehicle_no'];
        $date = $_POST['date'];
        $lane_no = $_POST['lane_no'];
        
        $sql = "INSERT INTO assign_staff (employee_no, vehicle_no, date, lane_no)
                VALUES ('$employee_no', '$vehicle_no', '$date', '$lane_no')";
        $conn->query($sql);
    } elseif (isset($_POST['update'])) {
        // Update operation
        $id = $_POST['id'];
        $employee_no = $_POST['employee_no'];
        $vehicle_no = $_POST['vehicle_no'];
        $date = $_POST['date'];
        $lane_no = $_POST['lane_no'];
        
        $sql = "UPDATE assign_staff SET employee_no='$employee_no', vehicle_no='$vehicle_no', date='$date', lane_no='$lane_no'
                WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        // Delete operation
        $id = $_POST['id'];
        $sql = "DELETE FROM assign_staff WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch existing assignments
$sql = "SELECT * FROM assign_staff";
$result = $conn->query($sql);

// Fetch Employee numbers from cleaning_staff table
$sql_employee = "SELECT employee_no FROM cleaning_staff";
$result_employee = $conn->query($sql_employee);

// Fetch Vehicle numbers from vehicle table
$sql_vehicle = "SELECT vehicle_no, status FROM vehicle WHERE status IN ('In service', 'Available')";
$result_vehicle = $conn->query($sql_vehicle);

// Fetch Lane numbers from area table
$sql_lane = "SELECT lane_no FROM area";
$result_lane = $conn->query($sql_lane);

// Check if we're updating an existing assignment
$assignment = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_assignment = "SELECT * FROM assign_staff WHERE id = $id";
    $result_assignment = $conn->query($sql_assignment);
    if ($result_assignment->num_rows > 0) {
        $assignment = $result_assignment->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Staff</title>
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
            <h1 class="text-3xl font-bold text-orange-500">Assign Staff</h1>
        </div>

        <!-- Create or Update Assignment Form -->
        <div class="flex items-center justify-center">
            <form action="assign_staff.php" method="POST" class="bg-white p-6 rounded-lg shadow-md mb-6 w-3/4">
                <h3 class="text-xl font-semibold mb-4 text-orange-500"><?php echo $assignment ? "Update Assignment" : "Assign Staff to Vehicle"; ?></h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="employee_no" class="block mb-2">Employee No</label>
                        <select name="employee_no" id="employee_no" required class="w-full p-2 border border-gray-300 rounded-lg">
                            <option value="" disabled selected>Select an option</option>
                            <?php while ($row = $result_employee->fetch_assoc()): ?>
                                <option value="<?php echo $row['employee_no']; ?>" <?php echo ($assignment && $assignment['employee_no'] == $row['employee_no']) ? 'selected' : ''; ?>>
                                    <?php echo $row['employee_no']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div>
                        <label for="vehicle_no" class="block mb-2">Vehicle No</label>
                        <select name="vehicle_no" id="vehicle_no" required class="w-full p-2 border border-gray-300 rounded-lg">
                            <option value="" disabled selected>Select an option</option>
                            <?php while ($row_vehicle = $result_vehicle->fetch_assoc()): ?>
                                <option value="<?php echo $row_vehicle['vehicle_no']; ?>" <?php echo ($assignment && $assignment['vehicle_no'] == $row_vehicle['vehicle_no']) ? 'selected' : ''; ?>>
                                    <?php echo $row_vehicle['vehicle_no'] . ' (' . $row_vehicle['status'] . ')'; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                    </div>
                    <div>
                        <label for="date" class="block mb-2">Effective From</label>
                        <input type="date" name="date" id="date" value="<?php echo $assignment ? $assignment['date'] : ''; ?>" required class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="lane_no" class="block mb-2">Lane No</label>
                        <select name="lane_no" id="lane_no" required class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="" disabled selected>Select an option</option>
                            <?php while ($row = $result_lane->fetch_assoc()): ?>
                                <option value="<?php echo $row['lane_no']; ?>" <?php echo ($assignment && $assignment['lane_no'] == $row['lane_no']) ? 'selected' : ''; ?>>
                                    <?php echo $row['lane_no']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="<?php echo $assignment ? 'update' : 'create'; ?>" class="text-white px-4 py-2 rounded bg-orange-500 font-semibold mt-4 hover:bg-orange-600">
                    <?php echo $assignment ? 'Update Assignment' : 'Assign Staff'; ?>
                </button>
                <?php if ($assignment): ?>
                    <input type="hidden" name="id" value="<?php echo $assignment['id']; ?>">
                <?php endif; ?>
                 <!-- Cancel Button (Only visible in update mode) -->
                 <?php if (isset($assignment)): ?>
                    <a href="assign_staff.php"><button type="button" id="cancel-btn" class="text-gray-600 px-4 py-2 rounded bg-gray-300 font-semibold mt-4 ml-4 hover:bg-gray-400" onclick="cancelEdit()">Cancel</button></a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Display existing assignments -->
        <h3 class="text-2xl font-bold text-orange-500 mb-4">Assigned Staff</h3>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-orange-500">
                    <th class="px-6 py-3 border-b text-white">Employee No</th>
                    <th class="px-6 py-3 border-b text-white">Vehicle No</th>
                    <th class="px-6 py-3 border-b text-white">Effective From</th>
                    <th class="px-6 py-3 border-b text-white">Lane No</th>
                    <th class="px-6 py-3 border-b text-white">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="px-6 py-3 border-b"><?php echo $row['employee_no']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['vehicle_no']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['date']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['lane_no']; ?></td>
                    <td class="px-6 py-3 border-b">
						<!-- Update and Delete buttons -->
						<a href="assign_staff.php?id=<?php echo $row['id']; ?>" class="bg-black text-white px-4 py-1 ml-10 hover:bg-gray-600">Update</a>
						<form action="assign_staff.php" method="POST" class="inline-block" onsubmit="return confirmDelete()">
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

<script>
    // This function will show a confirmation dialog when trying to delete an assignment
    function confirmDelete() {
        return confirm("Are you sure you want to delete this assignment?");
    }
</script>


</body>
</html>

<?php $conn->close(); ?>
