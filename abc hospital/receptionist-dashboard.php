<?php
session_start();
if (!isset($_SESSION['receptionist'])) {
    header("Location: receptionist-login.html");
    exit();
}

// Include database connection
include('db_connection.php');

// Fetch all appointments with pending status
$sql = "SELECT * FROM appointment WHERE status = 'pending'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist Dashboard</title>
    <link rel="stylesheet" type="text/css" href="receptionist_dashboard.css" />

</head>
<body>
<a href="logout.php" class="logout-btn">Logout</a>
    <h1>Receptionist Dashboard</h1>
<div class="container">

    <p>Hello, <?php echo $_SESSION['receptionist']; ?>!</p>

    <h2>Pending Appointments</h2>
    <table>
        <thead>
            <tr>
                <th>Reference Number</th>
                <th>Patient Name</th>
                <th>Email</th>
                <th>Specialization</th>
                <th>Doctor</th>
                <th>Availability Time</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
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
                    echo "<td>" . htmlspecialchars($appointment['specialization']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['doctor_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['avilability_time']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['reason']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['status']) . "</td>";
                    echo "<td>
                        <div class='button-container'>
                            <a href='update_appointment_status.php?appointment_id=" . htmlspecialchars($appointment['appointment_id']) . "&status=confirmed' class='btn'>Confirm</a>
                            <a href='update_appointment_status.php?appointment_id=" . htmlspecialchars($appointment['appointment_id']) . "&status=rejected' class='btn btn-reject'>Reject</a>
                        </div>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No pending appointments.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</div>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
