<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'store_db';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


$query = "SELECT * FROM products";
$result = $conn->query($query);

$products = [];

while ($product = $result->fetch_assoc()) {
    $products[] = $product;
}

header('Content-Type: application/json');
echo json_encode($products);

$conn->close();
?>
