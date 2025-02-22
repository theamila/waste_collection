<?php
// Start the session
session_start();

// Check if the manager is logged in
if (!isset($_SESSION['manager'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit;
}

// Logout functionality
if (isset($_GET['logout'])) {
    // Destroy the session and log the user out
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin and Manager Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-image: url('../assets/dqad.png');
      background-size: cover;
      background-position: center;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex">
  <div class="flex">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-300 h-screen shadow-md p-4 flex flex-col">
      <h1 class="text-2xl font-bold mb-6 ml-1">Dashboard</h1>
      <ul class="space-y-5 font-semibold flex-grow text-center text-lg">
        <li><a href="area.php" class="block px-4 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600">Area</a></li>
        <li><a href="schedule.php" class="block px-4 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600">Schedule</a></li>
        <li><a href="cleaning_staff.php" class="block px-4 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600">Cleaning Staff</a></li>
        <li><a href="vehicle.php" class="block px-4 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600">Vehicle</a></li>
        <li><a href="assign_staff.php" class="block px-4 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600">Assign Staff</a></li>
      </ul>

      <!-- Logout Button at the bottom -->
      <a href="?logout=true" class="block px-4 text-center text-xl py-3 bg-red-600 text-white rounded hover:bg-red-800 mt-auto mb-6">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="flex-grow p-6">
      <!-- Content goes here -->
    </div>
  </div>
</body>
</html>
