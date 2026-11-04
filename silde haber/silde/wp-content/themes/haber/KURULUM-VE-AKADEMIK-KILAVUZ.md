# Haber Portalı - Üniversite Bitirme Projesi Teslim Kılavuzu

**Proje Adı:** Haber Portalı (Profesyonel Dinamik Türkçe Haber ve Medya Teması)  
**Platform:** WordPress 6.x / PHP 8.2+ / MySQL 8.0  
**Geliştirici Rolü:** Full-Stack Web Developer & WordPress Mimarisi  
**Tasarım Mimarisi:** Responsive, Mobile-First, Vanilla JS & CSS3 (Ek kütüphane bağımlılığı olmaksızın yüksek performans)  

---

## 1. Proje Genel Özeti ve Kapsamı
Bu proje; modern dijital gazetecilik standartlarına (Hürriyet, NTV, Habertürk, BBC Türkçe) uygun olarak geliştirilmiş, yüksek hızlı, arama motoru dostu (SEO uyumlu) ve tam duyarlı (responsive) bir **Türkçe Haber Portalı** web uygulamasıdır.

### Temel Fonksiyonel Modüller:
1. **Canlı Finans ve Tarih Bandı (Top Bar):** Türkçe tarih formatlayıcı, BIST 100, Dolar, Euro, Altın ve Hava Durumu göstergeleri.
2. **Son Dakika Bandı (Breaking News Ticker):** Flaş haber başlıklarını yatay kayan animasyonla gösteren, fare üzerine gelindiğinde duraklayan (hover-pause) dinamik ticker.
3. **Manşet Hero Slider:** 5 adet öne çıkan haberi 5 saniyede bir otomatik döndüren, numaralı butonlarla (1, 2, 3, 4, 5) manuel geçişe izin veren vitrin alanı.
4. **Yan Manşetler (Sub-Hero Grid):** Slider yanında konumlanan 3 adet görsel odaklı güncel haber kartı.
5. **Kategori Izgaraları (Category Grids):** 7 ana kategoriye (Gündem, Teknoloji, Ekonomi, Spor, Dünya, Magazin, Kültür-Sanat) ayrılmış, her birinde yazar, tarih ve okunma sayısı bulunan 2 sütunlu kartlar.
6. **Çok Okunanlar Sıralaması (Popular News):** Özel sayaç meta verisine göre (`haber_post_views_count`) en çok tıklanan haberleri 1'den 5'e kadar renkli rozetlerle sıralayan liste.
7. **Köşe Yazarları & E-Bülten:** Yazar avatarları, makale başlıkları ve etkileşimli bülten kayıt formu.
8. **Detay Sayfası (`single.php`):** Breadcrumb (Gezinti yolu), spot/lead metni, yazar bilgisi, tahmini okuma süresi, görüntülenme sayacı, sosyal medya paylaşım butonları (X, Facebook, WhatsApp) ve benzer haberler.

---

## 2. Dizin ve Dosya Yapısı
Proje teslim klasörü aşağıdaki standart hiyerarşide organize edilmiştir:

```text
haber/
├── style.css                  # Tema üst bilgisi ve stil tanımları
├── functions.php              # Tema çekirdek fonksiyonları, menü/widget kayıtları ve sayaçlar
├── header.php                 # Finans bandı, logo alanı ve dinamik Türkçe kategori navigasyonu
├── footer.php                 # Çok sütunlu kurumsal alt bilgi, kategori linkleri ve telif notu
├── front-page.php             # Ana sayfa vitrini (Manşet, Son Dakika, Izgaralar, Çok Okunanlar)
├── index.php                  # Genel akış ve arşiv yedek şablonu
├── single.php                 # Tekil haber okuma sayfası (Sosyal paylaşım & ilgili haberler)
├── category.php               # Kategori bazlı haber listeleme ve sayfalandırma (pagination)
├── archive.php                # Arşiv şablonu
├── search.php                 # Arama sonuç sayfası
├── 404.php                    # Hata sayfası
├── screenshot.png             # WordPress yönetici paneli tema önizleme görseli (1200x900)
├── seed-content.php           # 7 kategori ve 12 gerçekçi haberi otomatik oluşturan CLI betiği
├── export-wxr.php             # İçeriği resmi WordPress WXR XML biçiminde dışa aktaran betik
├── assets/
│   ├── css/
│   │   └── main.css           # Bütünleşik, optimize edilmiş tema CSS dosyası
│   └── js/
│       └── main.js            # Slider, Ticker ve mobil hamburger menü scriptleri
├── export/
│   ├── database.sql           # Tüm veritabanı tabloları ve örnek içerikleri içeren SQL dökümü
│   └── haber-wordpress-content.xml # WordPress Araçlar > İçe Aktar ile tek tıkla yüklenen XML
├── ekran-goruntuleri/          # Proje teslimi için hazırlanan 5 adet yüksek çözünürlüklü ekran kartı
└── KURULUM-VE-AKADEMIK-KILAVUZ.md # Bu dokümantasyon
```

