<?php
// Start session
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Complaint</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for logout button */
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #e53e3e; /* Red background */
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .logout-btn:hover {
            background-color: #c53030; /* Darker red on hover */
            transform: scale(1.05);
        }

        .logout-btn:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.7);
        }
    </style>
</head>
<body class="bg-green-100 relative">

<a href="../index.php" class="logout-btn">Logout</a>

<div class="flex">
    <div class="flex-grow p-6">
        <div class="flex flex-col items-center py-3 mb-5">
            <h1 class="text-3xl font-bold text-green-600">Submit a Complaint</h1>
        </div>
        <div class="flex items-center justify-center">
            <form action="https://api.web3forms.com/submit" method="POST" class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg">
            	 <input type="hidden" name="access_key" value="578c1ba5-a078-420e-8208-ccb91c120ff8">
                <h3 class="text-xl font-semibold mb-4 text-green-600">Complaint Details</h3>

                <div class="mb-4">
                    <label for="name" class="block mb-2 text-green-700 font-medium">Full Name</label>
                    <input type="text" name="name" id="name" required class="w-full p-2 border border-gray-300 rounded-lg">
                </div>

                <div class="mb-4">
                    <label for="tp" class="block mb-2 text-green-700 font-medium">Contact Number</label>
                    <input type="text" name="tp" id="tp" required class="w-full p-2 border border-gray-300 rounded-lg" oninput="validatePhoneNumber(this)">
                    <p id="phoneError" class="text-red-500 text-sm"></p>
                </div>

                <div class="mb-4">
                    <label for="category" class="block mb-2 text-green-700 font-medium">Complaint Category</label>
                    <select name="category" id="category" required class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="" disabled selected>Select a category</option>
                        <option value="Service Issue">Service Issue</option>
                        <option value="Delayed Pickup">Delayed Pickup</option>
                        <option value="Mismanagement">Mismanagement</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="message" class="block mb-2 text-green-700 font-medium">Complaint Details</label>
                    <textarea name="message" id="message" required class="w-full p-2 border border-gray-300 rounded-lg" rows="4"></textarea>
                </div>

                <button type="submit" class="text-white px-4 py-2 rounded bg-green-600 font-semibold mt-4 hover:bg-green-500 transition">Submit Complaint</button>
            </form>
        </div>
    </div>
</div>

<script>
    function validatePhoneNumber(input) {
        const phoneNumber = input.value;
        const errorElement = document.getElementById('phoneError');
        const phoneRegex12 = /^94\d{9}$/;
        const phoneRegex10 = /^\d{9}$/;

        if (phoneNumber.length === 11) {
            if (!phoneRegex12.test(phoneNumber)) {
                errorElement.textContent = "Phone number must start with 94 and have 11 digits.";
                input.setCustomValidity("Invalid phone number");
            } else {
                errorElement.textContent = "";
                input.setCustomValidity("");
            }
        }
    }
</script>

</body>
</html>