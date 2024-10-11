<?php
// Database connection parameters
$servername = "localhost"; // Replace with your server details
$username = "[]"; // Your MySQL username
$password = "[]"; // Your MySQL password
$dbname = "[]"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve parameters from URL
$user = isset($_GET['user']) ? $_GET['user'] : '';
$userName = isset($_GET['userName']) ? $_GET['userName'] : '';
$userPassword = isset($_GET['userPassword']) ? $_GET['userPassword'] : '';

// Prepare the SQL statement to insert a new user
$stmt = $conn->prepare("INSERT INTO mealPlanner (user, userName, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user, $userName, $userPassword);

// Execute the insertion
if ($stmt->execute()) {
    echo json_encode(["message" => "User added successfully"]);
} else {
    echo json_encode(["message" => "Error adding user: " . $conn->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
