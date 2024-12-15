<?php
session_start();
include('db_connection.php'); // Ensure this file contains your database connection logic

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to fetch user data
    $sql = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        
        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin'] = $user['name']; // Store email in session
            header("Location: admin-dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            echo "Invalid email or password."; // Invalid password
        }
    } else {
        echo "Invalid email or password."; // Invalid email
    }
}
?>
