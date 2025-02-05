<?php
// db.php
$servername = "localhost"; // atau IP server MySQL
$username = "root"; // username MySQL
$password = ""; // password MySQL
$dbname = "store_db"; // nama database

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data
$sql = "SELECT id, nama, deskripsi, gambar FROM products"; // ganti dengan tabel dan kolom Anda
$result = $conn->query($sql);

// Menutup koneksi
$conn->close();
?>
