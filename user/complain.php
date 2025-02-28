<?php
// Start session
session_start();


// Check if logout is requested
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    // Destroy the session to log out
    session_destroy();
    // Redirect to index.php
    header("Location: ../index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contactNumber = $_POST['email']; // Assuming email is used for phone number
    $category = $_POST['category'];
    $message = $_POST['message'];

    // Email configuration
    $to = 'sujanimrajapaksha@gmail.com'; // Recipient email address
    $subject = 'New Complaint Submission';
    $emailMessage = "Full Name: $name\nContact Number: $contactNumber\nCategory: $category\nMessage: $message";
    $headers = 'From: noreply@yourdomain.com' . "\r\n" . // Replace with your domain
        'Reply-To: sujanimrajapaksha@gmail.com' . "\r\n" . // Replace with your domain
        'X-Mailer: PHP/' . phpversion();

    // Send email
    if (mail($to, $subject, $emailMessage, $headers)) {
        echo '<script>alert("Complaint submitted successfully. An email has been sent.");</script>';
    } else {
        echo '<script>alert("Failed to send email. Complaint submitted, but email delivery failed.");</script>';
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... (Get form data) ...

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Enable verbose debug output
        $mail->isSMTP(); // Send using SMTP
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'your_gmail_email@gmail.com'; // SMTP username
        $mail->Password = 'your_gmail_password'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('your_gmail_email@gmail.com', 'Your Name');
        $mail->addAddress('sujanimrajapaksha@gmail.com', 'Recipient Name'); // Add a recipient

        //Content
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = 'New Complaint Submission';
        $mail->Body = "Full Name: $name\nContact Number: $contactNumber\nCategory: $category\nMessage: $message";

        $mail->send();
        echo '<script>alert("Complaint submitted successfully. An email has been sent.");</script>';
    } catch (Exception $e) {
        echo '<script>alert("Failed to send email. Mailer Error: {$mail->ErrorInfo}");</script>';
    }
}
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

<a href="?logout=true" class="logout-btn">Logout</a>

<div class="flex">
    <div class="flex-grow p-6">
        <div class="flex flex-col items-center py-3 mb-5">
            <h1 class="text-3xl font-bold text-green-600">Submit a Complaint</h1>
        </div>
        <div class="flex items-center justify-center">
            <form method="POST" class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg">
                <h3 class="text-xl font-semibold mb-4 text-green-600">Complaint Details</h3>

                <div class="mb-4">
                    <label for="name" class="block mb-2 text-green-700 font-medium">Full Name</label>
                    <input type="text" name="name" id="name" required class="w-full p-2 border border-gray-300 rounded-lg">
                </div>

                <div class="mb-4">
                    <label for="email" class="block mb-2 text-green-700 font-medium">Contact Number</label>
                    <input type="text" name="email" id="email" required class="w-full p-2 border border-gray-300 rounded-lg" oninput="validatePhoneNumber(this)">
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
        const phoneRegex12 = /^\+94\d{9}$/;
        const phoneRegex10 = /^0\d{9}$/;

        if (phoneNumber.length === 12) {
            if (!phoneRegex12.test(phoneNumber)) {
                errorElement.textContent = "Phone number must start with +94 and have 12 digits.";
                input.setCustomValidity("Invalid phone number");
            } else {
                errorElement.textContent = "";
                input.setCustomValidity("");
            }
        } else if (phoneNumber.length === 10) {
            if (!phoneRegex10.test(phoneNumber)) {
                errorElement.textContent = "Phone number must start with 0 and have 10 digits.";
                input.setCustomValidity("Invalid phone number");
            } else {
                errorElement.textContent = "";
                input.setCustomValidity("");
            }
        } else if (phoneNumber.length > 0){
            errorElement.textContent = "Phone number must be 10 or 12 digits.";
            input.setCustomValidity("Invalid phone number");
        } else {
            errorElement.textContent = "";
            input.setCustomValidity("");
        }
    }
</script>

</body>
</html>