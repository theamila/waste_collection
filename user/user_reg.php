<?php
// Include database connection
include '../../config/database.php';

// Check if connection is successful
if (!$conn) {
    die("Database connection error: " . mysqli_connect_error());
}

session_start();

// Fetch areas for the dropdown
$areasQuery = "SELECT lane_no, description FROM area";
$areasResult = mysqli_query($conn, $areasQuery);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $lane_no = mysqli_real_escape_string($conn, $_POST['lane_no']);
    $house_no = mysqli_real_escape_string($conn, $_POST['house_no']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile_number']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Store as plain text

    $insertQuery = "INSERT INTO household_registration (name, lane_no, house_no, address, mobile_number, password) 
                    VALUES ('$name', '$lane_no', '$house_no', '$address', '$mobile_number', '$password')";

    if (mysqli_query($conn, $insertQuery)) {
        $successMessage = "Registration successful!";
    } else {
        $errorMessage = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Household Registration</title>
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

  <!-- Registration Form -->
  <div class="w-full max-w-3xl bg-white p-8 rounded-lg shadow">
    <h1 class="text-2xl font-bold text-center mb-6 text-green-500">Household Registration</h1>
    
    <?php if (isset($successMessage)): ?>
      <div class="text-green-600 text-center mb-4"><?= $successMessage ?></div>
    <?php elseif (isset($errorMessage)): ?>
      <div class="text-red-600 text-center mb-4"><?= $errorMessage ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="grid grid-cols-2 gap-4">
        <!-- Left Column -->
        <div>
          <div class="mb-4">
            <label class="block font-medium">Name</label>
            <input type="text" name="name" class="w-full border rounded-lg px-3 py-2" required>
          </div>

          <div class="mb-4">
            <label class="block font-medium">Lane Number</label>
            <select name="lane_no" id="lane_no" class="w-full border rounded-lg px-3 py-2" required>
              <option value="" disabled selected>Select a Lane</option>
              <?php if ($areasResult): ?>
                  <?php while ($row = mysqli_fetch_assoc($areasResult)): ?>
                    <option value="<?= $row['lane_no'] ?>" data-description="<?= htmlspecialchars($row['description']) ?>">
                      <?= $row['lane_no'] ?>
                    </option>
                  <?php endwhile; ?>
              <?php endif; ?>
            </select>
          </div>

          <div class="mb-4">
            <label class="block font-medium">Description</label>
            <textarea id="description" class="w-full border rounded-lg px-3 py-2 h-32 bg-gray-100" readonly></textarea>
          </div>
        </div>

        <!-- Right Column -->
        <div>
          <div class="mb-4">
            <label class="block font-medium">House Number</label>
            <input type="text" name="house_no" class="w-full border rounded-lg px-3 py-2" required>
          </div>

          <div class="mb-4">
            <label class="block font-medium">Address</label>
            <input type="text" name="address" class="w-full border rounded-lg px-3 py-2" required>
          </div>

          <div class="mb-4">
            <label class="block font-medium">Mobile Number</label>
            <input type="text" name="mobile_number" class="w-full border rounded-lg px-3 py-2" required>
          </div>

          <div class="mb-4">
            <label class="block font-medium">Password</label>
            <input type="text" name="password" class="w-full border rounded-lg px-3 py-2" required>
          </div>
        </div>
      </div>

      <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 mt-6">
        Register
      </button>

      <!-- Login Page Link -->
        <p class="mt-4 text-center">
            Already have an account? <a href="login.php" class="text-green-700 hover:text-green-500">Login here</a>
        </p>
    </form>
  </div>

  <script>
    const laneSelect = document.getElementById('lane_no');
    const descriptionField = document.getElementById('description');

    laneSelect.addEventListener('change', function() {
      const selectedOption = laneSelect.options[laneSelect.selectedIndex];
      const description = selectedOption.getAttribute('data-description');
      descriptionField.value = description || '';
    });
  </script>
</body>
</html>
