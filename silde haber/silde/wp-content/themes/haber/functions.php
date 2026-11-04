<?php
/**
 * Haber Portalı - functions.php
 * Üniversite Bitirme Projesi & Profesyonel Haber Portalı Tema Fonksiyonları
 */

if (!defined('ABSPATH')) {
    exit; // Doğrudan erişimi engelle
}

define('HABER_THEME_VERSION', '1.0.0');
define('HABER_THEME_DIR', get_template_directory());
define('HABER_THEME_URI', get_template_directory_uri());

/**
 * 1. Tema Kurulumu & Özellik Destekleri
 */
function haber_theme_setup() {
    // Çoklu dil desteği
    load_theme_textdomain('haber', HABER_THEME_DIR . '/languages');

    // Başlık etiketi desteği
    add_theme_support('title-tag');

    // Öne çıkan görsel (Thumbnail) desteği
    add_theme_support('post-thumbnails');

    // Özel görsel boyutları
    add_image_size('haber-manset', 850, 480, true);   // Ana Manşet boyutu
    add_image_size('haber-grid', 450, 260, true);     // Kategori ızgara boyutu
    add_image_size('haber-side', 220, 160, true);     // Yan liste / çok okunanlar boyutu

    // Menü alanlarını kaydet
    register_nav_menus(array(
        'primary-menu' => __('Ana Menü (Kategoriler)', 'haber'),
        'footer-menu'  => __('Footer Menü', 'haber'),
        'top-menu'     => __('Üst Bar Menü', 'haber'),
    ));

    // HTML5 desteği
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Özel logo desteği
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'haber_theme_setup');

/**
 * 2. Stil ve Scriptlerin Kuyruğa Eklenmesi (Enqueue)
 */
function haber_enqueue_scripts() {
    // Google Fonts (Inter)
    wp_enqueue_style('haber-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Merriweather:wght@300;400;700&display=swap', array(), null);

    // Font Awesome (ikonlar için)
    wp_enqueue_style('haber-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');

    // Ana Tema Stili
    wp_enqueue_style('haber-main-style', HABER_THEME_URI . '/assets/css/main.css', array(), HABER_THEME_VERSION);

    // Tema style.css
    wp_enqueue_style('haber-style', get_stylesheet_uri(), array('haber-main-style'), HABER_THEME_VERSION);

    // Ana JavaScript Dosyası
    wp_enqueue_script('haber-main-js', HABER_THEME_URI . '/assets/js/main.js', array(), HABER_THEME_VERSION, true);
}
add_action('wp_enqueue_scripts', 'haber_enqueue_scripts');

/**
 * 3. Bileşen (Widget) Alanları
 */
function haber_register_widgets() {
    register_sidebar(array(
        'name'          => __('Ana Kenar Çubuğu (Sidebar)', 'haber'),
        'id'            => 'main-sidebar',
        'description'   => __('Haber detay ve kategori sayfalarındaki kenar çubuğu bileşenleri.', 'haber'),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="section-title-wrap"><h3 class="section-title">',
        'after_title'   => '</h3></div>',
    ));
}
add_action('widgets_init', 'haber_register_widgets');

/**
 * 4. Okunma Sayısı (Görüntülenme Sayacı)
 */
function haber_get_post_views($postID) {
    $count_key = 'haber_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count === '' || $count === false) {
        return '1.2K';
    }
    if ($count >= 1000) {
        return round($count / 1000, 1) . 'K';
    }
    return $count;
}

function haber_set_post_views($postID) {
    $count_key = 'haber_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count === '') {
        $count = rand(150, 1200); // İlk başlangıç için gerçekçi rakam
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, $count);
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

/**
 * 5. Okuma Süresi Hesaplayıcı
 */
function haber_reading_time($postID = null) {
    $content = get_post_field('post_content', $postID);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    return max(1, $reading_time) . ' dk okuma';
}

/**
 * 6. Özet Metin Uzunluğu (Excerpt Length)
 */
function haber_custom_excerpt_length($length) {
    return 18;
}
add_filter('excerpt_length', 'haber_custom_excerpt_length', 999);

function haber_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'haber_excerpt_more');

/**
 * 7. Yedek / Varsayılan Görsel Desteği
 */
function haber_get_thumbnail_url($post_id, $size = 'haber-grid', $category_slug = 'gundem') {
    if (has_post_thumbnail($post_id)) {
        return get_the_post_thumbnail_url($post_id, $size);
    }

    // Özel kategori bazlı yüksek kaliteli haber placeholder görselleri
    $placeholders = array(
        'gundem'       => 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=900&auto=format&fit=crop&q=80',
        'teknoloji'    => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=900&auto=format&fit=crop&q=80',
        'ekonomi'      => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=900&auto=format&fit=crop&q=80',
        'spor'         => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=900&auto=format&fit=crop&q=80',
        'dunya'        => 'https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?w=900&auto=format&fit=crop&q=80',
        'magazin'      => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=900&auto=format&fit=crop&q=80',
        'kultur-sanat' => 'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?w=900&auto=format&fit=crop&q=80',
    );

    if (isset($placeholders[$category_slug])) {
        return $placeholders[$category_slug];
    }

    return 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=900&auto=format&fit=crop&q=80';
}

/**
 * 8. Türkçe Tarih Biçimlendirici Yardımcısı
 */
function haber_turkish_date() {
    $months = array(
        1 => 'Ocak', 2 => 'Şubat', 3 => 'Mart', 4 => 'Nisan',
        5 => 'Mayıs', 6 => 'Haziran', 7 => 'Temmuz', 8 => 'Ağustos',
        9 => 'Eylül', 10 => 'Ekim', 11 => 'Kasım', 12 => 'Aralık'
    );
    $days = array(
        'Monday' => 'Pazartesi', 'Tuesday' => 'Salı', 'Wednesday' => 'Çarşamba',
        'Thursday' => 'Perşembe', 'Friday' => 'Cuma', 'Saturday' => 'Cumartesi', 'Sunday' => 'Pazar'
    );

    $current_time = current_time('timestamp');
    $day_name = $days[date('l', $current_time)];
    $month_name = $months[(int)date('n', $current_time)];
    return date('j', $current_time) . ' ' . $month_name . ' ' . date('Y', $current_time) . ', ' . $day_name;
}
