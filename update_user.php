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

// Get POST data
$userId = isset($_POST['userId']) ? intval($_POST['userId']) : 0;
$name = $_POST['nama'] ?? '';
$address = $_POST['alamat'] ?? '';
$phone = $_POST['no'] ?? '';
$email = $_POST['email'] ?? '';
$photo = $_FILES['foto']['name'] ?? null;

// Validate ID
if ($userId === 0) {
    echo json_encode(['error' => true, 'message' => 'Invalid user ID']);
    exit;
}

// Handle file upload if photo is provided
$photoPath = null;
if ($photo) {
    $targetDir = "uploads/";
    $photoPath = $targetDir . basename($photo);
    move_uploaded_file($_FILES['foto']['tmp_name'], $photoPath);
}

// Update user data
$sql = "UPDATE users SET nama = ?, alamat = ?, no = ?, email = ?, foto = COALESCE(?, foto) WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssi', $name, $address, $phone, $email, $photoPath, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
} else {
    echo json_encode(['error' => true, 'message' => 'Failed to update profile']);
}

// Close connections
$stmt->close();
$conn->close();
?>
