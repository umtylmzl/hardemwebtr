<?php

include "baglantı.php";

// Formdan gelen verileri kontrol et
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Formdan gelen verileri al ve boşlukları temizle
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $konu = trim($_POST['konu']);
    $mesaj = trim($_POST['mesaj']);

    // Boş alan kontrolü
    if (empty($name) || empty($email) || empty($konu) || empty($mesaj)) {
        echo "Lütfen tüm alanları doldurunuz.";
        header("refresh:3;url=iletisim.html");
        exit;
    }

    // Hazırlanmış ifade (Prepared Statement) kullanımı
    $stmt = mysqli_prepare($conn, "INSERT INTO iletisim (ad, email, konu, mesaj) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        // Parametreleri bağla
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $konu, $mesaj);

        // Sorguyu çalıştır
        if (mysqli_stmt_execute($stmt)) {
            echo "Mesajınız başarıyla gönderildi.";
            header("refresh:3;url=iletisim.html");
        } else {
            echo "Bir hata oluştu: " . mysqli_error($conn);
            header("refresh:3;url=iletisim.html");
        }

        // Hazırlanmış ifadeyi kapat
        mysqli_stmt_close($stmt);
    } else {
        echo "Sorgu hazırlanırken bir hata oluştu: " . mysqli_error($conn);
        header("refresh:3;url=iletisim.html");
    }
} else {
    echo "Form düzgün gönderilmedi.";
    header("refresh:3;url=iletisim.html");
}

// Bağlantıyı kapat
mysqli_close($conn);
?>
