<?php
// Include database connection
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $patient_name = $_POST['patient_name'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $specialization = $_POST['specialization'];
    $doctor_name = $_POST['doctor_name'];
    $availability_time = $_POST['availability_time'];
    $reason = $_POST['reason'];

    // Generate a unique reference number
    $reference_number = 'REF-' . uniqid();

    // Insert the appointment into the database
    $sql = "INSERT INTO appointment (reference_number, patient_name, email, contact_no, specialization, doctor_name, avilability_time, reason) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $reference_number, $patient_name, $email, $contact_no, $specialization, $doctor_name, $availability_time, $reason);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to appointment success page with reference number
        header("Location: appointment_success.php?reference_number=" . $reference_number);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
