<?php
// Database connection
include '../config/database.php';
session_start();

// Handle login
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email']; // Changed from 'username' to 'email'
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE email = '$email'"; // Changed from 'username' to 'email'
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) { // Plain-text password check (use hashing in production)
            $_SESSION['admin'] = $row['email']; // Changed to store 'email' in the session
            header("Location: admindashboard.php");
            exit;
        } else {
            $error = "Invalid email or password. Please try again.";
        }
    } else {
        $error = "Invalid email or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-500 flex items-center justify-center h-screen">
    <!-- Back Button -->
    <div class="absolute top-20 left-32">
        <a href="../index.php" class="flex items-center text-white hover:text-black text-2xl font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-6 w-6 mr-2 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M11 19l-7-7 7-7M4 12h16" />
            </svg>
            Back
        </a>
    </div>

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-blue-500 text-center mb-6">Admin Login</h2>
        <?php if ($error): ?>
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form action="adminlogin.php" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label> <!-- Changed label to 'Email' -->
                <input type="email" id="email" name="email" required 
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"> <!-- Changed input type to 'email' -->
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" required 
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" 
                    class="w-full bg-blue-500 text-white py-2 rounded-lg font-medium hover:bg-blue-600">
                Login
            </button>
        </form>
    </div>

</body>
</html>
