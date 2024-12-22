<?php
header('Content-Type: application/json');

// Veritabanı bağlantı dosyasını dahil et
require_once 'baglantı.php';

// POST isteğini kontrol et
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // JSON verisini al
    $input = file_get_contents('php://input');
    $data = json_decode($input, true); // Gelen JSON'u diziye çevir

    // Sepet verilerini kontrol et
    if (isset($data['sepet']) && is_array($data['sepet']) && !empty($data['sepet'])) {
        $sepet = $data['sepet'];

        // Veritabanına ekleme işlemi
        $urunler = [];
        foreach ($sepet as $urun) {
            $urunAdi = mysqli_real_escape_string($conn, trim($urun['name'] ?? 'Bilinmiyor'));
            $urunFiyat = mysqli_real_escape_string($conn, $urun['price'] ?? 0);
            $urunAdet = mysqli_real_escape_string($conn, $urun['quantity'] ?? 0);

            // Ürün bilgilerini veritabanına ekleyelim
            $sql = "INSERT INTO sipariş (urun_adi, urun_fiyat, urun_adet) VALUES ('$urunAdi', '$urunFiyat', '$urunAdet')";
            
            if (mysqli_query($conn, $sql)) {
                // Başarılı ekleme
                $urunler[] = [
                    'name' => $urunAdi,
                    'price' => $urunFiyat,
                    'quantity' => $urunAdet
                ];
            } else {
                // Hata durumu
                echo json_encode([
                    "success" => false,
                    "message" => "Veritabanına veri eklenirken hata oluştu: " . mysqli_error($conn)
                ]);
                exit;
            }
        }

        // JSON formatında başarı mesajı gönder
        echo json_encode([
            "success" => true,
            "message" => "Sepet verisi başarıyla işlendi ve veritabanına kaydedildi.",
            "urunler" => $urunler
        ]);
    } else {
        // Sepet verisi eksikse hata mesajı döndür
        echo json_encode([
            "success" => false,
            "message" => "Sepet verisi eksik veya hatalı."
        ]);
    }
} else {
    // Yanlış istek türü
    echo json_encode([
        "success" => false,
        "message" => "Geçersiz istek türü. POST bekleniyor."
    ]);
}

// Veritabanı bağlantısını kapat
mysqli_close($conn);
?>
