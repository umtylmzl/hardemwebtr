<?php

include "baglantı.php";

// Formdan gelen verileri kontrol et
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Formdan gelen verileri al ve boşlukları temizle
    $email = trim($_POST['email']);

    // Boş alan kontrolü
    if (empty($email)) {
        echo "Lütfen tüm alanları doldurunuz.";
        header("refresh:3;url=iletisim.html");
        exit;
    }

    // Hazırlanmış ifade (Prepared Statement) kullanımı
    $stmt = mysqli_prepare($conn, "INSERT INTO bülten (email) VALUES (?)");
    if ($stmt) {
        // Parametreleri bağla
        mysqli_stmt_bind_param($stmt, "s", $email);

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
