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
$newUserName = isset($_GET['newUserName']) ? $_GET['newUserName'] : '';
$newPassword = isset($_GET['newPassword']) ? $_GET['newPassword'] : '';
$user = isset($_GET['user']) ? $_GET['user'] : '';

// Validate input
if (empty($userName) || empty($userPassword)) {
    echo json_encode(["message" => "No valid data provided for update"]);
    exit();
}

// Prepare the SQL statement to update user data
$sql = "UPDATE mealPlanner SET ";
$updates = [];
$params = [];

// Check for updates
if (!empty($newUserName)) {
    $updates[] = "userName = ?";
    $params[] = $newUserName;
}
if (!empty($newPassword)) {
    $updates[] = "password = ?";
    $params[] = $newPassword;
}
if (!empty($user)) {
    $updates[] = "user = ?";
    $params[] = $user;
}

// Add the WHERE clause
$sql .= implode(", ", $updates) . " WHERE userName = ? AND password = ?";
$params[] = $userName;
$params[] = $userPassword;

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
if ($stmt->execute()) {
    echo json_encode(["message" => "User updated successfully"]);
} else {
    echo json_encode(["message" => "Error updating user: " . $conn->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
