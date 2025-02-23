<?php
include '../config/database.php';
session_start();

// Check if manager is logged in
if (!isset($_SESSION['manager'])) {
    header("Location: login.php");
    exit;
}

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'create') {
        $lane_no = $_POST['lane_no'];
        $description = $_POST['description'];
        $no_of_houses = $_POST['no_of_houses'];
        $query = $conn->prepare("INSERT INTO area (lane_no, description, no_of_houses) VALUES (?, ?, ?)");
        $query->bind_param('ssi', $lane_no, $description, $no_of_houses);
        $query->execute();
    } elseif ($action === 'update') {
        $id = $_POST['id'];
        $lane_no = $_POST['lane_no'];
        $description = $_POST['description'];
        $no_of_houses = $_POST['no_of_houses'];
        $query = $conn->prepare("UPDATE area SET lane_no = ?, description = ?, no_of_houses = ? WHERE id = ?");
        $query->bind_param('ssii', $lane_no, $description, $no_of_houses, $id);
        $query->execute();
    } elseif ($action === 'delete') {
        $id = $_POST['id'];
        $query = $conn->prepare("DELETE FROM area WHERE id = ?");
        $query->bind_param('i', $id);
        $query->execute();
    }
}

// Fetch Areas
$areas = $conn->query("SELECT * FROM area");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-300 p-6 min-h-screen">
    <!-- Back Button and Heading in the Same Row -->
    <div class="flex items-center space-x-4 py-3 mb-5">
        <!-- Back Button -->
        <a href="dashboard.php" class="flex items-center text-orange-500 hover:text-orange-700 text-2xl font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-6 w-6 mr-2 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M11 19l-7-7 7-7M4 12h16" />
            </svg>
        </a>
        <!-- Heading -->
        <h1 class="text-3xl font-bold text-orange-500">Area Management</h1>
    </div>

    <!-- Create Form -->
    <form method="POST" class="mb-4">
        <input type="hidden" name="action" value="create">
        <div class="grid grid-cols-3 gap-4">
            <input type="text" name="lane_no" placeholder="Lane No" class="border rounded-lg px-3 py-2" required>
            <input type="text" name="description" placeholder="Description" class="border rounded-lg px-3 py-2" required>
            <input type="number" name="no_of_houses" placeholder="No. of Houses" class="border rounded-lg px-3 py-2" required>
        </div>
        <button type="submit" class=" text-white px-4 py-2 rounded bg-orange-500 font-semibold mt-4 hover:bg-orange-600">Create an Area</button>
    </form>

    <!-- Area Table -->
    <table class="w-full bg-white shadow border">
        <thead>
            <tr class="bg-orange-500">
                <th class="border px-4 py-2 text-white">Lane No</th>
                <th class="border px-4 py-2 text-white">Description</th>
                <th class="border px-4 py-2 text-white">No. of Houses</th>
                <th class="border px-4 py-2 text-white">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($area = $areas->fetch_assoc()): ?>
                <tr>
                    <td class="border px-4 py-2"><?= $area['lane_no'] ?></td>
                    <td class="border px-4 py-2"><?= $area['description'] ?></td>
                    <td class="border px-3 py-2"><?= $area['no_of_houses'] ?></td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <!-- Update Form -->
                        <form method="POST" class="flex">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?= $area['id'] ?>">
                            <input type="text" name="lane_no" value="<?= $area['lane_no'] ?>" class="border rounded-lg px-2 py-1" required>
                            <input type="text" name="description" value="<?= $area['description'] ?>" class="border rounded-lg px-2 py-1" required>
                            <input type="number" name="no_of_houses" value="<?= $area['no_of_houses'] ?>" class="border rounded-lg px-2 py-1" required>
                            <button type="submit" class="bg-black text-white px-4 py-1  ml-10 hover:bg-gray-600">Update</button>
                        </form>

                        <!-- Delete Form -->
						<form method="POST" onsubmit="return confirmDelete()">
						    <input type="hidden" name="action" value="delete">
						    <input type="hidden" name="id" value="<?= $area['id'] ?>">
						    <button type="submit" class="bg-red-500 text-white px-4 py-1 ml-7 hover:bg-red-600">Delete</button>
						</form>                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
        <!-- JavaScript Confirmation Script -->
    <script>
        // Function to ask for deletion confirmation
        function confirmDelete() {
            return confirm("Are you sure you want to delete this area?");
        }
    </script>
    
    
</body>
</html>
