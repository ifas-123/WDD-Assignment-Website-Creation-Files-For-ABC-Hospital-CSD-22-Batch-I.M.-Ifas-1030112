<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL query to fetch the doctor's record
    $sql = "SELECT * FROM doctor WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the doctor's record
        $doctor = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $doctor['password'])) {
            $_SESSION['doctor'] = $doctor['name']; // Store doctor's name in session
            header("Location: doctor-dashboard.php");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }
}
?>
