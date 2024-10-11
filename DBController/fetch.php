<?php
// Database connection details
$host = 'localhost';  // Your database host
$username = '[]';  // Your MySQL username
$password = '[]';  // Your MySQL password
$dbname = '[]';  // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve parameters from URL
$userName = isset($_GET['userName']) ? $_GET['userName'] : '';
$userPassword = isset($_GET['password']) ? $_GET['password'] : '';

// Validate input
if (empty($userName) || empty($userPassword)) {
    echo json_encode(["message" => "No valid data provided"]);
    exit();
}

// Prepare SQL statement to fetch user data
$stmt = $conn->prepare("SELECT user, userName, password FROM mealPlanner WHERE userName = ? AND password = ?");
$stmt->bind_param("ss", $userName, $userPassword);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
    echo json_encode($userData);
} else {
    echo json_encode(["message" => "User not found"]);
}

// Close connection
$stmt->close();
$conn->close();
?>