---

## 3. Kurulum ve Çalıştırma Adımları (XAMPP / Localhost)

### Yöntem A: Hazır XAMPP Ortamında Çalıştırma (Mevcut Kurulum)
Bu proje `c:\xampp\htdocs\silde\` altında çalışan bir WordPress örneği ile birebir eşleştirilmiştir.
1. XAMPP Kontrol Panelinden **Apache** ve **MySQL** servislerini başlatın.
2. Web tarayıcınızdan `http://localhost/silde/` adresine gidin.
3. Haber Portalı tüm manşetleri, son dakika bandı, kategorileri ve içerikleriyle canlı olarak görüntülenecektir.

### Yöntem B: Farklı Bir WordPress Kurulumuna Temayı Yükleme
1. `haber` klasörünü yeni WordPress sitenizin `wp-content/themes/` dizinine kopyalayın.
2. WordPress Yönetim Paneline (`/wp-admin`) giriş yapın.
3. **Görünüm > Temalar** menüsünden **Haber Portalı** temasını bulun ve **Etkinleştir** butonuna tıklayın.
4. İçerikleri yüklemek için aşağıdaki iki seçenekten birini kullanın:
   - **Seçenek 1 (Otomatik Betik):** Komut satırından `php wp-content/themes/haber/seed-content.php` komutunu çalıştırın.
   - **Seçenek 2 (XML İçe Aktarma):** WP Paneli > **Araçlar > İçe Aktar > WordPress** seçeneğiyle `export/haber-wordpress-content.xml` dosyasını seçip yükleyin.

---

## 4. Veritabanı ve Dışa Aktarma Dosyaları (`database.sql` & XML)

1. **`export/database.sql`:**
   - MySQL 8.0 / MariaDB ile tam uyumlu `utf8mb4` karakter setinde oluşturulmuştur.
   - `wp_posts`, `wp_postmeta`, `wp_terms`, `wp_term_taxonomy` ve `wp_options` tablolarındaki tüm verileri eksiksiz barındırır.
   - phpMyAdmin üzerinden `İçe Aktar` (Import) sekmesinden doğrudan yüklenebilir.

2. **`export/haber-wordpress-content.xml` (WXR):**
   - Standart WordPress Extended RSS biçimindedir.
   - 7 çekirdek kategori, etiketler, yazarlar ve 12 tam makaleyi başka hiçbir veritabanı ayarı değiştirmeden herhangi bir WordPress sitesine taşımayı sağlar.

---

## 5. Çekirdek Kategoriler ve 12 Örnek Türkçe Haber Veri Seti

Aşağıdaki kategoriler ve her birine ait özgün haberler veritabanına işlenmiştir:

