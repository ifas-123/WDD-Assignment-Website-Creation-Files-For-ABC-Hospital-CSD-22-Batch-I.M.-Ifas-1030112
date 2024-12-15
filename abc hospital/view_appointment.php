<?php
// Include database connection
include('db_connection.php');

// Check if the reference number is submitted
if (isset($_POST['reference_number'])) {
    $reference_number = $_POST['reference_number'];

    // Query to fetch appointment details based on reference number
    $sql = "SELECT * FROM appointment WHERE reference_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $reference_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $appointment = $result->fetch_assoc();
    } else {
        $appointment = null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointment</title>
    <link rel="stylesheet" href="view_appointment.css">
</head>
<body>
    <h2>Enter Your Reference Number</h2>
    <form method="POST" action="view_appointment.php">
        <input type="text" name="reference_number" placeholder="Enter Reference Number" required>
        <button type="submit">Submit</button>
    </form>

    <?php if (isset($appointment)): ?>
        <div class="appointment-details">
            <p><strong>Patient Name:</strong> <?php echo $appointment['patient_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $appointment['email']; ?></p>
            <p><strong>Contact Number:</strong> <?php echo $appointment['contact_no']; ?></p>
            <p><strong>Specialization:</strong> <?php echo $appointment['specialization']; ?></p>
            <p><strong>Doctor:</strong> <?php echo $appointment['doctor_name']; ?></p>
            <p><strong>Availability Time:</strong> <?php echo $appointment['avilability_time']; ?></p>
            <p><strong>Reason:</strong> <?php echo $appointment['reason']; ?></p>
            <p><strong>Status:</strong> <?php echo $appointment['status']; ?></p>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No appointment found with this reference number.</p>
    <?php endif; ?>

    <div>
        <a href="book_an_appointment.html" class="btn">Book Another Appointment</a>
    </div>
</body>
</html>
