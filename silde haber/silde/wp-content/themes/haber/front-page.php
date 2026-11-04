<?php
/**
 * Haber Portalı - front-page.php
 * Ana Sayfa Şablonu: Manşet, Son Dakika, Çok Okunanlar, Kategori Izgaraları
 */

get_header(); ?>

<main class="site-main" style="padding-top: 20px;">
    <div class="container">

        <!-- 1. SON DAKİKA (BREAKING NEWS TICKER) -->
        <section class="breaking-news-ticker" aria-label="Son Dakika Haberleri">
            <div class="ticker-inner">
                <div class="ticker-label">
                    <i class="fa-solid fa-bolt"></i> SON DAKİKA
                </div>
                <div class="ticker-content">
                    <div class="ticker-items">
                        <?php
                        $ticker_query = new WP_Query(array(
                            'posts_per_page'      => 6,
                            'ignore_sticky_posts' => 1,
                        ));

                        if ($ticker_query->have_posts()) :
                            while ($ticker_query->have_posts()) : $ticker_query->the_post();
                                $post_time = get_the_time('H:i');
                                ?>
                                <span class="ticker-item">
                                    <strong style="color: var(--primary);"><?php echo esc_html($post_time); ?></strong> 
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </span>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            ?>
                            <span class="ticker-item">Günün sıcak gelişmeleri ve son dakika haberleri aktarılıyor...</span>
                            <span class="ticker-item">Piyasalarda hareketlilik: BIST 100 endeksi yeni zirveye yaklaştı.</span>
                            <span class="ticker-item">Meteoroloji Genel Müdürlüğü'nden hafta sonu için sağanak uyarısı.</span>
                            <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. HERO / MANŞET BÖLÜMÜ (SLIDER + YAN MANŞETLER) -->
        <section class="hero-section">
            <div class="hero-grid">
                
                <!-- Ana Manşet Slider (Sol 2/3) -->
                <div class="manset-slider">
                    <div class="slider-slides">
                        <?php
                        $manset_query = new WP_Query(array(
                            'posts_per_page'      => 5,
                            'ignore_sticky_posts' => 1,
                        ));

                        $manset_count = 0;
                        if ($manset_query->have_posts()) :
                            while ($manset_query->have_posts()) : $manset_query->the_post();
                                $manset_count++;
                                $categories = get_the_category();
                                $cat_name = !empty($categories) ? $categories[0]->name : 'Gündem';
                                $cat_slug = !empty($categories) ? $categories[0]->slug : 'gundem';
                                $img_url  = haber_get_thumbnail_url(get_the_ID(), 'haber-manset', $cat_slug);
                                ?>
                                <article class="slider-slide <?php echo $manset_count === 1 ? 'active' : ''; ?>" data-index="<?php echo $manset_count - 1; ?>">
                                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                    <div class="slide-overlay">
                                        <span class="slide-category-badge"><?php echo esc_html($cat_name); ?></span>
                                        <h2 class="slide-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        <p class="slide-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                                    </div>
                                </article>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>

                    <!-- Slider Sayı Butonları (1, 2, 3, 4, 5) -->
                    <div class="slider-indicators">
                        <?php for ($i = 0; $i < max(1, $manset_count); $i++) : ?>
                            <button type="button" class="indicator-btn <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>" aria-label="Slayt <?php echo $i + 1; ?>">
                                <?php echo $i + 1; ?>
                            </button>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Yan Manşetler (Sağ 1/3) -->
                <div class="yan-manset">
                    <?php
                    $yan_query = new WP_Query(array(
                        'posts_per_page'      => 3,
                        'offset'              => 5,
                        'ignore_sticky_posts' => 1,
                    ));

                    if ($yan_query->have_posts()) :
                        while ($yan_query->have_posts()) : $yan_query->the_post();
                            $cats = get_the_category();
                            $cat_name = !empty($cats) ? $cats[0]->name : 'Gelişme';
                            $cat_slug = !empty($cats) ? $cats[0]->slug : 'gundem';
                            $img_url  = haber_get_thumbnail_url(get_the_ID(), 'haber-side', $cat_slug);
                            ?>
                            <div class="yan-manset-card">
                                <div class="yan-manset-thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                    </a>
                                </div>
                                <div class="yan-manset-content">
                                    <span class="yan-manset-cat"><?php echo esc_html($cat_name); ?></span>
                                    <h3 class="yan-manset-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

            </div>
        </section>

        <!-- 3. ANA İÇERİK DÜZENİ: KATEGORİ IZGARALARI + SİDEBAR -->
        <div class="main-content-layout">
            
            <!-- Sol Sütun: Kategori Blokları -->
            <div class="content-left-col">
                
                <!-- GÜNDEM BLOKU -->
                <section class="category-block">
                    <div class="section-title-wrap">
                        <h2 class="section-title"><i class="fa-solid fa-newspaper" style="color: var(--primary);"></i> Gündem</h2>
                        <a href="<?php echo esc_url(home_url('/category/gundem/')); ?>" class="section-link">Tümü <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="news-grid-2col">
                        <?php
                        $gundem_query = new WP_Query(array(
                            'category_name'  => 'gundem',
                            'posts_per_page' => 2,
                        ));

                        if ($gundem_query->have_posts()) :
                            while ($gundem_query->have_posts()) : $gundem_query->the_post();
                                ?>
                                <article class="news-card">
                                    <div class="news-card-thumb">
                                        <a href="<?php the_permalink(); ?>">
                                            <img src="<?php echo esc_url(haber_get_thumbnail_url(get_the_ID(), 'haber-grid', 'gundem')); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                        </a>
                                    </div>
                                    <div class="news-card-body">
                                        <div class="news-meta">
                                            <span class="category">Gündem</span>
                                            <span>&bull;</span>
                                            <span><i class="fa-regular fa-clock"></i> <?php echo get_the_date('j F Y'); ?></span>
                                        </div>
                                        <h3 class="news-card-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <p class="news-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></p>
                                        <div class="news-footer-meta">
                                            <span><i class="fa-regular fa-user"></i> <?php the_author(); ?></span>
                                            <span><i class="fa-regular fa-eye"></i> <?php echo haber_get_post_views(get_the_ID()); ?></span>
                                        </div>
                                    </div>
                                </article>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </section>

                <!-- TEKNOLOJİ BLOKU -->
                <section class="category-block">
                    <div class="section-title-wrap">
                        <h2 class="section-title"><i class="fa-solid fa-microchip" style="color: var(--primary);"></i> Teknoloji & Bilim</h2>
                        <a href="<?php echo esc_url(home_url('/category/teknoloji/')); ?>" class="section-link">Tümü <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="news-grid-2col">
                        <?php
                        $tekno_query = new WP_Query(array(
                            'category_name'  => 'teknoloji',
                            'posts_per_page' => 2,
                        ));

                        if ($tekno_query->have_posts()) :
                            while ($tekno_query->have_posts()) : $tekno_query->the_post();
                                ?>
                                <article class="news-card">
                                    <div class="news-card-thumb">
                                        <a href="<?php the_permalink(); ?>">
                                            <img src="<?php echo esc_url(haber_get_thumbnail_url(get_the_ID(), 'haber-grid', 'teknoloji')); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                        </a>
                                    </div>
                                    <div class="news-card-body">
                                        <div class="news-meta">
                                            <span class="category">Teknoloji</span>
                                            <span>&bull;</span>
                                            <span><i class="fa-regular fa-clock"></i> <?php echo get_the_date('j F Y'); ?></span>
                                        </div>
                                        <h3 class="news-card-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <p class="news-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></p>
                                        <div class="news-footer-meta">
                                            <span><i class="fa-regular fa-user"></i> <?php the_author(); ?></span>
                                            <span><i class="fa-regular fa-eye"></i> <?php echo haber_get_post_views(get_the_ID()); ?></span>
                                        </div>
                                    </div>
                                </article>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </section>

                <!-- EKONOMİ & FİNANS BLOKU -->
                <section class="category-block">
                    <div class="section-title-wrap">
                        <h2 class="section-title"><i class="fa-solid fa-chart-line" style="color: var(--primary);"></i> Ekonomi & Finans</h2>
                        <a href="<?php echo esc_url(home_url('/category/ekonomi/')); ?>" class="section-link">Tümü <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="news-grid-2col">
                        <?php
                        $eko_query = new WP_Query(array(
                            'category_name'  => 'ekonomi',
                            'posts_per_page' => 2,
                        ));

                        if ($eko_query->have_posts()) :
                            while ($eko_query->have_posts()) : $eko_query->the_post();
                                ?>
                                <article class="news-card">
                                    <div class="news-card-thumb">
                                        <a href="<?php the_permalink(); ?>">
                                            <img src="<?php echo esc_url(haber_get_thumbnail_url(get_the_ID(), 'haber-grid', 'ekonomi')); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                        </a>
                                    </div>
                                    <div class="news-card-body">
                                        <div class="news-meta">
                                            <span class="category">Ekonomi</span>
                                            <span>&bull;</span>
                                            <span><i class="fa-regular fa-clock"></i> <?php echo get_the_date('j F Y'); ?></span>
                                        </div>
                                        <h3 class="news-card-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <p class="news-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></p>
                                        <div class="news-footer-meta">
                                            <span><i class="fa-regular fa-user"></i> <?php the_author(); ?></span>
                                            <span><i class="fa-regular fa-eye"></i> <?php echo haber_get_post_views(get_the_ID()); ?></span>
                                        </div>
                                    </div>
                                </article>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </section>

                <!-- SPOR & KÜLTÜR-SANAT 2'Lİ TABLO -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                    <!-- Spor -->
                    <section class="category-block">
                        <div class="section-title-wrap">
                            <h2 class="section-title"><i class="fa-solid fa-futbol" style="color: var(--primary);"></i> Spor</h2>
                        </div>
                        <?php
                        $spor_query = new WP_Query(array('category_name' => 'spor', 'posts_per_page' => 1));
                        if ($spor_query->have_posts()) : while ($spor_query->have_posts()) : $spor_query->the_post();
                        ?>
                        <article class="news-card">
                            <div class="news-card-thumb" style="height: 160px;">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url(haber_get_thumbnail_url(get_the_ID(), 'haber-grid', 'spor')); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                </a>
                            </div>
                            <div class="news-card-body">
                                <h3 class="news-card-title" style="font-size: 14px;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p class="news-card-excerpt" style="font-size: 12px;"><?php echo wp_trim_words(get_the_excerpt(), 14, '...'); ?></p>
                            </div>
                        </article>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </section>

                    <!-- Kültür & Sanat -->
                    <section class="category-block">
                        <div class="section-title-wrap">
                            <h2 class="section-title"><i class="fa-solid fa-palette" style="color: var(--primary);"></i> Kültür-Sanat</h2>
                        </div>
                        <?php
                        $ks_query = new WP_Query(array('category_name' => 'kultur-sanat', 'posts_per_page' => 1));
                        if ($ks_query->have_posts()) : while ($ks_query->have_posts()) : $ks_query->the_post();
                        ?>
                        <article class="news-card">
                            <div class="news-card-thumb" style="height: 160px;">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url(haber_get_thumbnail_url(get_the_ID(), 'haber-grid', 'kultur-sanat')); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                </a>
                            </div>
                            <div class="news-card-body">
                                <h3 class="news-card-title" style="font-size: 14px;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p class="news-card-excerpt" style="font-size: 12px;"><?php echo wp_trim_words(get_the_excerpt(), 14, '...'); ?></p>
                            </div>
                        </article>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </section>
                </div>

            </div>

            <!-- Sağ Sütun: Kenar Çubuğu (Sidebar: Çok Okunanlar, Yazarlar, E-Bülten) -->
            <aside class="sidebar-right-col">
                
                <!-- ÇOK OKUNANLAR (POPULAR NEWS RANKING) -->
                <div class="sidebar-widget">
                    <div class="section-title-wrap">
                        <h3 class="section-title"><i class="fa-solid fa-fire" style="color: var(--primary);"></i> Çok Okunanlar</h3>
                    </div>
                    <div class="popular-list">
                        <?php
                        $popular_query = new WP_Query(array(
                            'posts_per_page'      => 5,
                            'meta_key'            => 'haber_post_views_count',
                            'orderby'             => 'meta_value_num',
                            'order'               => 'DESC',
                            'ignore_sticky_posts' => 1,
                        ));

                        // Eğer henüz okunma metası yoksa genel en son haberleri getir
                        if (!$popular_query->have_posts()) {
                            $popular_query = new WP_Query(array('posts_per_page' => 5));
                        }

                        $rank = 0;
                        if ($popular_query->have_posts()) :
                            while ($popular_query->have_posts()) : $popular_query->the_post();
                                $rank++;
                                $categories = get_the_category();
                                $cat_title = !empty($categories) ? $categories[0]->name : 'Gündem';
                                ?>
                                <article class="popular-item">
                                    <div class="popular-rank"><?php echo $rank; ?></div>
                                    <div class="popular-info">
                                        <span class="popular-cat"><?php echo esc_html($cat_title); ?></span>
                                        <h4 class="popular-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                        <div class="popular-views">
                                            <i class="fa-regular fa-eye"></i> <?php echo haber_get_post_views(get_the_ID()); ?> okunma
                                        </div>
                                    </div>
                                </article>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>

                <!-- YAZARLAR KÖŞESİ -->
                <div class="sidebar-widget">
                    <div class="section-title-wrap">
                        <h3 class="section-title"><i class="fa-solid fa-pen-nib" style="color: var(--primary);"></i> Köşe Yazarları</h3>
                    </div>
                    <div class="authors-list">
                        <div class="author-item">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&auto=format&fit=crop&q=80" alt="Prof. Dr. Ahmet Yılmaz" class="author-avatar" />
                            <div>
                                <h4 class="author-name">Prof. Dr. Ahmet Yılmaz</h4>
                                <p class="author-column-title">"Küresel Ekonomide Yeni Dengeler"</p>
                            </div>
                        </div>
                        <div class="author-item">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&auto=format&fit=crop&q=80" alt="Zeynep Kaya" class="author-avatar" />
                            <div>
                                <h4 class="author-name">Zeynep Kaya</h4>
                                <p class="author-column-title">"Yapay Zekâ ve İnsanlığın Geleceği"</p>
                            </div>
                        </div>
                        <div class="author-item">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=120&auto=format&fit=crop&q=80" alt="Murat Şahin" class="author-avatar" />
                            <div>
                                <h4 class="author-name">Murat Şahin</h4>
                                <p class="author-column-title">"Yeşil Dönüşüm ve Türkiye'nin Rotası"</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- E-BÜLTEN KUTUSU -->
                <div class="newsletter-box">
                    <i class="fa-solid fa-envelope-open-text" style="font-size: 32px; margin-bottom: 10px; color: #fca5a5;"></i>
                    <h3>Haberleri Kaçırma!</h3>
                    <p>Önemli manşetler ve son dakika duyuruları her akşam e-posta kutunda.</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Aboneliğiniz tamamlandı!');">
                        <input type="email" placeholder="E-posta adresinizi girin" required />
                        <button type="submit"><i class="fa-solid fa-paper-plane"></i> Abone Ol</button>
                    </form>
                </div>

            </aside>

        </div>

    </div>

    <!-- 4. VURGU BANDI: ÖZEL DOSYALAR / DÜNYA & MAGAZİN -->
    <section class="highlight-strip-section">
        <div class="container">
            <div class="section-title-wrap" style="border-color: #334155;">
                <h3 class="section-title"><i class="fa-solid fa-camera" style="color: var(--primary);"></i> Özel Dosyalar & Objektif</h3>
            </div>
            <div class="highlight-grid">
                <?php
                $highlight_query = new WP_Query(array(
                    'posts_per_page' => 4,
                    'category_name'  => 'dunya,magazin,kultur-sanat',
                ));

                if ($highlight_query->have_posts()) :
                    while ($highlight_query->have_posts()) : $highlight_query->the_post();
                        $cats = get_the_category();
                        $cat_name = !empty($cats) ? $cats[0]->name : 'Özel';
                        $cat_slug = !empty($cats) ? $cats[0]->slug : 'dunya';
                        $img = haber_get_thumbnail_url(get_the_ID(), 'haber-grid', $cat_slug);
                        ?>
                        <article class="highlight-card">
                            <img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                            <div class="overlay">
                                <span class="h-tag"><?php echo esc_html($cat_name); ?></span>
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
