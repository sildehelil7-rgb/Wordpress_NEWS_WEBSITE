<?php
/**
 * Haber Portalı - Veri Tabanı Tohumlama (Database Seeder)
 * Üniversite teslimatı için otomatik kategori ve 12 adet tam Türkçe haber oluşturucu.
 */

// WordPress ortamını yükle
$wp_load_path = dirname(__DIR__, 3) . '/wp-load.php';
if (!file_exists($wp_load_path)) {
    die("Hata: wp-load.php bulunamadı. Lütfen dosya yolunu kontrol edin.\n");
}
require_once $wp_load_path;

echo "=== HABER PORTALI İÇERİK TOHUMLAMA BAŞLATILDI ===\n\n";

// 1. Temayı Aktif Hale Getir
update_option('template', 'haber');
update_option('stylesheet', 'haber');
update_option('blogname', 'Haber Portalı');
update_option('blogdescription', 'Tarafsız, Güncel ve Doğru Haberin Dijital Adresi');
echo "[+] 'haber' teması varsayılan tema olarak etkinleştirildi.\n";

// 2. Çekirdek Kategorilerin Oluşturulması
$categories = array(
    'Gündem'       => array('slug' => 'gundem', 'desc' => 'Türkiye ve dünyadan sıcak gelişmeler, siyaset ve güncel olaylar.'),
    'Teknoloji'    => array('slug' => 'teknoloji', 'desc' => 'Yapay zeka, mobil cihazlar, uzay araştırmaları ve dijital dönüşüm.'),
    'Ekonomi'      => array('slug' => 'ekonomi', 'desc' => 'Borsa, döviz, altın, enflasyon raporları ve piyasa analizleri.'),
    'Spor'         => array('slug' => 'spor', 'desc' => 'Futbol, basketbol, voleybol, olimpiyatlar ve transfer haberleri.'),
    'Dünya'        => array('slug' => 'dunya', 'desc' => 'Uluslararası diplomasi, jeopolitik gelişmeler ve küresel haberler.'),
    'Magazin'      => array('slug' => 'magazin', 'desc' => 'Kültür, sanatçıların yaşamı, festivaller ve etkinlikler.'),
    'Kültür-Sanat' => array('slug' => 'kultur-sanat', 'desc' => 'Tiyatro, sinema, edebiyat, arkeoloji ve sergi haberleri.')
);

$cat_ids = array();
foreach ($categories as $cat_name => $cat_data) {
    $term = get_term_by('slug', $cat_data['slug'], 'category');
    if (!$term) {
        $result = wp_insert_term($cat_name, 'category', array(
            'slug'        => $cat_data['slug'],
            'description' => $cat_data['desc'],
        ));
        if (!is_wp_error($result)) {
            $cat_ids[$cat_data['slug']] = $result['term_id'];
            echo "[+] Kategori oluşturuldu: {$cat_name} (ID: {$result['term_id']})\n";
        }
    } else {
        $cat_ids[$cat_data['slug']] = $term->term_id;
        echo "[*] Kategori zaten mevcut: {$cat_name} (ID: {$term->term_id})\n";
    }
}

// 3. Yazarların Oluşturulması / Tanımlanması
$authors = array(
    array('user_login' => 'canan_demir', 'display_name' => 'Canan Demir', 'user_email' => 'canan@haberportali.local'),
    array('user_login' => 'mehmet_ozturk', 'display_name' => 'Mehmet Öztürk', 'user_email' => 'mehmet@haberportali.local'),
    array('user_login' => 'dr_serkan', 'display_name' => 'Dr. Serkan Yıldız', 'user_email' => 'serkan@haberportali.local'),
    array('user_login' => 'aylin_cetin', 'display_name' => 'Aylin Çetin', 'user_email' => 'aylin@haberportali.local'),
);

$author_ids = array();
foreach ($authors as $a) {
    $user = get_user_by('login', $a['user_login']);
    if (!$user) {
        $uid = wp_create_user($a['user_login'], wp_generate_password(), $a['user_email']);
        if (!is_wp_error($uid)) {
            wp_update_user(array('ID' => $uid, 'display_name' => $a['display_name']));
            $author_ids[] = $uid;
        }
    } else {
        $author_ids[] = $user->ID;
    }
}

