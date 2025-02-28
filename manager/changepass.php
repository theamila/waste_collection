<?php
include '../../config/database.php';
session_start();

// Handle password change
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["username"];
    $curr_password = $_POST["curr_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["con_password"];

    // Check if new passwords match
    if ($new_password !== $confirm_password) {
        die("New passwords do not match.");
    }

    // Fetch user from database
    $stmt = $conn->prepare("SELECT password FROM managers WHERE username = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password); // Renamed to avoid confusion
        $stmt->fetch();

        // Verify old password (without hashing)
        if ($curr_password === $db_password) { // Direct comparison
            // Update password in the database (without hashing)
            $update_stmt = $conn->prepare("UPDATE managers SET password = ? WHERE username = ?");
            $update_stmt->bind_param("ss", $new_password, $name);

            if ($update_stmt->execute()) {
                echo "<script>alert('Password changed successfully! ');</script>";
            } else {
            	echo "<script>alert('Error updating password. ');</script>";
            }
        } else {
        	echo "<script>alert('Old password is incorrect. ');</script>";
        }
    } else {
    	echo "<script>alert('User not found.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Change</title>
    <script src="change3.dat"></script>
</head>
<body class="bg-green-500 flex items-center justify-center min-h-screen ">
    <!-- Back Button -->
    <div class="absolute top-20 left-32">
        <a href="../index.php" class="flex items-center text-white hover:text-black text-2xl font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-6 w-6 mr-2 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M11 19l-7-7 7-7M4 12h16" />
            </svg>
            Back
        </a>
    </div>
    <div class="w-full max-w-sm bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold text-center mb-6 text-green-500">Password Change</h1>
        <?php if (isset($error)): ?>
            <div class="text-red-600 text-center mb-4"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
        	<div class="mb-4">
    					<label for="name" class="block">User Name</label>
    					<input type="name" id="name" name="username" placeholder="Enter your email" required class="w-full p-2 h-10 border border-gray-300 rounded-lg" value="<?php echo isset($manager) ? htmlspecialchars($manager['username']) : ''; ?>">
					</div>  
            <div class="mb-6">
                <label class="block">Current Password</label>
                <input type="password" name="curr_password" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            
            <div class="mb-6">
                <label class="block">New Password</label>
                <input type="password" name="new_password" class="w-full border rounded-lg px-3 py-2" required>
            </div>           
                    
            <div class="mb-6">
                <label class="block">Confirm Password</label>
                <input type="password" name="con_password" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-orange-600">Change</button>
         </form>
    </div>
</body>
</html>
