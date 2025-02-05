<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM products WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        echo json_encode($result->fetch_assoc());
    }
    $conn->close();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $image = $_FILES['image']['name'];
    $target_dir = "../img/prodak/"; // Folder untuk menyimpan gambar
    $target_file = $target_dir . basename($image);

    // Jika gambar diupload, pindahkan file ke folder tujuan
    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        // Simpan path relatif gambar dalam database
        $image_url = "src/img/prodak/" . basename($image);
        $sql = "UPDATE products SET name='$name', description='$description', price='$price', image='$image_url' WHERE id='$id'";
    } else {
        // Jika tidak ada gambar baru, tetap update data lainnya
        $sql = "UPDATE products SET name='$name', description='$description', price='$price' WHERE id='$id'";
    }

    // Eksekusi query update
    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman dashboard dengan pesan sukses
        header("Location:../../list.html?message=Record updated successfully");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
