<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main Menu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url('./assets/main_img.jpg');
      background-size: cover;
      background-position: center;
    }
  </style>
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('-translate-x-full');
    }
  </script>
</head>
<body class="bg-gray-900 bg-opacity-50 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-gray-800 text-white py-4 px-6 flex items-center">
    <!-- Hamburger Menu -->
    <button onclick="toggleSidebar()" class="text-3xl hover:text-green-300">
      <i class="bx bx-menu"></i>
    </button>
    <h1 class="ml-4 text-2xl font-bold">Municipal Council - Moratuwa</h1>
  </header>

  <!-- Sidebar -->
  <div id="sidebar" class="fixed top-0 left-0 w-64 bg-gray-200 shadow-lg h-full py-8 px-6 transform -translate-x-full transition-transform duration-300 z-50">
    <!-- Close Button -->
    <button onclick="toggleSidebar()" class="absolute top-4 right-4 text-3xl text-gray-600 focus:outline-none hover:text-red-700">
      <i class="bx bx-x"></i>
    </button>

    <h1 class="text-2xl font-bold uppercase mb-8 ml-16 underline">Menu</h1>
    <div class="space-y-5 flex flex-col">
      <!-- Administration Dropdown -->
      <div>
        <button class="w-full bg-gray-300 text-black font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-gray-400 focus:ring-4 focus:ring-gray-200 transition flex justify-between items-center" onclick="toggleDropdown('adminDropdown')">
          Administration
          <i class="bx bx-chevron-down mr-2 text-xl"></i>
        </button>
        <div id="adminDropdown" class="hidden mt-2 space-y-2">
          <a href="./admin/adminlogin.php" class="block bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Admin Login</a>
          <a href="./manager/login.php" class="block bg-orange-600 text-white py-2 px-4 rounded-lg hover:bg-orange-700">Management Login</a>
        </div>
      </div>

      <!-- User Dropdown -->
      <div>
        <button class="w-full bg-gray-300 text-black font-semibold py-2 px-4  rounded-lg shadow-md hover:bg-gray-400 focus:ring-4 focus:ring-gray-200 transition flex justify-between items-center" onclick="toggleDropdown('userDropdown')">
          User
          <i class="bx bx-chevron-down mr-2 text-xl"></i>
        </button>
        <div id="userDropdown" class="hidden mt-2 space-y-2">
          <a href="./user/login.php" class="block bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700">Household Registration</a>
          <a href="#" class="block bg-yellow-600 text-white py-2 px-4 rounded-lg hover:bg-yellow-700">Schedule</a>
          <a href="#" class="block bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700">Complaints</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <!-- <div class="flex-grow flex items-center justify-center text-white">
    <h1 class="text-4xl font-extrabold px-7 py-5 uppercase outline text-blue-800">Welcome to Municipal Council - Moratuwa</h1>  </div>-->
  

  <script>
    // Function to toggle dropdown menus
    function toggleDropdown(dropdownId) {
      const dropdown = document.getElementById(dropdownId);
      dropdown.classList.toggle('hidden');
    }
  </script>

</body>
</html>
