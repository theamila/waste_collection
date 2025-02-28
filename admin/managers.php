<?php
// Database connection
include '../../config/database.php';
session_start();

// Fetch manager details if updating
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM managers WHERE id = $id";
    $result = $conn->query($sql);
    $manager = $result->fetch_assoc(); // Fetch the manager details to display in the form
}

// Handle Create, Update, and Delete operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        // Create operation
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "INSERT INTO managers (username, password) VALUES ('$username', '$password')";
        $conn->query($sql);
    } elseif (isset($_POST['update'])) {
        // Update operation
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "UPDATE managers SET username='$username', password='$password' WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        
        // Delete operation
        $id = $_POST['id'];
        $sql = "DELETE FROM managers WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch existing managers for listing
$sql = "SELECT * FROM managers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Management</title>
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
            <h1 class="text-3xl font-bold text-blue-500">Manage Managers</h1>
        </div>

        <!-- Create or Update Manager Form -->
        <div class="flex items-center justify-center">
            <form action="managers.php" method="POST" class="bg-white p-6 rounded-lg shadow-md mb-6 w-3/4" id="manager-form">
                <h3 id="form-title" class="text-xl font-semibold mb-4 text-blue-500"><?php echo isset($manager) ? "Update Manager" : "Create New Manager"; ?></h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="username" class="block mb-2">User Name</label>
                        <input type="name" name="username" id="username" required class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo isset($manager) ? $manager['username'] : ''; ?>">
                    </div>
                    <div>
                        <label for="password" class="block mb-2">Password</label>
                        <input type="password" name="password" id="password" required class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo isset($manager) ? $manager['password'] : ''; ?>">
                    </div>
                </div>
                <button type="submit" id="submit-btn" name="<?php echo isset($manager) ? 'update' : 'create'; ?>" class="text-white px-4 py-2 rounded bg-blue-500 font-semibold mt-4 hover:bg-blue-600"><?php echo isset($manager) ? 'Update Manager' : 'Create Manager'; ?></button>
                <?php if (isset($manager)): ?>
                    <input type="hidden" name="id" value="<?php echo $manager['id']; ?>">
                    <a href="managers.php"><button type="button" id="cancel-btn" class="text-gray-600 px-4 py-2 rounded bg-gray-300 font-semibold mt-4 ml-4 hover:bg-gray-400">Cancel</button></a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Display existing managers -->
        <h3 class="text-2xl font-bold text-blue-500 mb-4">Existing Managers</h3>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-blue-500">
                    <th class="px-6 py-3 border-b text-white">ID</th>
                    <th class="px-6 py-3 border-b text-white">Email</th>
                    <th class="px-6 py-3 border-b text-white">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="px-6 py-3 border-b"><?php echo $row['id']; ?></td>
                    <td class="px-6 py-3 border-b"><?php echo $row['username']; ?></td>
                    <td class="px-6 py-3 border-b">
                        <!-- Use flex to align buttons and center them -->
                        <div class="flex justify-center space-x-4">
                            <a href="managers.php?id=<?php echo $row['id']; ?>" class="bg-black text-white px-4 py-1 hover:bg-gray-600">Update</a>
								<form action="managers.php" method="POST" class="inline-block" onsubmit="return confirmDelete();">
    								<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    								<button type="submit" name="delete" class="bg-red-600 text-white px-4 py-1 hover:bg-red-500">Delete</button>
								</form>                        
						</div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>
</div>

        <!-- JavaScript Confirmation Script -->
    <script>
        // Function to ask for deletion confirmation
        function confirmDelete() {
            return confirm("Are you sure you want to delete this manager?");
        }
    </script>



</body>
</html>

<?php $conn->close(); ?>
