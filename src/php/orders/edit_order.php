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
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$payment_method = $_POST['payment_method'];
$shipping_method = $_POST['shipping_method'];

// Query untuk memperbarui data order
$sql = "UPDATE orders 
        SET name = '$name', address = '$address', phone = '$phone', email = '$email', 
            payment_method = '$payment_method', shipping_method = '$shipping_method' 
        WHERE id = $order_id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Order berhasil diperbarui."]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal memperbarui order."]);
}

$conn->close();
?>
