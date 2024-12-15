<?php
session_start();
if (!isset($_SESSION['doctor'])) {
    header("Location: doctor-login.html");
    exit();
}

// Include database connection
include('db_connection.php');

// Fetch all confirmed appointments for the logged-in doctor
$doctor_name = $_SESSION['doctor']; // Assuming this is how you store the doctor's name

// Prepare SQL query to fetch confirmed appointments
$sql = "SELECT * FROM appointment WHERE doctor_name = ? AND status = 'confirmed'";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("s", $doctor_name);

// Execute the query and check for errors
if (!$stmt->execute()) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" type="text/css" href="doctor_dashboard.css" />
</head>
<body>

    <h1>Doctor Dashboard</h1>
    <p>Hello, <?php echo htmlspecialchars($doctor_name); ?>!</p>
    
    <h2>Confirmed Appointments</h2>
    <table>
        <thead>
            <tr>
                <th>Reference Number</th>
                <th>Patient Name</th>
                <th>Email</th>
                <th>Contact No</th>
                <th>Specialization</th>
                <th>Availability Time</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($appointment = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($appointment['reference_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['patient_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['contact_no']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['specialization']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['avilability_time']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['reason']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['status']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No confirmed appointments.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="logout.php" class="logout-btn">Logout</a>

</body>
</html>

<?php
// Close database connection
$stmt->close();
$conn->close();
?>
