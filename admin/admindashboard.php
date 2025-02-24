<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    // If not logged in, redirect to the login page
    header("Location: adminlogin.php");
    exit;
}

// Logout functionality
if (isset($_GET['logout'])) {
    // Destroy the session and log the user out
    session_destroy();
    header("Location: adminlogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-image: url('../assets/admin-dash.jpg');
      background-size: cover;
      background-position: center;
    }
  </style>
  <script>
  function toggleSection() {
    const sectionList = document.getElementById('section-list');
    const arrowIcon = document.getElementById('arrow-icon');

    if (sectionList.classList.contains('hidden')) {
      sectionList.classList.remove('hidden');
      arrowIcon.classList.add('rotate-180'); // Rotate the arrow up
    } else {
      sectionList.classList.add('hidden');
      arrowIcon.classList.remove('rotate-180'); // Reset the arrow to default
    }
  }
</script>

</head>
<body class="bg-gray-50 min-h-screen flex">
  <div class="flex">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-300 h-screen shadow-md p-4 flex flex-col text-white">
      <h1 class="text-2xl font-bold mb-6 ml-1 text-black">Admin Dashboard</h1>
      
        <!-- Expandable Section -->
        <!-- <div>
          <button onclick="toggleSection()" class="w-full text-left px-4 py-3 bg-blue-700 rounded-lg hover:bg-blue-700 flex justify-between items-center">
            Manage Sections
            <svg id="arrow-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <ul id="section-list" class="mt-2 space-y-5 font-semibold text-center text-lg hidden">
            <li><a href="area.php" class="block px-4 py-3 bg-blue-600 rounded-lg hover:bg-blue-700">Area</a></li>
            <li><a href="schedule.php" class="block px-4 py-3 bg-blue-600 rounded-lg hover:bg-blue-700">Schedule</a></li>
            <li><a href="cleaning_staff.php" class="block px-4 py-3 bg-blue-600 rounded-lg hover:bg-blue-700">Cleaning Staff</a></li>
            <li><a href="vehicle.php" class="block px-4 py-3 bg-blue-600 rounded-lg hover:bg-blue-700">Vehicle</a></li>
            <li><a href="assign_staff.php" class="block px-4 py-3 bg-blue-600 rounded-lg hover:bg-blue-700">Assign Staff</a></li>
          </ul>
        </div> -->

        <!-- Separate Manage Managers Link -->
        <ul class="space-y-5 font-semibold flex-grow text-center text-lg mt-6">
          <li><a href="managers.php" class="block px-4 py-3 bg-blue-600 rounded-lg hover:bg-blue-700">Manage Managers</a></li>
          <li><a href="garbage_status.php" class="block px-4 py-3 bg-blue-600 rounded-lg hover:bg-blue-700">Garbage Collection Status</a></li>
          <li><a href="https://mon-backend.azurewebsites.net/worldmap/" class="block px-4 py-3 bg-blue-600 rounded-lg hover:bg-blue-700">Live Location</a></li>

        </ul>
        <a href="?logout=true" class="block w-3/4 ml-9 px-4 text-center text-lg py-2 bg-red-600 text-white rounded hover:bg-red-800 mt-auto mb-6">Logout</a>
    </div>

    <!-- Main Content -->
    <!-- <div class="flex-grow p-6 bg-white shadow-md rounded-lg">
      <h2 class="text-3xl font-bold text-blue-500 mb-4">Welcome, Admin!</h2>
      <p class="text-lg text-gray-700">Use the sidebar to navigate and manage the system.</p>
    </div> -->
  </div>
</body>
</html>
