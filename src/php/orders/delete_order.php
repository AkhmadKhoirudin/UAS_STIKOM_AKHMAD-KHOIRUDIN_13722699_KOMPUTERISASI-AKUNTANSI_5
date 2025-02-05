<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Koneksi ke database gagal."]);
    exit();
}

$order_id = $_POST['order_id'];

// Hapus items terkait dengan order_id
$item_sql = "DELETE FROM order_items WHERE order_id = $order_id";
$conn->query($item_sql);

// Hapus order
$order_sql = "DELETE FROM orders WHERE id = $order_id";
if ($conn->query($order_sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Order berhasil dihapus."]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal menghapus order."]);
}

$conn->close();
?>
