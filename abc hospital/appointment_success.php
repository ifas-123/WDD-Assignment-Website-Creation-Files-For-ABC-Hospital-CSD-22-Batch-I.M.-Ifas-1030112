<?php
// Get the reference number from the URL parameter
$reference_number = isset($_GET['reference_number']) ? $_GET['reference_number'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booked Successfully</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            text-align: center;
        }
        .success-message {
            margin-top: 50px;
            padding: 20px;
            background-color: #28a745;
            color: white;
            font-size: 24px;
            border-radius: 10px;
            animation: slideIn 1s ease-out;
        }
        .reference-number {
            font-weight: bold;
            font-size: 28px;
            color:rgb(0, 0, 0);
        }
        .btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .copy-icon {
            cursor: pointer;
            font-size: 20px;
            margin-left: 10px;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="success-message">
        <p>Your appointment has been successfully booked!</p>
        <p>Reference Number: <span class="reference-number" id="reference_number"><?php echo $reference_number; ?></span>
            <span class="copy-icon" onclick="copyReferenceNumber()">📋</span>
        </p>
    </div>

    <div>
        <a href="book_an_appointment.html" class="btn">Book Another Appointment</a>
        <a href="view_appointment.php" class="btn">View Appointment</a>
    </div>

    <script>
        function copyReferenceNumber() {
            // Get the reference number element
            var referenceNumber = document.getElementById("reference_number").textContent;

            // Create a temporary input element to copy the reference number
            var tempInput = document.createElement("input");
            tempInput.value = referenceNumber;
            document.body.appendChild(tempInput);

            // Select and copy the text
            tempInput.select();
            document.execCommand("copy");

            // Remove the temporary input
            document.body.removeChild(tempInput);

            // Notify the user that the reference number has been copied
            alert("Reference Number copied: " + referenceNumber);
        }
    </script>
</body>
</html>
