<?php
// Veritabanı bağlantı bilgileri
$servername = "localhost"; // Sunucu adı
$username = "root";        // Kullanıcı adı
$password = "";            // Şifre
$dbname = "hardem"; // Veritabanı adı

// MySQL bağlantısını oluşturma
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if (!$conn) {
    die("Bağlantı başarısız: " . mysqli_connect_error());
}

?>
