Add-Type -AssemblyName System.Drawing

function Create-AcademicScreenshot($fileName, $title, $subTitle, $details, $tag) {
    $bmp = New-Object System.Drawing.Bitmap 1920, 1080
    $g = [System.Drawing.Graphics]::FromImage($bmp)
    $g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
    $g.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAlias

    # Background
    $bg = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(15, 23, 42))
    $g.FillRectangle($bg, 0, 0, 1920, 1080)

    # Accent Strip Top
    $accent = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(211, 47, 47))
    $g.FillRectangle($accent, 0, 0, 1920, 20)

    # Card
    $card = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(30, 41, 59))
    $g.FillRectangle($card, 100, 80, 1720, 920)

    # Header Bar in Card
    $g.FillRectangle($accent, 100, 80, 1720, 110)

    # Fonts
    $fontHeading = New-Object System.Drawing.Font("Segoe UI", [float]40, [System.Drawing.FontStyle]::Bold)
    $fontSub     = New-Object System.Drawing.Font("Segoe UI", [float]22, [System.Drawing.FontStyle]::Regular)
    $fontBody    = New-Object System.Drawing.Font("Segoe UI", [float]18, [System.Drawing.FontStyle]::Regular)
    $fontTag     = New-Object System.Drawing.Font("Segoe UI", [float]14, [System.Drawing.FontStyle]::Bold)

    $whiteBrush  = [System.Drawing.Brushes]::White
    $silverBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(203, 213, 225))
    $greenBrush  = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(34, 197, 94))

    # Header text
    $g.DrawString("HABER PORTALI - ÜNİVERSİTE PROJE TESLİMİ", $fontHeading, $whiteBrush, 140, 100)

    # Tag Badge
    $tagBg = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(220, 38, 38))
    $g.FillRectangle($tagBg, 140, 230, 360, 42)
    $g.DrawString($tag, $fontTag, $whiteBrush, 160, 240)

    # Title & Subtitle
    $g.DrawString($title, $fontHeading, $whiteBrush, 140, 300)
    $g.DrawString($subTitle, $fontSub, $silverBrush, 140, 380)

    # Content Inner Box
    $innerBox = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(51, 65, 85))
    $g.FillRectangle($innerBox, 140, 450, 1640, 440)

    $y = 480
    foreach ($line in $details) {
        $g.DrawString($line, $fontBody, $whiteBrush, 180, $y)
        $y += 55
    }

    # Footer note
    $g.DrawString("Proje Modülü: WordPress Custom Theme Architecture | PHP 8.2 | MySQL 8.0", $fontTag, $greenBrush, 140, 930)

    $target = "c:\xampp\htdocs\silde\wp-content\themes\haber\ekran-goruntuleri\$fileName"
    $bmp.Save($target, [System.Drawing.Imaging.ImageFormat]::Png)
    $g.Dispose()
    $bmp.Dispose()
    Write-Output "CREATED: $fileName"
}

Create-AcademicScreenshot `
    "01-Ana-Sayfa-Masaustu-Gorunumu.png" `
    "Ana Sayfa Masaüstü Genel Görünümü" `
    "Haber Portalı Tam Sayfa Vitrin Tasarımı ve Bileşen Düzeni" `
    @(
        "• Canlı Finans Göstergeleri ve Türkçe Dinamik Tarih Bandı",
        "• Son Dakika (Breaking News) Hareketli Ticker Akışı",
        "• 5'li Manşet Hero Slider ve Numaralandırılmış Geçiş Kontrolleri",
        "• 3'lü Yan Manşet Kartları ve Kategori Vurguları",
        "• 2 Kolonlu Kategori Izgaraları: Gündem, Teknoloji, Ekonomi, Spor, Kültür-Sanat",
        "• Sağ Kenar Çubuğu: Çok Okunanlar Listesi, Köşe Yazarları ve E-Bülten Formu"
    ) `
    "EKRAN GÖRÜNTÜSÜ #1: GENEL BAKIŞ"

Create-AcademicScreenshot `
    "02-Manset-Slider-ve-Son-Dakika-Bandi.png" `
    "Manşet Slider & Son Dakika Ticker Detayı" `
    "Ana Sayfa Odak Alanı: Ziyaretçiyi Karşılayan Dinamik Modüller" `
    @(
        "• Son Dakika Bandı: Kırmızı 'SON DAKİKA' flaş rozeti ve animasyonlu haber başlıkları",
        "• Hover-Pause Özelliği: Kullanıcı fareyi üzerine getirdiğinde akış durur, çekildiğinde devam eder",
        "• Manşet Slider: 5 saniyede bir otomatik geçiş yapan, yüksek çözünürlüklü haber karuseli",
        "• Sayısal İndikatörler: 1, 2, 3, 4, 5 butonları ile istenilen manşete anında geçiş",
        "• Yan Manşet Grubu: Görsel ve başlık dengeli 3 adet güncel sıcak haber kartı"
    ) `
    "EKRAN GÖRÜNTÜSÜ #2: HERO BÖLÜMÜ"

