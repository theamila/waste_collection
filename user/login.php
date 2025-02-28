<?php
// Include database connection
include '../config/database.php';

session_start();

// Handle login
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM household_registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) { // Plain-text password check (use hashing in production)
            $_SESSION['login'] = $row['email']; // Set the session variable
            //Debug info
            //var_dump($_SESSION);
            //echo "login success";
            header("Location: update_user.php");
            exit;
        } else {
            $error = "Invalid email or password. Please try again.";
        }
    } else {
        $error = "Invalid email or password. Please try again.";
    }

    $stmt->close();
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

    <div class="absolute top-20 left-32">
        <a href="../user/main_login.php" class="flex items-center text-white hover:text-black text-2xl font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-6 w-6 mr-2 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M11 19l-7-7 7-7M4 12h16" />
            </svg>
            Back
        </a>
    </div>

    <div class="w-full max-w-sm bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold text-center mb-6 text-green-500">Household Login</h1>

        <?php if (!empty($error)): ?>
            <div class="text-red-600 text-center mb-4"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label for="email" class="block font-medium">Email</label>
                <input type="email" id="email" name="email" required class="w-full p-2 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-4 relative">
                <label for="password" class="block font-medium">Password</label>
                <input type="password" id="password" name="password" required class="w-full border rounded-lg px-3 py-2">
                <span class="absolute inset-y-0 right-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" id="togglePassword" onclick="togglePasswordVisibility()" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path id="eyeIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path id="eyeSlashIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l5.5 5.5M21 21l-5.5-5.5" style="display: none;" />
                    </svg>
                </span>
            </div>

            <script>
                function togglePasswordVisibility() {
                    const passwordInput = document.getElementById('password');
                    const eyeIcon = document.getElementById('eyeIcon');
                    const eyeSlashIcon = document.getElementById('eyeSlashIcon');

                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        eyeIcon.style.display = "none";
                        eyeSlashIcon.style.display = "block";
                    } else {
                        passwordInput.type = "password";
                        eyeIcon.style.display = "block";
                        eyeSlashIcon.style.display = "none";
                    }
                }
            </script>

            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 font-bold text-lg">
                Login
            </button>
        </form>
    </div>
</body>
</html>
