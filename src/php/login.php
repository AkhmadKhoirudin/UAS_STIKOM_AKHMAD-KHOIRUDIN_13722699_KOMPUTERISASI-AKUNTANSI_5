<?php
header('Content-Type: application/json');

// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_db"; 

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Koneksi ke database gagal."]));
}

// Tangani request POST untuk login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        echo json_encode(["success" => false, "error" => "Username dan password wajib diisi."]);
        exit;
    }

    // Query untuk mendapatkan data pengguna berdasarkan username
    $stmt = $conn->prepare("SELECT id, username, password, status FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['status'] = $user['status']; // Tambahkan status ke session
    
            echo json_encode([
                "success" => true,
                "message" => "Login berhasil!",
                "username" => $user['username'],
                "userId" => $user['id'],
                "status" => $user['status'], // Kirim status ke frontend
            ]);
        } else {
            echo json_encode(["success" => false, "error" => "Password salah."]);
        }
    }
    
    

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "error" => "Metode request tidak valid."]);
}
?>
