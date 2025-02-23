<?php 
// Database connection
include '../../config/database.php';
session_start();

// Fetch cleaning staff details if updating
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM cleaning_staff WHERE id = $id";
    $result = $conn->query($sql);
    $staff = $result->fetch_assoc(); // Fetch the staff details to display in the form
}

// Handle Create, Update, and Delete operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        // Create operation
        $employee_no = $_POST['employee_no'];
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $type = $_POST['type'];

        $sql = "INSERT INTO cleaning_staff (employee_no, name, mobile, type)
                VALUES ('$employee_no', '$name', '$mobile', '$type')";
        $conn->query($sql);
    } elseif (isset($_POST['update'])) {
        // Update operation
        $id = $_POST['id'];
        $employee_no = $_POST['employee_no'];
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $type = $_POST['type'];

        $sql = "UPDATE cleaning_staff SET employee_no='$employee_no', name='$name', mobile='$mobile', type='$type'
                WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        // Delete operation
        $id = $_POST['id'];
        $sql = "DELETE FROM cleaning_staff WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch existing cleaning staff for listing
$sql = "SELECT * FROM cleaning_staff";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cleaning Staff Management</title>
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
            <h1 class="text-3xl font-bold text-orange-500">Manage Cleaning Staff</h1>
        </div>

        <!-- Create or Update Cleaning Staff Form -->
        <div class="flex items-center justify-center">
            <form action="cleaning_staff.php" method="POST" class="bg-white p-6 rounded-lg shadow-md mb-6 w-3/4" id="staff-form">
                <h3 id="form-title" class="text-xl font-semibold mb-4 text-orange-500"><?php echo isset($staff) ? "Update Cleaning Staff" : "Create New Cleaning Staff"; ?></h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="employee_no" class="block mb-2">Employee No</label>
                        <input type="text" name="employee_no" id="employee_no" required class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo isset($staff) ? $staff['employee_no'] : ''; ?>">
                    </div>
                    <div>
                        <label for="name" class="block mb-2">Name</label>
                        <input type="text" name="name" id="name" required class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo isset($staff) ? $staff['name'] : ''; ?>">
                    </div>
					<div>
					    <label for="mobile" class="block mb-2">Mobile</label>
					    <input type="text" name="mobile" id="mobile" required class="w-full p-2 border border-gray-300 rounded-lg"
					        value="<?php echo isset($staff) ? $staff['mobile'] : ''; ?>"
					        placeholder="Enter mobile number (e.g., +94345678909)" 
					        pattern="^(0\d{9}|\+94\d{9})$" title="Phone number must be 10 digits starting with 0 or 12 digits starting with +94"
					        />
					</div>
                    <div>
                        <label for="type" class="block mb-2">Type</label>
                        <select name="type" id="type" required class="w-full p-2 border border-gray-300 rounded-lg">
                            <option value="" disabled selected>Select an option</option>    
                            <option value="Collector" <?php echo (isset($staff) && $staff['type'] == 'Collector') ? 'selected' : ''; ?>>Collector</option>
                            <option value="Driver" <?php echo (isset($staff) && $staff['type'] == 'Driver') ? 'selected' : ''; ?>>Driver</option>
                        </select>
                    </div>
                </div>
                <button type="submit" id="submit-btn" name="<?php echo isset($staff) ? 'update' : 'create'; ?>" class="text-white px-4 py-2 rounded bg-orange-500 font-semibold mt-4 hover:bg-orange-600"><?php echo isset($staff) ? 'Update Staff' : 'Create Staff'; ?></button>
                <?php if (isset($staff)): ?>
                    <input type="hidden" name="id" value="<?php echo $staff['id']; ?>">
                <?php endif; ?>
                <!-- Cancel Button (Only visible in update mode) -->
                <?php if (isset($staff)): ?>
                    <a href="cleaning_staff.php"><button type="button" id="cancel-btn" class="text-gray-600 px-4 py-2 rounded bg-gray-300 font-semibold mt-4 ml-4 hover:bg-gray-400" onclick="cancelEdit()">Cancel</button></a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Display existing cleaning staff -->
        <h3 class="text-2xl font-bold text-orange-500 mb-4">Existing Cleaning Staff</h3>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-orange-500">
                    <th class="px-6 py-3 border-b text-white">Employee No</th>
                    <th class="px-6 py-3 border-b text-white">Name</th>
                    <th class="px-6 py-3 border-b text-white">Mobile</th>
                    <th class="px-6 py-3 border-b text-white">Type</th>
                    <th class="px-6 py-3 border-b text-white">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="px-6 py-3 border-b"><?php echo $row['employee_no']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['name']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['mobile']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['type']; ?></td>
                    <td class="px-6 py-3 border-b">
                       
						<!-- Update and Delete buttons -->
						<a href="cleaning_staff.php?id=<?php echo $row['id']; ?>" class="bg-black text-white px-4 py-1  ml-10 hover:bg-gray-600">Update</a>
						<form action="cleaning_staff.php" method="POST" class="inline-block" onsubmit="return confirmDelete()">
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


<!-- Inline JavaScript Confirmation Script -->
<script>
    // Function to ask for deletion confirmation
    function confirmDelete() {
        return confirm("Are you sure you want to delete this cleaning staff?");
    }
</script>



</body>
</html>

<?php $conn->close(); ?>
