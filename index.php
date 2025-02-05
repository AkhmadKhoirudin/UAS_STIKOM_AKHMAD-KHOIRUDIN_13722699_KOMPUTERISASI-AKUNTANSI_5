
<?php
// Memulai session
session_start();

// Pastikan tidak ada output sebelum kode ini (termasuk spasi kosong atau HTML sebelum <?php)
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.html"); 
} else {
    header("Location: index.html");  
}
?>
