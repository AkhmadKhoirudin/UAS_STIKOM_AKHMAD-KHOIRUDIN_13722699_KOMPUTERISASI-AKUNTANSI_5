<?php
// Database configuration
$host = 'localhost';
$user = 'root'; // Adjust username if not root
$password = ''; // Adjust password
$dbname = 'store_db';

// Connect to database
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => true, 'message' => 'Database connection failed']);
    exit;
}

// Get userId from request
$userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;

if ($userId === 0) {
    echo json_encode(['error' => true, 'message' => 'Invalid user ID']);
    exit;
}

// Fetch user data
$sql = "SELECT id, nama AS name, alamat AS address, no AS phone, email, foto AS photo FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode($user);
} else {
    echo json_encode(['error' => true, 'message' => 'User not found']);
}

// Close connections
$stmt->close();
$conn->close();
?>
