<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.html");
    exit();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable MySQL error reporting

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_doctor'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $speciality = $_POST['speciality'];

         // Hash the password before storing it
         $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO doctor (name, email, password, contact_no, gender, specialization) VALUES (?, ?, ?, ?, ?, ?)";
        if (!$stmt = $conn->prepare($sql)) {
            die("SQL Error: " . $conn->error);
        }
        $stmt->bind_param("ssssss", $name, $email, $password, $phone, $gender, $speciality);
        $stmt->execute();
    }

    if (isset($_POST['add_receptionist'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];

         // Hash the password before storing it
         $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO receptionist (name, email, password, contact_no, gender) VALUES (?, ?, ?, ?, ?)";
        if (!$stmt = $conn->prepare($sql)) {
            die("SQL Error: " . $conn->error);
        }
        $stmt->bind_param("sssss", $name, $email, $password, $phone, $gender);
        $stmt->execute();
    }

    if (isset($_POST['remove_doctor'])) {
        $doctor_id = $_POST['doctor_id'];
        $sql = "DELETE FROM doctor WHERE doctor_id = ?";
        if (!$stmt = $conn->prepare($sql)) {
            die("SQL Error: " . $conn->error);
        }
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
    }

    if (isset($_POST['remove_receptionist'])) {
        $receptionist_id = $_POST['receptionist_id'];
        $sql = "DELETE FROM receptionist WHERE receptionist_id = ?";
        if (!$stmt = $conn->prepare($sql)) {
            die("SQL Error: " . $conn->error);
        }
        $stmt->bind_param("i", $receptionist_id);
        $stmt->execute();
    }
}

// Fetch data for display
$doctors = $conn->query("SELECT * FROM doctor");
$receptionists = $conn->query("SELECT * FROM receptionist");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" type="text/css" href="admin_dashboard.css" />

</head>
<body>
    <h1>Admin Dashboard</h1>
    <a href="logout.php" class="logout-btn">Logout</a>
    <p>Welcome, <?php echo $_SESSION['admin']; ?>!</p>

    <h2>Add Doctor</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Phone Number:</label>
        <input type="text" name="phone" required><br>
        <label>Gender:</label>
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br>
        <label>Speciality:</label>
        <select name="speciality" id="speciality" required>
        <option value="" disabled selected>Select your option</option> <!-- Default placeholder -->
        <option value="Cardiologist">Cardiologist</option>
        <option value="Neurologist">Neurologist</option>
        <option value="Pediatrician">Pediatrician</option>
        <option value="Dermatologist">Dermatologist</option>
        <option value="Orthopedic Surgeon">Orthopedic Surgeon</option>
        <option value="Gastroenterologist">Gastroenterologist</option>
        <option value="Oncologist">Oncologist</option>
        <option value="Psychiatrist">Psychiatrist</option>
        <option value="Obstetrician/Gynecologist(OB/GYN)">Obstetrician/Gynecologist(OB/GYN)</option>
        <option value="Endocrinologist">Endocrinologist</option>
    </select><br>
        <button type="submit" name="add_doctor">Add Doctor</button>
    </form>

    <h2>Add Receptionist</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Phone Number:</label>
        <input type="text" name="phone" required><br>
        <label>Gender:</label>
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br>
        <button type="submit" name="add_receptionist">Add Receptionist</button>
    </form>

    <h2>Manage Doctors</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Speciality</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $doctors->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['doctor_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['contact_no']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td><?php echo $row['specialization']; ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="doctor_id" value="<?php echo $row['doctor_id']; ?>">
                    <button type="submit" name="remove_doctor" class="remove-button">Remove</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Manage Receptionists</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $receptionists->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['receptionist_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['contact_no']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="receptionist_id" value="<?php echo $row['receptionist_id']; ?>">
                    <button type="submit" name="remove_receptionist" class="remove-button">Remove</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>