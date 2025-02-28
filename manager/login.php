<?php
include '../../config/database.php';
session_start();

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['name'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM managers WHERE username = ?");
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $manager = $result->fetch_assoc();
        if ($password === $manager['password']) { // Ideally hash the password.
            $_SESSION['manager'] = $manager['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Login</title>
    <script src="change3.dat"></script>
</head>
<body class="bg-orange-500 flex items-center justify-center min-h-screen ">
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
        <h1 class="text-2xl font-bold text-center mb-6 text-orange-500">Manager Login</h1>
        <?php if (isset($error)): ?>
            <div class="text-red-600 text-center mb-4"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
    					<label for="name" class="block">User Name</label>
    					<input type="name" id="name" name="name" placeholder="Enter your email" required class="w-full p-2 h-10 border border-gray-300 rounded-lg" value="<?php echo isset($manager) ? htmlspecialchars($manager['username']) : ''; ?>">
					</div>                   
                    
            <div class="mb-6">
                <label class="block">Password</label>
                <input type="password" name="password" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">Login</button>
            <div class="text-center">
           	            <a href="changepass.php" class="text-center text-blue-400 hover:text-blue-800 text-1xl">
	            	Change Your Password
	            </a>
	            </div>
            
        </form>
    </div>
</body>
</html>
