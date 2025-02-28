<?php
include '../../config/database.php';

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$loggedInEmail = $_SESSION['login'];

// Fetch garbage collection data using JOIN
$garbageQuery = $conn->prepare("SELECT g.date, g.time, g.remaining_weight FROM garbage_collection_status g JOIN household_registration h ON g.bin_no = h.bin_no WHERE h.email = ? ORDER BY g.date DESC LIMIT 1");
$garbageQuery->bind_param("s", $loggedInEmail);
$garbageQuery->execute();
$garbageResult = $garbageQuery->get_result();

if ($garbageResult->num_rows > 0) {
    $garbageRow = $garbageResult->fetch_assoc();
    $date = $garbageRow['date'];
    $time = $garbageRow['time'];
    $weight = $garbageRow['remaining_weight'];
} else {
    $date = "";
    $time = "";
    $weight = "";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //print_r($_POST); // Removed for security reasons in production

    $name = $_POST['name'];
    $lane_no = $_POST['lane_no'];
    $house_no = $_POST['house_no'];
    $bin_no = $_POST['bin_no'];
    $address = $_POST['address'];
    $description = $_POST['description'];

    if (empty($description)) {
        echo "<script>alert('Error: Description cannot be empty.'); window.location.href = window.location.href;</script>";
        exit;
    }

    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $updateQuery = $conn->prepare("UPDATE household_registration SET name = ?, lane_no = ?, house_no = ?, bin_no = ?, address = ?, description = ?, mobile_number = ?, email = ?, password = ? WHERE email = ?");
    $updateQuery->bind_param("ssssssssss", $name, $lane_no, $house_no, $bin_no, $address, $description, $mobile_number, $email, $password, $loggedInEmail);

    if ($updateQuery->execute()) {
        $updateMessage = "Household details successfully updated!";
        echo "<script>alert('$updateMessage'); window.location.href = window.location.href;</script>";
        $householdResult = $conn->prepare("SELECT * FROM household_registration WHERE email = ?");
        $householdResult->bind_param("s", $loggedInEmail);
        $householdResult->execute();
        $householdResult = $householdResult->get_result();
    } else {
        $updateMessage = "Error updating household details: " . $updateQuery->error;
        echo "<script>alert('$updateMessage'); window.location.href = window.location.href;</script>";
    }

    $updateQuery->close();
}

// Fetch household details again, in case of an update, and to prefill the form
$householdQuery = $conn->prepare("SELECT * FROM household_registration WHERE email = ?");
$householdQuery->bind_param("s", $loggedInEmail);
$householdQuery->execute();
$householdResult = $householdQuery->get_result();
$row = $householdResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-500 p-6 min-h-screen">
	            <div class="absolute top-4 left-4">
                <a href="../user/login.php" class="flex items-center text-white hover:text-black text-2xl font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-6 w-6 mr-2 mt-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M11 19l-7-7 7-7M4 12h16" />
                    </svg>
                    Back
                </a>
            </div>

    <div class="max-w-6xl mx-auto">
        <form method="POST" class="bg-white p-6 rounded-lg shadow-md mb-6 relative">

            <h2 class="text-3xl font-semibold mb-4 text-green-600 font-bold">Update Household Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
                <div class="flex flex-col">
                    <label for="name" class="block font-semibold bg-orange-500 text-white px-2 py-1 rounded mb-1 text-sm">Name</label>
                    <input type="text" name="name" value="<?= $row['name'] ?>" class="rounded-lg px-2 py-1 border text-sm">
                </div>
                <div class="flex flex-col">
                    <label for="lane_no" class="block font-semibold bg-orange-500 text-white px-2 py-1 rounded mb-1 text-sm">Lane No</label>
                    <input type="text" name="lane_no" value="<?= $row['lane_no'] ?>" class="rounded-lg px-2 py-1 border text-sm">
                </div>
                <div class="flex flex-col">
                    <label for="house_no" class="block font-semibold bg-orange-500 text-white px-2 py-1 rounded mb-1 text-sm">House No</label>
                    <input type="text" name="house_no" value="<?= $row['house_no'] ?>" class="rounded-lg px-2 py-1 border text-sm">
                </div>
                <div class="flex flex-col">
                    <label for="bin_no" class="block font-semibold bg-orange-500 text-white px-2 py-1 rounded mb-1 text-sm">Bin No</label>
                    <input type="text" name="bin_no" value="<?= $row['bin_no'] ?>" class="rounded-lg px-2 py-1 border text-sm">
                </div>
                <div class="flex flex-col">
                    <label for="address" class="block font-semibold bg-orange-500 text-white px-2 py-1 rounded mb-1 text-sm">Address</label>
                    <input type="text" name="address" value="<?= $row['address'] ?>" class="rounded-lg px-2 py-1 border text-sm">
                </div>
                <div class="flex flex-col">
                    <label for="description" class="block font-semibold bg-orange-500 text-white px-2 py-1 rounded mb-1 text-sm">Description</label>
                    <input type="text" name="description" value="<?= $row['description'] ?>" class="rounded-lg px-2 py-1 border text-sm">
                </div>
                <div class="flex flex-col">
                    <label for="mobile_number" class="block font-semibold bg-orange-500 text-white px-2 py-1 rounded mb-1 text-sm">Phone No</label>
                    <input type="text" name="mobile_number" value="<?= $row['mobile_number'] ?>" class="rounded-lg px-2 py-1 border text-sm">
                </div>
                <div class="flex flex-col">
                    <label for="email" class="block font-semibold bg-orange-500 text-white px-2 py-1 rounded mb-1 text-sm">Email</label>
                    <input type="email" name="email" value="<?= $row['email'] ?>" class="rounded-lg px-2 py-1 border text-sm">
                </div>
                <div class="flex flex-col">
                    <label for="password" class="block font-semibold bg-orange-500 text-white px-2 py-1 rounded mb-1 text-sm">Password</label>
                    <input type="password" name="password" value="<?= $row['password'] ?>" class="rounded-lg px-2 py-1 border text-sm">
                </div>
                <div class="flex flex-col">

                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 w-full text-sm">Update</button>
                </div>
            </div>
        </form>

        
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-3xl font-semibold mb-4 text-green-600 font-bold">Garbage Collection Status</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="dateInput1" class="block font-semibold bg-orange-500 text-white px-3 py-2 rounded mb-2">Date</label>
                    <input type="text" id="dateInput1" name="date1" value="<?php echo $date; ?>" class="border rounded-lg px-3 py-2 w-full">
                </div>
                <div>
                    <label for="timeInput" class="block font-semibold bg-orange-500 text-white px-3 py-2 rounded mb-2">Time</label>
                    <input type="text" id="timeInput" name="time" value="<?php echo $time; ?>" class="border rounded-lg px-3 py-2 w-full">
                </div>
                <div>
                    <label for="weightInput" class="block font-semibold bg-orange-500 text-white px-3 py-2 rounded mb-2">Remaining Weight</label>
                    <input type="text" id="weightInput" name="weight" value="<?php echo $weight; ?>" class="border rounded-lg px-3 py-2 w-full">
                </div>
            </div>
        </div>

		<div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-3xl font-semibold mb-4 text-green-600 font-bold">See Live Location</h2>
            <div class="text-center">
                <a href="https://mon-backend.azurewebsites.net/worldmap?unit_id=1" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 inline-block">Live Location</a>
            </div>
        </div>
    </div>

</body>
</html>