Add-Type -AssemblyName System.Drawing

$bmp = New-Object System.Drawing.Bitmap 1200, 900
$g = [System.Drawing.Graphics]::FromImage($bmp)
$g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
$g.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAlias

# Arka Plan
$bgBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(15, 23, 42))
$g.FillRectangle($bgBrush, 0, 0, 1200, 900)

# Kırmızı Üst Çizgi
$accentBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(211, 47, 47))
$g.FillRectangle($accentBrush, 0, 0, 1200, 16)

# Kart Gövdesi
$cardBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(30, 41, 59))
$g.FillRectangle($cardBrush, 60, 60, 1080, 780)

# Kart Başlığı
$g.FillRectangle($accentBrush, 60, 60, 1080, 100)

# Yazı Tipleri
$fontTitle = New-Object System.Drawing.Font("Segoe UI", [float]36, [System.Drawing.FontStyle]::Bold)
$fontSub   = New-Object System.Drawing.Font("Segoe UI", [float]18, [System.Drawing.FontStyle]::Regular)
$fontDesc  = New-Object System.Drawing.Font("Segoe UI", [float]14, [System.Drawing.FontStyle]::Regular)
$fontBadge = New-Object System.Drawing.Font("Segoe UI", [float]11, [System.Drawing.FontStyle]::Bold)

$whiteBrush = [System.Drawing.Brushes]::White
$silverBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(203, 213, 225))

$g.DrawString("HABER PORTALI - WORDPRESS TEMASI", $fontTitle, $whiteBrush, 90, 80)
$g.DrawString("Üniversite Bitirme Projesi - Tam Kapsamlı Haber & Dergi Mimarisi", $fontSub, $whiteBrush, 90, 190)

# Son Dakika Bandı
$stripBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(254, 205, 211))
$g.FillRectangle($stripBrush, 90, 240, 1020, 46)
$breakingBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(225, 29, 72))
$g.FillRectangle($breakingBrush, 90, 240, 160, 46)
$g.DrawString("SON DAKİKA", $fontBadge, $whiteBrush, 115, 252)
$tickerTextBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(136, 19, 55))
$g.DrawString("Yüksek Hızlı Tren Hatlarında Yeni Dönem: Ankara-İzmir Test Sürüşleri Başlıyor...", $fontDesc, $tickerTextBrush, 270, 252)

# Manşet Slider Alanı
$sliderBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(51, 65, 85))
$g.FillRectangle($sliderBrush, 90, 310, 660, 380)
$g.DrawString("[ MANŞET HERO SLIDER ALANI ]", $fontSub, $silverBrush, 240, 470)
$g.DrawString("Gündem | Teknoloji | Ekonomi | Spor | Dünya | Magazin | Kültür-Sanat", $fontDesc, $silverBrush, 120, 520)

# Yan Manşetler
$g.FillRectangle($sliderBrush, 780, 310, 330, 110)
$g.DrawString("[ Yan Manşet 1: Teknoloji ]", $fontDesc, $silverBrush, 820, 350)

$g.FillRectangle($sliderBrush, 780, 440, 330, 110)
$g.DrawString("[ Yan Manşet 2: Ekonomi ]", $fontDesc, $silverBrush, 820, 480)

$g.FillRectangle($sliderBrush, 780, 570, 330, 120)
$g.DrawString("[ Yan Manşet 3: Spor ]", $fontDesc, $silverBrush, 820, 610)

# Rozet
$badgeBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(22, 163, 74))
$g.FillRectangle($badgeBrush, 90, 720, 500, 40)
$g.DrawString("AKADEMİK TESLİM İÇİN HAZIRLANMIŞTIR (FINAL SUBMISSION)", $fontBadge, $whiteBrush, 105, 730)

$outPath = "c:\xampp\htdocs\silde\wp-content\themes\haber\screenshot.png"
$bmp.Save($outPath, [System.Drawing.Imaging.ImageFormat]::Png)

$g.Dispose()
$bmp.Dispose()
Write-Output "SCREENSHOT_SUCCESS: $outPath"
