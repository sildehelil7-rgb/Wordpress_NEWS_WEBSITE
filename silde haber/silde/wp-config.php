<?php
/**
 * WordPress için başlangıç ayar dosyası.
 *
 * Bu dosya kurulum sırasında wp-config.php dosyasının oluşturulabilmesi için
 * kullanılır. İsterseniz bu dosyayı kopyalayıp, ismini "wp-config.php" olarak değiştirip,
 * değerleri girerek de kullanabilirsiniz.
 *
 * Bu dosya şu ayarları içerir:
 * 
 * * Veritabanı ayarları
 * * Gizli anahtarlar
 * * Veritabanı tablo ön eki
 * * ABSPATH
 * 
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Veritabanı ayarları - Bu bilgileri servis sağlayıcınızdan alabilirsiniz ** //
/** WordPress için kullanılacak veritabanının adı */
define( 'DB_NAME', 'word_sd' );

/** Veritabanı kullanıcısı */
define( 'DB_USER', 'root' );

/** Veritabanı parolası */
define( 'DB_PASSWORD', '' );

/** Veritabanı sunucusu */
define( 'DB_HOST', 'localhost' );

/** Yaratılacak tablolar için veritabanı karakter seti. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Veritabanı karşılaştırma tipi. Herhangi bir şüpheniz varsa bu değeri değiştirmeyin. */
define( 'DB_COLLATE', '' );

/**#@+
 * Eşsiz doğrulama anahtarları ve tuzlar.
 *
 * Her anahtar farklı bir karakter kümesi olmalı!
 * {@link http://api.wordpress.org/secret-key/1.1/salt WordPress.org secret-key service} servisini kullanarak yaratabilirsiniz.
 * 
 * Çerezleri geçersiz kılmak için istediğiniz zaman bu değerleri değiştirebilirsiniz.
 * Bu tüm kullanıcıların tekrar giriş yapmasını gerektirecektir.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'sDM%n V}_m)M^}yY!u8><%l>5UYUQ7&t4GwY}H2PG:pd*d7]dU$=9ay3rY$[WjPJ' );
define( 'SECURE_AUTH_KEY',  'a2t-y_U`4=>9iFJ69Hg`Nzz8Rnc26<bX ~ufz#B.o/;0s _~bTam^Bs;-N69R6?j' );
define( 'LOGGED_IN_KEY',    '4d+IV!MD44@*Fm(EBvIAfYhl6+ggR<Og/5:v2{pd@sauB,_zW!Gt~dQ2n11e9v4V' );
define( 'NONCE_KEY',        '++h=r|}I%&pv1o3blx|},Ip~|{hZe7M8wJbI-b<kiq{<~0P3;M:~}j`9;Cz<P;G{' );
define( 'AUTH_SALT',        'Ha$J-6tECh1_JuO`aR59YR7`xWHD[.>605Ga9U8bNFQ;`P!A=C%a7Y#(O_l$dnN3' );
define( 'SECURE_AUTH_SALT', ' {C*.n%Fu(e(n&OLonr^lNI[,mn#A{pz`xXA!iYboh.^ZS*X8L&i=n0>K@&$O83U' );
define( 'LOGGED_IN_SALT',   '`P5)g<)Yfdo;n@z}}1Yo8f~zE0][ND:=3|Gu`c|w}*Gb}F`=6@nd2ML(y%=Yfha#' );
define( 'NONCE_SALT',       'LKB`}&?*v9!hbXRRZrwIk/o#BwZq@&*AEMT8f{@Cwa*&=MSZ^>C~q/69Y]qEb&~7' );

/**#@-*/

/**
 * WordPress veritabanı tablo ön eki.
 *
 * Tüm kurulumlara ayrı bir önek vererek bir veritabanına birden fazla kurulum yapabilirsiniz.
 * Sadece rakamlar, harfler ve alt çizgi lütfen.
 *
 * Kurulum sırasında veritabanı tabloları belirtilen önek ile oluşturulur. 
 * WordPress kurulduktan sonra bu değeri değiştirmek, sitenin kurulmamış
 * olduğunu düşünmesine neden olur.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * Geliştiriciler için: WordPress hata ayıklama modu.
 *
 * Bu değeri true olarak ayarlayıp geliştirme sırasında hataların ekrana
 * basılmasını sağlayabilirsiniz. Tema ve eklenti geliştiricilerinin geliştirme
 * aşamasında WP_DEBUG kullanmalarını önemle tavsiye ederiz.
 * 
 * Hata ayıklama için kullanabilecek diğer sabitler ile ilgili daha fazla bilgiyi
 * belgelerden edinebilirsiniz.
 * 
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Her türlü özel değeri bu satı ile "Hepsi bu kadar" yazan satır arasına ekleyebilirsiniz. */



/* Hepsi bu kadar. Mutlu bloglamalar! */

/** WordPress dizini için mutlak yol. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/** WordPress değişkenlerini ve yollarını kurar. */
require_once ABSPATH . 'wp-settings.php';