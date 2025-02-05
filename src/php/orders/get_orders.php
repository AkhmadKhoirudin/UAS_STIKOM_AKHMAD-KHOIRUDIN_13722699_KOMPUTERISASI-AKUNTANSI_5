<?php
header('Content-Type: application/json');

// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Koneksi ke database gagal: " . $conn->connect_error]);
    exit();
}

// Query untuk mendapatkan data order
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($sql);

$orders = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Mengambil ID order
        $order_id = $row['id'];

        // Query untuk mendapatkan item dari setiap order
        $items_sql = "SELECT * FROM order_items WHERE order_id = ?";
        $stmt = $conn->prepare($items_sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $items_result = $stmt->get_result();

        $items = [];
        if ($items_result && $items_result->num_rows > 0) {
            while ($item_row = $items_result->fetch_assoc()) {
                $items[] = $item_row;
            }
        }
        $stmt->close();

        // Menambahkan item ke data order
        $row['items'] = $items;
        $orders[] = $row;
    }
    echo json_encode(["status" => "success", "orders" => $orders]);
} else {
    echo json_encode(["status" => "success", "orders" => [], "message" => "Tidak ada data order ditemukan."]);
}

// Menutup koneksi
$conn->close();
?>
