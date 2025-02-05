<?php
// Aktifkan penanganan kesalahan untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Koneksi ke database gagal: " . $conn->connect_error]);
    exit();
}

// Ambil data dari POST request
$name = $_POST['name'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';
$shipping_method = $_POST['shipping_method'] ?? '';
$cart = json_decode($_POST['cart'], true) ?? [];

// Debugging: Periksa data POST
error_log("Data POST: " . json_encode($_POST));

// Validasi input
if (empty($name) || empty($address) || empty($phone) || empty($email) || empty($payment_method) || empty($shipping_method)) {
    echo json_encode(["status" => "error", "message" => "Semua field harus diisi."]);
    exit();
}

// Validasi cart
if (empty($cart)) {
    echo json_encode(["status" => "error", "message" => "Keranjang belanja kosong."]);
    exit();
}

// Query untuk menyimpan pesanan
$sql = "INSERT INTO orders (name, address, phone, email, payment_method, shipping_method) 
        VALUES ('$name', '$address', '$phone', '$email', '$payment_method', '$shipping_method')";

if ($conn->query($sql) === TRUE) {
    $order_id = $conn->insert_id;

    // Inisialisasi array untuk menampung kesalahan
    $errors = [];
    
    // Menyimpan item ke tabel order_items
    foreach ($cart as $item) {
        $product_name = $conn->real_escape_string($item['name']);
        $quantity = (int)$item['quantity'];
        $price = (float)$item['price'];

        // Query untuk memasukkan item ke order_items
        $item_sql = "INSERT INTO order_items (order_id, product_name, quantity, price) 
                     VALUES ('$order_id', '$product_name', '$quantity', '$price')";

        if (!$conn->query($item_sql)) {
            // Log query yang gagal dan error MySQL
            error_log("Query Gagal: $item_sql");
            error_log("Error MySQL: " . $conn->error);
            
            // Simpan query yang gagal dan error MySQL ke dalam log kesalahan
            $errors[] = [
                "query" => $item_sql,
                "error" => $conn->error,
            ];
        }
    }

    // Mengecek jika ada error pada penyimpanan item
    if (empty($errors)) {
        echo json_encode(["status" => "success", "message" => "Pesanan berhasil disimpan."]);
    } else {
        // Mengirimkan pesan error dan query yang gagal
        echo json_encode([
            "status" => "error", 
            "message" => "Beberapa item gagal disimpan.", 
            "errors" => $errors
        ]);
    }
} else {
    // Jika query utama gagal, tampilkan error MySQL yang lebih jelas
    error_log("Query Gagal: $sql");
    error_log("Error MySQL: " . $conn->error);
    echo json_encode(["status" => "error", "message" => "Gagal menyimpan pesanan. Error MySQL: " . $conn->error]);
}

// Tutup koneksi
$conn->close();
?>
