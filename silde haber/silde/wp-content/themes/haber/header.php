<?php
/**
 * Haber Portalı - header.php
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Üst Bilgi ve Finans Bandı (Top Bar) -->
<div class="top-bar">
    <div class="container top-bar-wrapper">
        <div class="top-bar-left">
            <div class="current-date">
                <i class="fa-regular fa-calendar-days"></i>
                <span><?php echo haber_turkish_date(); ?></span>
            </div>
            <div class="finance-ticker">
                <div class="finance-item">
                    <span>BIST 100:</span>
                    <span class="rate up"><i class="fa-solid fa-caret-up"></i> 9.845,20 (+1.4%)</span>
                </div>
                <div class="finance-item">
                    <span>USD/TRY:</span>
                    <span class="rate up"><i class="fa-solid fa-caret-up"></i> 34,25</span>
                </div>
                <div class="finance-item">
                    <span>EUR/TRY:</span>
                    <span class="rate down"><i class="fa-solid fa-caret-down"></i> 37,15</span>
                </div>
                <div class="finance-item">
                    <span>Gram Altın:</span>
                    <span class="rate up"><i class="fa-solid fa-caret-up"></i> 3.020 TL</span>
                </div>
            </div>
        </div>
        <div class="top-bar-right">
            <div class="weather-widget">
                <i class="fa-solid fa-cloud-sun"></i> İstanbul 19°C | Ankara 16°C | İzmir 22°C
            </div>
        </div>
    </div>
</div>

<!-- Ana Başlık ve Logo Alanı (Site Header) -->
<header class="site-header">
    <div class="container header-main">
        <div class="brand-wrapper">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                    <i class="fa-solid fa-newspaper" style="color: var(--primary);"></i>
                    <span>HABER</span><span class="highlight">PORTALI</span>
                </a>
            <?php endif; ?>
            <span class="site-tagline"><?php bloginfo('description') ?: 'Tarafsız, Güncel ve Doğru Haberin Adresi'; ?></span>
        </div>

        <div class="header-tools">
            <form role="search" method="get" class="search-form-header" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" placeholder="Haberlerde ara..." value="<?php echo get_search_query(); ?>" name="s" required />
                <button type="submit" aria-label="Ara"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </div>

    <!-- Ana Kategori Gezinti Menüsü -->
    <nav class="main-navigation">
        <div class="container nav-container">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <i class="fa-solid fa-bars"></i>
            </button>
            
            <?php
            if (has_nav_menu('primary-menu')) {
                wp_nav_menu(array(
                    'theme_location' => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                ));
            } else {
                // Fallback: Kategori Menüsü Otomatik Listeleme
                echo '<ul class="nav-menu">';
                echo '<li class="' . (is_front_page() ? 'active' : '') . '"><a href="' . esc_url(home_url('/')) . '"><i class="fa-solid fa-house"></i> ANASAYFA</a></li>';
                
                $categories = get_categories(array(
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                    'hide_empty' => false,
                ));

                foreach ($categories as $cat) {
                    if ($cat->slug === 'uncategorized' || $cat->slug === 'genel') continue;
                    $active_class = is_category($cat->term_id) ? 'active' : '';
                    echo '<li class="' . $active_class . '"><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html(mb_strtoupper($cat->name, 'UTF-8')) . '</a></li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
    </nav>
</header>