// Eğer yazar oluşturulamazsa varsayılan admin kullanılsın
$admin_user = get_users(array('role' => 'administrator', 'number' => 1));
$fallback_author = !empty($admin_user) ? $admin_user[0]->ID : 1;

// 4. 12 Gerçekçi Türkçe Haber Veri Kümesi
$articles = array(
    // 1. Gündem
    array(
        'title'    => 'Yüksek Hızlı Tren Hatlarında Yeni Dönem: Ankara-İzmir Hattında Test Sürüşleri Başlıyor',
        'category' => 'gundem',
        'author'   => $authors[0]['display_name'],
        'views'    => 14250,
        'excerpt'  => 'Ulaştırma Bakanlığı, Ankara ile İzmir arasındaki seyahat süresini 3,5 saate indirecek yüksek hızlı tren projesinde kritik aşamaya gelindiğini duyurdu.',
        'content'  => '<p class="lead">Ulaştırma ve Altyapı Bakanlığı tarafından yürütülen Cumhuriyet tarihinin en büyük demiryolu projelerinden biri olan Ankara-İzmir Yüksek Hızlı Tren (YHT) hattında önemli bir kilometre taşı geride bırakıldı.</p>
<h2>Yolculuk Süresi 3,5 Saate İnecek</h2>
<p>Proje tamamlandığında mevcut demiryolu bağlantısıyla yaklaşık 14 saat süren, karayoluyla ise ortalama 6-7 saati bulan seyahat süresi kesintisiz 3 saat 30 dakikaya inecek. 508 kilometrelik modern güzergâh boyunca inşa edilen 41 tünel ve 67 viyadüğün tamamlanma oranının yüzde 88’e ulaştığı bildirildi.</p>
<blockquote>"Bu hat yalnızca iki büyük metropolü birbirine bağlamakla kalmayacak; güzergâh üzerindeki Afyonkarahisar, Uşak ve Manisa ekonomisine de eşi görülmemiş bir hareketlilik kazandıracak."</blockquote>
<p>Test sürüşlerinin önümüzdeki ay ilk etap olan Afyon kesiminde başlayacağı, sinyalizasyon ve güvenlik testlerinin ardından projenin ticari seferlere hazır hale getirileceği açıklandı.</p>',
        'tags'     => array('Ulaştırma', 'YHT', 'Demiryolu', 'Ankara', 'İzmir')
    ),

    // 2. Gündem
    array(
        'title'    => 'Kentsel Dönüşümde Yeni Finansman Modeli: Riskli Binalar İçin Faizsiz Kredi ve Hibe Paketi Açıklandı',
        'category' => 'gundem',
        'author'   => $authors[1]['display_name'],
        'views'    => 11840,
        'excerpt'  => 'Çevre ve Şehircilik Bakanlığı, olası afet risklerine karşı konutlarını yenilemek isteyen mülk sahipleri için 1.5 milyon TL hibe ve kredi desteğini kamuoyuna sundu.',
        'content'  => '<p class="lead">Deprem kuşağında yer alan ülkemizde yapı stokunun yenilenmesini hızlandırmak amacıyla hazırlanan kapsamlı kentsel dönüşüm destek paketi Resmi Gazete’de yayımlanarak yürürlüğe girdi.</p>
<h2>Hak Sahiplerine Doğrudan Destek</h2>
<p>Yeni model kapsamında bağımsız bölüm başına 750 bin TL doğrudan hibe, 750 bin TL ise ilk 2 yılı geri ödemesiz olmak üzere toplam 10 yıl vadeli uygun faizli kredi imkanı sunulacak. Ayrıca taşınma yardımı tutarı da büyükşehirlerde 100 bin TL’ye yükseltildi.</p>
<blockquote>"Hedefimiz, önümüzdeki 5 yıl içerisinde başta Marmara bölgesi olmak üzere ülke genelinde 1.5 milyon acil dönüştürülmesi gereken konutu dayanıklı ve güvenli hale getirmektir."</blockquote>
<p>Başvuruların e-Devlet kapısı üzerinden alınmaya başlandığı ve dönüşüm sürecinin bürokratik işlemlerinin tek merkezden yönetileceği belirtildi.</p>',
        'tags'     => array('Kentsel Dönüşüm', 'Deprem', 'Konut', 'Hibe', 'Gündem')
    ),

    // 3. Teknoloji
    array(
        'title'    => 'Yerli Yapay Zekâ Büyük Dil Modeli Tanıtıldı: Türkçe Semantik İşlemede Dünya Zirvesine Oynuyor',
        'category' => 'teknoloji',
        'author'   => $authors[2]['display_name'],
        'views'    => 18920,
        'excerpt'  => 'TÜBİTAK BİLGEM ve önde gelen Türk üniversitelerinin ortaklığıyla geliştirilen yerli büyük dil modeli, Türkçe morfolojik uyumda yüzde 94 doğruluk oranına ulaştı.',
        'content'  => '<p class="lead">Yapay zekâ teknolojilerinde dışa bağımlılığı azaltmak ve Türkçe dil yapısına tam uyumlu algoritmalar üretmek amacıyla başlatılan milli yapay zekâ projesinde beklenen duyuru gerçekleşti.</p>
<h2>Açık Kaynak Kodlu ve Güvenli Veri Altyapısı</h2>
<p>Tamamen yerli sunucularda ve etik süzgeçlerden geçirilmiş 500 milyar kelimelik devasa Türkçe metin havuzu ile eğitilen model; hukuk, tıp, mühendislik ve edebiyat metinlerinde üstün bağlamsal kavrayış sergiliyor.</p>
<p>Modelin araştırmacılar, kamu kurumları ve girişimciler için açık kaynaklı API arayüzleriyle ücretsiz kullanıma açılacağı bildirildi. Sistemin bankacılık ve çağrı merkezi operasyonlarında verimliliği 3 kat artırması bekleniyor.</p>',
        'tags'     => array('Yapay Zeka', 'TÜBİTAK', 'Yerli Teknoloji', 'Büyük Dil Modeli', 'Yazılım')
    ),

    // 4. Teknoloji
    array(
        'title'    => 'Giyilebilir Sağlık Teknolojilerinde Çığır Açan Buluş: İğnesiz Şeker Ölçümü Yapan Akıllı Sensör',
        'category' => 'teknoloji',
        'author'   => $authors[3]['display_name'],
        'views'    => 9340,
        'excerpt'  => 'Biyomedikal mühendislerinin geliştirdiği optik mikro-sensör, diyabet hastalarının kan şekeri takibini parmak delme ihtiyacı olmadan deri yüzeyinden anlık yapabiliyor.',
        'content'  => '<p class="lead">Dünya genelinde 500 milyondan fazla diyabet hastasını yakından ilgilendiren medikal teknoloji inovasyonunda son klinik testler başarıyla neticelendi.</p>
<h2>24 Saat Kesintisiz Glukoz İzleme</h2>
<p>Geliştirilen optik biyosensör, derinin alt katmanlarındaki mikroskobik damar hareketlerini kızılötesi ışık dalgalarıyla analiz ederek kan şekerini milisaniyeler içerisinde ölçüyor. Elde edilen veriler akıllı saat ve telefonlara anında grafiksel olarak aktarılıyor.</p>
<p>FDA ve CE onayı süreçlerinin başladığı ürünün, 2027 başında ticari olarak eczanelerde ve teknoloji marketlerinde yerini alması öngörülüyor.</p>',
        'tags'     => array('Biyomedikal', 'Sağlık Teknolojisi', 'İnovasyon', 'Akıllı Saat')
    ),

    // 5. Ekonomi
    array(
        'title'    => 'Merkez Bankası Yıl Sonu Enflasyon Raporunu Açıkladı: Dezenflasyon Süreci Kararlılıkla İlerliyor',
        'category' => 'ekonomi',
        'author'   => $authors[0]['display_name'],
        'views'    => 16300,
        'excerpt'  => 'TCMB Başkanı düzenlenen basın toplantısında parasal sıkılaşmanın iç talepte dengelenme sağladığını ve cari açıkta tarihi toparlanma yaşandığını belirtti.',
        'content'  => '<p class="lead">Türkiye Cumhuriyet Merkez Bankası (TCMB), ekonomi çevrelerinin merakla beklediği yılın son Enflasyon Raporu sunumunu gerçekleştirdi.</p>
<h2>Fiyat İstikrarı ve Rezerv Artışı</h2>
<p>Merkez Bankası Başkanı, raporda paylaşılan projeksiyonlara göre enflasyonun ana eğiliminde belirgin bir yavaşlama kaydedildiğini belirtti. Swap hariç net rezervlerin pozitif bölgeye kalıcı şekilde geçmesiyle birlikte Türk Lirası varlıklara olan küresel ilginin katlanarak arttığı vurgulandı.</p>
<blockquote>"Para politikasındaki kararlı duruşumuz, fiyatlama davranışlarında rasyonelleşmeyi beraberinde getirmiştir. Enflasyon tek haneye inene dek sıkı para politikası sürdürülecektir."</blockquote>
<p>BIST 100 endeksi ve uluslararası derecelendirme kuruluşlarının kredi notu artışları da ekonomideki güven ortamını teyit ediyor.</p>',
        'tags'     => array('Merkez Bankası', 'Enflasyon', 'Faiz', 'BIST100', 'Ekonomi')
    ),

    // 6. Ekonomi
    array(
        'title'    => 'Yenilenebilir Enerji Yatırımlarında Tarihi Rekor: Rüzgar ve Güneşin Payı Yüzde 45’i Aştı',
        'category' => 'ekonomi',
        'author'   => $authors[1]['display_name'],
        'views'    => 8210,
        'excerpt'  => 'Enerji ve Tabii Kaynaklar Bakanlığı verilerine göre Türkiye, kurulu güç sıralamasında Avrupa’da 5., dünyada ise 11. sıraya yükseldi.',
        'content'  => '<p class="lead">Türkiye’nin enerji ithalatını azaltma ve sıfır karbon hedefine ulaşma doğrultusunda attığı dev adımlar meyvelerini veriyor.</p>
<h2>Yerli Ekipman ve Yeşil Sanayi Dönüşümü</h2>
<p>Geçtiğimiz çeyrekte devreye alınan 1.800 megavatlık yeni güneş enerjisi santralleri (GES) ve rüzgar türbinleri sayesinde ülkenin elektrik üretiminde temiz kaynakların payı rekor seviyeye çıktı. Rüzgar türbini kanadı ve kule üretiminde Türkiye, Avrupa’nın en önemli ihracatçı üslerinden biri konumuna geldi.</p>
<p>Uzmanlar, yeşil enerji dönüşümünün sanayicilere sınırda karbon vergisi muafiyeti sağlayarak küresel rekabet gücünü artıracağını vurguluyor.</p>',
        'tags'     => array('Enerji', 'Güneş Enerjisi', 'Rüzgar', 'Sanayi', 'İhracat')
    ),

    // 7. Spor
    array(
        'title'    => 'Süper Lig’de Zirve Yarışı Alev Aldı: Şampiyonluk Adayları Arasındaki Puan Farkı Bire İndi',
        'category' => 'spor',
        'author'   => $authors[2]['display_name'],
        'views'    => 21450,
        'excerpt'  => 'Haftanın dev müsabakasında uzatma dakikalarında gelen golle deplasmanda galip gelen şampiyonluk adayı, ligdeki tüm dengeleri yeniden değiştirdi.',
        'content'  => '<p class="lead">Trendyol Süper Lig’in 28. haftası, son yılların en yüksek tempolu ve taktiksel mücadelesine sahne oldu.</p>
<h2>90+4’te Gelen Zafer Golü</h2>
<p>Nefesleri kesen derbi müsabakasında 50 bin taraftarın önünde oynanan maçta her iki takım da ofansif bir futbol sergiledi. Karşılaşmanın bitimine saniyeler kala köşe vuruşundan gelen topu ağlara gönderen konuk ekip, sahadan 2-1 galip ayrılarak liderle arasındaki puan farkını 1’e indirdi.</p>
<p>Teknik direktör basın toplantısında: "Oyuncularımın inancı ve sahada gösterdiği karakter bu zaferi getirdi. Lig son maça kadar büyük bir heyecana sahne olacak" değerlendirmesinde bulundu.</p>',
        'tags'     => array('Süper Lig', 'Futbol', 'Derbi', 'Şampiyonluk', 'Spor')
    ),

    // 8. Spor
    array(
        'title'    => 'Milli Okçulardan Avrupa Şampiyonası’nda Gövde Gösterisi: 3 Altın, 2 Gümüş Madalya!',
        'category' => 'spor',
        'author'   => $authors[3]['display_name'],
        'views'    => 13100,
        'excerpt'  => 'Avrupa Okçuluk Şampiyonası finallerinde mücadele eden Klasik Yay ve Makaralı Yay Milli Takımlarımız üstün performansla İstiklal Marşımızı dinletti.',
        'content'  => '<p class="lead">Olimpiyat şampiyonu Mete Gazoz’un da yer aldığı Türkiye Okçuluk Milli Takımı, Almanya’nın ev sahipliğinde düzenlenen Avrupa Şampiyonası’nda tarihi bir başarıya imza attı.</p>
<h2>Madalya Sıralamasında Zirve</h2>
<p>Bireysel ve takım finallerinde kusursuza yakın atışlar sergileyen milli okçularımız, organizasyonu 3 altın ve 2 gümüş madalya kazanarak genel klasmanda birinci sırada tamamladı.</p>
<p>Milli sporcular yaptıkları ortak açıklamada, bir sonraki hedeflerinin Los Angeles Olimpiyat Oyunları’nda rekor kırmak olduğunu belirterek destek veren tüm spor severlere teşekkür etti.</p>',
        'tags'     => array('Okçuluk', 'Mete Gazoz', 'Milli Takım', 'Madalya', 'Olimpiyat')
    ),

    // 9. Dünya
    array(
        'title'    => 'Birleşmiş Milletler İklim Zirvesi’nde Tarihi Mutabakat: 100 Milyar Dolarlık Kayıp-Zarar Fonu Onaylandı',
        'category' => 'dunya',
        'author'   => $authors[0]['display_name'],
        'views'    => 7620,
        'excerpt'  => '190 ülkenin katılımıyla gerçekleştirilen COP İklim Konferansı’nda, aşırı hava olaylarından etkilenen gelişmekte olan ülkeler için küresel finansman mutabakatına varıldı.',
        'content'  => '<p class="lead">İki hafta süren yoğun müzakerelerin ardından dünya liderleri ve çevre delegasyonları, iklim krizinin yıkıcı etkilerine karşı ortak fon kurulmasında anlaştı.</p>
<h2>Karbon Salımını Azaltma Taahhütleri</h2>
<p>Kabul edilen bildiride gelişmiş sanayi ülkelerinin fona yıllık 100 milyar dolar aktarması öngörülüyor. Fon özellikle sel, kuraklık ve ada ülkelerini tehdit eden deniz seviyesi yükselmelerine karşı dayanıklılık projelerine tahsis edilecek.</p>
<p>BM Genel Sekreteri, mutabakatın tarihi bir adım olduğunu ancak küresel ısınmayı 1.5 derece sınırında tutmak için daha radikal kararlar alınması gerektiğini ifade etti.</p>',
        'tags'     => array('Birleşmiş Milletler', 'İklim Zirvesi', 'Küresel Isınma', 'Dünya')
    ),

    // 10. Dünya
    array(
        'title'    => 'Avrupa Birliği’nden Dijital Hizmetler Yasası: Sosyal Medya Algoritmalarına Şeffaflık Zorunluluğu',
        'category' => 'dunya',
        'author'   => $authors[1]['display_name'],
        'views'    => 10400,
        'excerpt'  => 'Brüksel merkezli yeni AB regülasyonu ile büyük teknoloji platformlarının kullanıcı verilerini işlemesi ve hedefli reklam modellerine sıkı denetimler getirildi.',
        'content'  => '<p class="lead">Avrupa Parlamentosu tarafından onaylanan Dijital Hizmetler Yasası (DSA) kapsamında, milyonlarca kullanıcıya sahip küresel internet devleri için yeni kurallar devreye girdi.</p>
<h2>Sahte Haber ve Dezenformasyona Ağır Ceza</h2>
<p>Yeni düzenlemeye göre dijital platformlar, yapay zekâ öneri algoritmalarını denetim kurullarına açmak ve zararlı içerikleri 24 saat içinde kaldırmakla yükümlü kılındı. Kurallara uymayan şirketlere küresel cirolarının yüzde 6’sına varan para cezaları kesilebilecek.</p>',
        'tags'     => array('Avrupa Birliği', 'Teknoloji Hukuku', 'Gizlilik', 'Sosyal Medya')
    ),

    // 11. Magazin
    array(
        'title'    => 'Altın Portakal Film Festivali’nde Kırmızı Halı Şıklığı: Sinemanın Ustaları ve Genç Yetenekler Buluştu',
        'category' => 'magazin',
        'author'   => $authors[3]['display_name'],
        'views'    => 12500,
        'excerpt'  => 'Türkiye’nin en köklü sinema buluşması olan Antalya Altın Portakal Film Festivali, görkemli bir gala gecesi ve ünlü isimlerin katılımıyla başladı.',
        'content'  => '<p class="lead">Sinema tutkunlarının heyecanla beklediği festivalin açılış galası, Cam Piramit Fuar ve Kongre Merkezi’nde yıldızlar geçidine sahne oldu.</p>
<h2>Yaşam Boyu Onur Ödülleri Sahiplerini Buldu</h2>
<p>Gecede Yeşilçam’ın efsane isimlerine Yaşam Boyu Onur Ödülleri takdim edilirken, salonu dolduran yüzlerce davetli ustalara dakikalarca ayakta alkışlarla eşlik etti. Hafta boyunca 14 farklı ülkeden 60’ı aşkın uzun metrajlı film jüri karşısına çıkacak.</p>',
        'tags'     => array('Altın Portakal', 'Sinema', 'Kırmızı Halı', 'Festival', 'Magazin')
    ),

    // 12. Kültür-Sanat
    array(
        'title'    => 'Tarihi Yarımada’da Heyecan Veren Keşif: 1500 Yıllık Erken Bizans Sarnıcı Gün Yüzüne Çıkarıldı',
        'category' => 'kultur-sanat',
        'author'   => $authors[0]['display_name'],
        'views'    => 15800,
        'excerpt'  => 'İstanbul’un kalbinde yürütülen titiz restorasyon çalışmaları sırasında, sütun başlıkları ve su kanalları bozulmadan günümüze ulaşan muazzam bir sarnıç keşfedildi.',
        'content'  => '<p class="lead">Kültür ve Turizm Bakanlığı ile İstanbul Arkeoloji Müzeleri Müdürlüğü koordinasyonunda sürdürülen kazı çalışmalarında heyecan verici bir bulguya ulaşıldı.</p>
<h2>Kültürel Mirasa Yeni Bir Mücevher</h2>
<p>Yapılan ilk incelemelerde MS 6. yüzyıla, yani I. Justinianus dönemine tarihlendirilen su sarnıcının 24 adet korint başlıklı mermer sütunla taşındığı ve su yalıtım harcının orijinal halini koruduğu tespit edildi.</p>
<p>Arkeoloji uzmanları, sarnıcın konservasyon işlemlerinin tamamlanmasının ardından yerli ve yabancı ziyaretçilere açık bir arkeo-park ve sergi alanı olarak düzenleneceğini belirtti.</p>',
        'tags'     => array('Arkeoloji', 'Tarihi Yarımada', 'İstanbul', 'Restorasyon', 'Kültür-Sanat')
    )
);

