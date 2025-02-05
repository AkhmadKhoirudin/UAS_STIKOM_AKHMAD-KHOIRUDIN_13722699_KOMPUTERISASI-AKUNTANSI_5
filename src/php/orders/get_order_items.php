<?php
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_db";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit();
}

// Validate input
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid order_id parameter."]);
    exit();
}

$order_id = intval($_GET['order_id']);

// Query to fetch order details
$sql = "SELECT product_name, quantity, price FROM order_items WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

// Return response
if (empty($items)) {
    echo json_encode(["status" => "error", "message" => "No items found for the given order ID."]);
} else {
    echo json_encode(["status" => "success", "items" => $items]);
}

// Close connections
$stmt->close();
$conn->close();
?>
