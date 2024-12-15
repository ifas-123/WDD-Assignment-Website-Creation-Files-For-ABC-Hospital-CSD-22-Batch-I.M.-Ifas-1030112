<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abc_hospital";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$specialization = $_GET['specialization'];

// Prepare and execute the query
$stmt = $conn->prepare("SELECT name FROM doctor WHERE specialization = ?");
$stmt->bind_param("s", $specialization);
$stmt->execute();
$result = $stmt->get_result();

$doctors = array();
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($doctors);

$stmt->close();
$conn->close();

function display_docs() {
    global $con;
    $query = "SELECT username, docFees FROM doctb"; // Adjust query to fetch necessary fields
    $result = mysqli_query($con, $query);

    $doctors = [];
    while ($row = mysqli_fetch_array($result)) {
        $doctors[] = [
            'username' => $row['username'],
            'docFees' => $row['docFees'],
            'spec' => $row['spec'] // Make sure spec is included in the result
        ];
    }
    
    return json_encode($doctors); // Return as JSON for use in JS
}

function display_specs() {
    global $con;
    $query = "SELECT DISTINCT spec FROM doctb"; // Adjust query if needed
    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($result)) {
        echo '<option value="' . $row['spec'] . '">' . $row['spec'] . '</option>';
    }
}

?>