// 5. Haberleri Oluştur ve Veritabanına Yaz
$created_count = 0;
foreach ($articles as $index => $art) {
    // Aynı başlıklı yazı var mı kontrol et
    $existing = get_page_by_title($art['title'], OBJECT, 'post');
    if ($existing) {
        echo "[*] Yazı zaten var: {$art['title']}\n";
        continue;
    }

    $target_cat_id = isset($cat_ids[$art['category']]) ? $cat_ids[$art['category']] : 1;
    $author_id = !empty($author_ids) ? $author_ids[$index % count($author_ids)] : $fallback_author;

    // Tarihi biraz geriye doğru kademelendir (gerçekçi görünüm)
    $hours_ago = ($index * 4) + 1;
    $post_date = date('Y-m-d H:i:s', strtotime("-{$hours_ago} hours"));

    $post_data = array(
        'post_title'    => $art['title'],
        'post_content'  => $art['content'],
        'post_excerpt'  => $art['excerpt'],
        'post_status'   => 'publish',
        'post_type'     => 'post',
        'post_author'   => $author_id,
        'post_date'     => $post_date,
        'post_category' => array($target_cat_id),
        'tags_input'    => $art['tags'],
    );

    $post_id = wp_insert_post($post_data);
    if (!is_wp_error($post_id)) {
        // Okunma sayısı metasını ekle
        update_post_meta($post_id, 'haber_post_views_count', $art['views']);
        $created_count++;
        echo "[+] Haber eklendi: ID #{$post_id} - '{$art['title']}' (Kategori: {$art['category']})\n";
    } else {
        echo "[-] Hata oluştu: " . $post_id->get_error_message() . "\n";
    }
}

echo "\n[TAMAMLANDI] Toplam {$created_count} adet haber başarıyla veri tabanına işlendi.\n";