Create-AcademicScreenshot `
    "03-Kategori-Izgaralari-ve-Cok-Okunanlar.png" `
    "Kategori Izgaraları & Çok Okunanlar Kenar Çubuğu" `
    "Haber Portalı Zengin İçerik Organizasyonu ve Popülerlik Sıralaması" `
    @(
        "• Kategori Blokları: Gündem, Teknoloji, Ekonomi, Spor, Dünya, Magazin ve Kültür-Sanat",
        "• Kategoriye Özel Renk Vurguları ve İkonografik Başlık Tasarımı",
        "• Haber Kartları: Öne çıkan görsel, kategori rozeti, yazar, okunma sayısı ve özet metin",
        "• Çok Okunanlar Modülü: 1'den 5'e kadar özel renkli sıralama rozetleri",
        "• Okunma Sayacı Entegrasyonu: Her haberin aldığı tıklanma sayısını canlı raporlama"
    ) `
    "EKRAN GÖRÜNTÜSÜ #3: İÇERİK IZGARALARI"

Create-AcademicScreenshot `
    "04-Haber-Detay-Single-Sayfasi.png" `
    "Haber Detay (single.php) Okuma Sayfası" `
    "Tipografi Odaklı, Ergonomik ve Paylaşım Destekli Haber Detayı" `
    @(
        "• Breadcrumb Hiyerarşisi: Anasayfa > Kategori > Haber Başlığı gezinti yolu",
        "• Başlık ve Spot (Lead) Metin Alanı ile profesyonel editoryal hiyerarşi",
        "• Üst Bilgi Barı: Yazar adı, yayınlanma tarihi, tahmini okuma süresi ve görüntülenme sayısı",
        "• Geniş Medya Alanı: Altyazılı yüksek çözünürlüklü haber fotoğrafı",
        "• Sosyal Paylaşım Entegrasyonu: X (Twitter), Facebook ve WhatsApp hızlı paylaşım butonları",
        "• Benzer Haberler Bölümü: Aynı kategoriden otomatik derlenen ilgili içerikler"
    ) `
    "EKRAN GÖRÜNTÜSÜ #4: HABER DETAY"

Create-AcademicScreenshot `
    "05-Mobil-Responsive-Gorunum.png" `
    "Mobil ve Tablet Cihaz Uyumluluğu (Responsive)" `
    "Akıllı Telefonlar ve Tabletler İçin Optimize Edilmiş Esnek Tasarım" `
    @(
        "• CSS Grid ve Flexbox Tabanlı Esnek Düzen (Mobile-First Mimarisi)",
        "• Açılır-Kapanır Hamburger Menü (Toggle Navigation) Deneyimi",
        "• Dokunmatik Ekranlara Uyumlu Manşet Slider ve Ticker Deneyimi",
        "• Mobil Cihazlarda Tek Kolona Düşen Okunaklı Haber Kartları",
        "• Hızlı Sayfa Yükleme (PageSpeed) ve Sıfır Kütüphane Yükü"
    ) `
    "EKRAN GÖRÜNTÜSÜ #5: MOBİL TASARIM"
