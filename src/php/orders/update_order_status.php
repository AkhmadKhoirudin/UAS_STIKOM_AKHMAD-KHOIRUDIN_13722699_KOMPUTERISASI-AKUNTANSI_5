<?php
header('Content-Type: application/json');

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Ambil data dari request
$order_id = $_POST['order_id'] ?? null;
$status = $_POST['status'] ?? null;

if (!$order_id || !$status) {
    echo json_encode(["status" => "error", "message" => "Invalid input."]);
    exit;
}

// Update status di tabel orders
$sql_update_order = "UPDATE orders SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql_update_order);
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Failed to prepare SQL statement."]);
    exit;
}

$stmt->bind_param("si", $status, $order_id);
if ($stmt->execute()) {
    // Simpan notifikasi di tabel notifications
    $user_id = 1; // Ganti sesuai user ID (bisa diambil dari session atau data order)
    $message = "Order ID $order_id diubah status menjadi $status.";
    $type = "status_update";
    $notif_status = "unread"; // Default status notifikasi
    $created_at = date('Y-m-d H:i:s');

    $sql_insert_notification = "INSERT INTO notifications (order_id, user_id, message, type, status, created_at) 
                                 VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_notif = $conn->prepare($sql_insert_notification);

    if ($stmt_notif) {
        $stmt_notif->bind_param("iissss", $order_id, $user_id, $message, $type, $notif_status, $created_at);
        if ($stmt_notif->execute()) {
            echo json_encode(["status" => "success", "message" => "Status updated and notification saved."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to save notification."]);
        }
        $stmt_notif->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to prepare notification statement."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update status."]);
}

$stmt->close();
$conn->close();
?>
