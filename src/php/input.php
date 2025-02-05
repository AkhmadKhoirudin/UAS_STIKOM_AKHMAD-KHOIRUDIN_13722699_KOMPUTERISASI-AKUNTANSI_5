<?php
$servername = "localhost"; // Ganti dengan server database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "store_db"; // Ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Upload image dengan nama dan folder yang benar
    $image = $_FILES['image']['name'];
    $target_dir = "../img/prodak/"; // Folder tujuan
    $target_file = $target_dir . basename($image); // Nama file yang ditentukan

    // Pastikan folder images ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Periksa apakah file sudah berhasil dipindahkan
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Simpan path gambar yang benar ke dalam database (src/img/prodak/nama_file)
        $image_path = "src/img/prodak/" . basename($image); 

        // Insert data ke database
        $sql = "INSERT INTO products (name, description, price, image) 
                VALUES ('$name', '$description', '$price', '$image_path')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Tutup koneksi
$conn->close();
?>
