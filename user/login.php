<?php
// Include database connection
include '../config/database.php';

// Start session
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape user input to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Plain text password

    // Query to check if the user exists in the database
    $loginQuery = "SELECT * FROM household_registration WHERE name = '$name' AND password = '$password'";
    $result = mysqli_query($conn, $loginQuery);

    // If the user exists
    if (mysqli_num_rows($result) > 0) {
        // Store the name in the session
        $_SESSION['name'] = $name;
        // Redirect to the view_schedules.php page
        header("Location: view_schedules.php");
        exit(); // Make sure the script stops after redirection
    } else {
        $errorMessage = "Invalid name or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-500 flex items-center justify-center min-h-screen">
    <!-- Back Button -->
    <div class="absolute top-20 left-32">
        <a href="../index.php" class="flex items-center text-white hover:text-black text-2xl font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-6 w-6 mr-2 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M11 19l-7-7 7-7M4 12h16" />
            </svg>
            Back
        </a>
    </div>

    <!-- Login Form -->
    <div class="w-full max-w-sm bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold text-center mb-6 text-green-500">Household Login</h1>
        
        <?php if (isset($errorMessage)): ?>
            <div class="text-red-600 text-center mb-4"><?= $errorMessage ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block font-medium">User name</label>
                <input type="text" name="name" class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Password</label>
                <input type="text" name="password" class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">
                Login
            </button>

            <!-- Reg Page Link -->
            <p class="mt-4 text-center">
                Don't have an account? <a href="user_reg.php" class="text-green-700 hover:text-green-500">Register here</a>
            </p>
        </form>
    </div>
</body>
</html>
