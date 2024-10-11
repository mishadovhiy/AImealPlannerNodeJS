<?php
// Database credentials
$servername = "localhost";  
$username = "[]";
$password = "[]";
$dbname = "[]";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch parameters from URL (GET request)
$userName = isset($_GET['userName']) ? $_GET['userName'] : '';
$userPassword = isset($_GET['password']) ? $_GET['password'] : '';

if (empty($userName) || empty($userPassword)) {
    echo json_encode([
        "message" => "Username and password are required."
    ]);
    exit;
}

// Prepare SQL query to match both username and password
$sql = "SELECT * FROM mealPlanner WHERE userName = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $userName, $userPassword); // binding the userName and userPassword
$stmt->execute();
$stmt->store_result();

// Check if the user exists
if ($stmt->num_rows > 0) {
    // User exists, proceed to delete
    $deleteSql = "DELETE FROM mealPlanner WHERE userName = ? AND password = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("ss", $userName, $userPassword);

    if ($deleteStmt->execute()) {
        echo json_encode([
            "message" => "User deleted successfully."
        ]);
    } else {
        echo json_encode([
            "message" => "Error deleting user."
        ]);
    }
} else {
    // User not found or password incorrect
    echo json_encode([
        "message" => "Username or password is incorrect."
    ]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
