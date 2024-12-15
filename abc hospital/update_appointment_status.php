<?php
session_start();
if (!isset($_SESSION['receptionist'])) {
    header("Location: receptionist-login.html");
    exit();
}

// Include database connection
include('db_connection.php');

// Initialize variables for message and color
$message = '';
$messageColor = '';

if (isset($_GET['appointment_id']) && isset($_GET['status'])) {
    $appointment_id = $_GET['appointment_id'];
    $status = $_GET['status'];

    // Validate status
    if ($status == 'confirmed' || $status == 'rejected') {
        // Update the status of the appointment
        $sql = "UPDATE appointment SET status = ? WHERE appointment_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $appointment_id);

        if ($stmt->execute()) {
            // Set success message based on status
            if ($status == 'confirmed') {
                $message = "Appointment confirmed successfully!";
                $messageColor = "green"; // Color for confirmed message
            } else {
                $message = "Appointment rejected successfully!";
                $messageColor = "red"; // Color for rejected message
            }
        } else {
            $message = "Error updating appointment status: " . $stmt->error;
            $messageColor = "orange"; // Color for error message
        }
    } else {
        $message = "Invalid status.";
        $messageColor = "orange"; // Color for invalid status message
    }
} else {
    $message = "Appointment ID or status not set.";
    $messageColor = "orange"; // Color for missing parameters message
}

// Close statements and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Appointment Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .message {
            padding: 10px;
            margin: 20px 0;
            border-radius: 5px;
            color: white;
        }
        .back-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if ($message): ?>
        <div class="message" style="background-color: <?php echo $messageColor; ?>;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <button class="back-btn" onclick="window.history.back();">Back</button>
</div>

</body>
</html>
