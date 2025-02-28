<?php
// Include database connection
include '../../config/database.php';

// Check if connection is successful
if (!$conn) {
    die("Database connection error: " . mysqli_connect_error());
}

session_start();

// Initialize success and error messages
$successMessage = "";
$errorMessage = "";

// Fetch areas for the dropdown (Execute the query here)
$areasQuery = "SELECT lane_no, description FROM area";
$areasResult = mysqli_query($conn, $areasQuery);

// Check for errors in the query
if (!$areasResult) {
    $errorMessage = "Error fetching areas: " . mysqli_error($conn);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $lane_no = mysqli_real_escape_string($conn, $_POST['lane_no']);
    $house_no = mysqli_real_escape_string($conn, $_POST['house_no']);
    $bin_no = mysqli_real_escape_string($conn, $_POST['bin_no']);    
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

   
    $insertQuery = "INSERT INTO household_registration (name, lane_no, house_no, bin_no, address, description, mobile_number, email, password)
                    VALUES ('$name', '$lane_no', '$house_no', '$bin_no', '$address', '$description', '$mobile_number', '$email', '$password')";

    if (mysqli_query($conn, $insertQuery)) {
        $successMessage = "Registration successful!";
        $_POST = array(); // Clear $_POST array (optional)
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

    <div class="absolute top-20 left-32">
        <a href="../user/main_login.php" class="flex items-center text-white hover:text-black text-2xl font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-6 w-6 mr-2 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M11 19l-7-7 7-7M4 12h16" />
            </svg>
            Back
        </a>
    </div>

    <div class="w-full max-w-3xl bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold text-center mb-6 text-green-500">Household Registration</h1>

        <?php if ($successMessage): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline"><?= $successMessage ?></span>
            </div>
        <?php elseif ($errorMessage): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"><?= $errorMessage ?></span>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <div class="mb-4">
                        <label for="name" class="block font-medium">Name</label>
                        <input type="text" id="name" name="name" class="w-full border rounded-lg px-3 py-2 h-10" required>
                    </div>

                    <div class="mb-4">
                        <label for="lane_no" class="block font-medium">Lane Number</label>
                        <select id="lane_no" name="lane_no" class="w-full border rounded-lg px-3 py-2 h-10" required>
                            <option value="" disabled selected>Select a Lane</option>
                            <?php if ($areasResult && mysqli_num_rows($areasResult) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($areasResult)): ?>
                                    <option value="<?= $row['lane_no'] ?>" data-description="<?= htmlspecialchars($row['description']) ?>">
                                        <?= $row['lane_no'] ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="" disabled>No lanes available</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="house_no" class="block font-medium">House Number</label>
                        <input type="text" id="house_no" name="house_no" class="w-full border rounded-lg px-3 py-2  h-10" required>
                    </div>


                    <div >
                        <label for="description" class="block font-medium">Description</label>
                        <textarea id="description" name="description" class="w-full border rounded-lg px-3 py-2 h-40 bg-gray-100" readonly></textarea>
                    </div>
                </div>

                <div>

					
				<div class="mb-4">
    				<label for="bin_no" class="block font-medium">Bin Number</label>
    				<input type="text" id="bin_no" name="bin_no" class="w-full border rounded-lg px-3 py-2 h-10"  title="Bin number must be in the format ###-###-###-###">
    				
				</div>
					
                    <div class="mb-4">
                        <label for="address" class="block font-medium">Address</label>
                        <input type="text" id="address" name="address" class="w-full border rounded-lg px-3 py-2 h-10" required>
                    </div>

                    <div class="mb-4">
                        <label for="mobile_number" class="block font-medium">Mobile Number</label>
                        <input type="text" id="mobile_number" name="mobile_number" class="w-full border rounded-lg px-3 py-2 h-10" required
                        	value="<?php echo isset($staff) ? $staff['mobile'] : ''; ?>"
					        placeholder="Enter mobile number (e.g., 94345678909)" 
					        pattern="^(94\d{9})$" title="Phone number must be 11 digits starting with 94"
							/>
                    </div>
                    
                    


					<div class="mb-4">
    					<label for="email" class="block font-medium">Email</label>
    					<input type="email" id="email" name="email" placeholder="Enter your email" required class="w-full p-2 h-10 border border-gray-300 rounded-lg" value="<?php echo isset($manager) ? htmlspecialchars($manager['username']) : ''; ?>">
    					<?php
    					if (isset($_POST['email'])) {
        					$email = $_POST['email'];
        					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            					echo '<p style="color: red;">Invalid email format</p>';
        					}
    					}
   					 	?>
					</div>                   
                    
                    

					<div class="mb-4 relative">  <label for="password" class="block font-medium">Password</label>
    					<input type="password" id="password" name="password" class="w-full border rounded-lg px-3 py-2 h-10" required>
    					<span class="absolute inset-y-0 right-3 flex items-center">
        					<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" id="togglePassword" onclick="togglePasswordVisibility()" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            					<path id="eyeIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
           	 					<path id="eyeSlashIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.983 6.983a2.5 2.5 0 00-3.216 4.092A9.713 9.713 0 011.75 12c0 .463.07.924.2 1.383a10.293 10.293 0 00.894 2.983A2.5 2.5 0 016.217 18.908m13.828-4.092c-6.127-6.127-16.032-5.866-16.032 0 0 2.44 1.22 4.668 3.052 5.952m8.052-5.952v-1.588m-9-2.258l-.707-.707" />
       						</svg>
    					</span>
					</div>

<script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeSlashIcon = document.getElementById('eyeSlashIcon');

    eyeSlashIcon.style.display = "none"; // Initially hide the eye-slash icon

    function togglePasswordVisibility() {
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
</script>                </div>
            </div>

            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 mt-6">
                Register
            </button>

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