| # | Kategori | Haber Başlığı | Yazar | Okunma |
|---|---|---|---|---|
| 1 | **Gündem** | Yüksek Hızlı Tren Hatlarında Yeni Dönem: Ankara-İzmir Hattında Test Sürüşleri Başlıyor | Canan Demir | 14.250 |
| 2 | **Gündem** | Kentsel Dönüşümde Yeni Finansman Modeli: Riskli Binalar İçin Faizsiz Kredi ve Hibe Paketi | Mehmet Öztürk | 11.840 |
| 3 | **Teknoloji** | Yerli Yapay Zekâ Büyük Dil Modeli Tanıtıldı: Türkçe Semantik İşlemede Dünya Zirvesine Oynuyor | Dr. Serkan Yıldız | 18.920 |
| 4 | **Teknoloji** | Giyilebilir Sağlık Teknolojilerinde Çığır Açan Buluş: İğnesiz Şeker Ölçümü Yapan Akıllı Sensör | Aylin Çetin | 9.340 |
| 5 | **Ekonomi** | Merkez Bankası Yıl Sonu Enflasyon Raporunu Açıkladı: Dezenflasyon Süreci Kararlılıkla İlerliyor | Canan Demir | 16.300 |
| 6 | **Ekonomi** | Yenilenebilir Enerji Yatırımlarında Tarihi Rekor: Rüzgar ve Güneşin Payı Yüzde 45’i Aştı | Mehmet Öztürk | 8.210 |
| 7 | **Spor** | Süper Lig’de Zirve Yarışı Alev Aldı: Şampiyonluk Adayları Arasındaki Puan Farkı Bire İndi | Dr. Serkan Yıldız | 21.450 |
| 8 | **Spor** | Milli Okçulardan Avrupa Şampiyonası’nda Gövde Gösterisi: 3 Altın, 2 Gümüş Madalya! | Aylin Çetin | 13.100 |
| 9 | **Dünya** | Birleşmiş Milletler İklim Zirvesi’nde Tarihi Mutabakat: 100 Milyar Dolarlık Kayıp-Zarar Fonu | Canan Demir | 7.620 |
| 10 | **Dünya** | Avrupa Birliği’nden Dijital Hizmetler Yasası: Sosyal Medya Algoritmalarına Şeffaflık Zorunluluğu | Mehmet Öztürk | 10.400 |
| 11 | **Magazin** | Altın Portakal Film Festivali’nde Kırmızı Halı Şıklığı: Sinemanın Ustaları ve Genç Yetenekler | Aylin Çetin | 12.500 |
| 12 | **Kültür-Sanat** | Tarihi Yarımada’da Heyecan Veren Keşif: 1500 Yıllık Erken Bizans Sarnıcı Gün Yüzüne Çıkarıldı | Canan Demir | 15.800 |

---

## 6. Teslimat Dosyaları ve Ekran Görüntüleri Paketleme Rehberi

Üniversite teslim şartnamesine göre iki adet arşiv hazırlanması önerilir:

### 1. Ana Proje Paketi (`Haber-Sitesi-Proje-Paketi.zip`):
- İçerik: `haber` temasının kaynak kodları, `export/database.sql`, `export/haber-wordpress-content.xml` ve bu dokümantasyon dosyası.

### 2. Ekran Görüntüleri Paketi (`Ana-Sayfa-Ekran-Goruntuleri.zip`):
- `ekran-goruntuleri/` klasörü içerisindeki 5 adet yüksek çözünürlüklü akademik görsel doğrudan kullanılabilir veya canlı siteden aşağıdaki adımlarla tarayıcı üzerinden yeni tam boy görüntüler alınabilir:

#### Tarayıcı Üzerinden Tam Sayfa Ekran Görüntüsü Alma Adımları:
1. Google Chrome veya Microsoft Edge tarayıcısında `http://localhost/silde/` adresini açın.
2. Klavyeden `F12` veya `Ctrl + Shift + I` tuşlarına basarak Geliştirici Araçları'nı (DevTools) açın.
3. `Ctrl + Shift + P` tuşlarına basın (Komut paleti açılır).
4. Arama kutusuna `screenshot` yazın.
5. Listeden **"Capture full size screenshot"** (Tam boyutlu ekran görüntüsü yakala) seçeneğini tıklayın.
6. İndirilen PNG dosyasını `01-ana-sayfa-tam-boyut.png` olarak adlandırın.
7. Mobil görünüm için DevTools sol üstündeki **Cihaz Çubuğunu Aç/Kapat** (Device Toggle / Ctrl+Shift+M) simgesine basıp iPhone 14 / Samsung Galaxy görünümünde tekrar screenshot alın.
8. Tüm görselleri bir klasörde toplayıp sağ tıklayarak **Gönder > Sıkıştırılmış klasör (.zip)** yapın.
