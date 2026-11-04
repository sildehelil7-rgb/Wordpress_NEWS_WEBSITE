<?php
/**
 * Haber Portalı - category.php / archive.php
 */

get_header(); 
$cat_obj = get_queried_object();
$cat_slug = !empty($cat_obj->slug) ? $cat_obj->slug : 'gundem';
?>

<main class="site-main" style="padding: 25px 0;">
    <div class="container">
        
        <!-- Kategori Başlığı -->
        <div class="archive-header">
            <h1><i class="fa-solid fa-folder-open" style="color: var(--primary);"></i> <?php single_cat_title(); ?> Haberleri</h1>
            <?php if (category_description()) : ?>
                <p><?php echo category_description(); ?></p>
            <?php else : ?>
                <p><?php single_cat_title(); ?> kategorisindeki en güncel ve son dakika haberleri, gelişmeler ve uzman yorumları.</p>
            <?php endif; ?>
        </div>

        <div class="main-content-layout">
            
            <div class="content-left-col">
                <?php if (have_posts()) : ?>
                    <div class="news-grid-2col">
                        <?php while (have_posts()) : the_post(); ?>
                            <article class="news-card">
                                <div class="news-card-thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url(haber_get_thumbnail_url(get_the_ID(), 'haber-grid', $cat_slug)); ?>" alt="<?php the_title_attribute(); ?>" />
                                    </a>
                                </div>
                                <div class="news-card-body">
                                    <div class="news-meta">
                                        <span class="category"><?php single_cat_title(); ?></span>
                                        <span>&bull;</span>
                                        <span><i class="fa-regular fa-clock"></i> <?php echo get_the_date('j F Y'); ?></span>
                                    </div>
                                    <h2 class="news-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    <p class="news-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></p>
                                    <div class="news-footer-meta">
                                        <span><i class="fa-regular fa-user"></i> <?php the_author(); ?></span>
                                        <span><i class="fa-regular fa-eye"></i> <?php echo haber_get_post_views(get_the_ID()); ?></span>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <div class="pagination">
                        <?php
                        echo paginate_links(array(
                            'prev_text' => '<i class="fa-solid fa-chevron-left"></i> Önceki',
                            'next_text' => 'Sonraki <i class="fa-solid fa-chevron-right"></i>',
                        ));
                        ?>
                    </div>

                <?php else : ?>
                    <div style="background: #fff; padding: 30px; border-radius: 8px; text-align: center;">
                        <i class="fa-solid fa-newspaper" style="font-size: 40px; color: #cbd5e1; margin-bottom: 15px;"></i>
                        <h3>Bu kategoride henüz haber bulunmamaktadır.</h3>
                        <p style="color: #64748b; margin-top: 8px;">Yeni haberler eklendikçe burada listelenecektir.</p>
                        <a href="<?php echo esc_url(home_url('/')); ?>" style="display: inline-block; margin-top: 15px; padding: 8px 18px; background: var(--primary); color: #fff; border-radius: 4px; font-weight: 700;">Anasayfaya Dön</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Kenar Çubuğu (Sidebar) -->
            <aside class="sidebar-right-col">
                <div class="sidebar-widget">
                    <div class="section-title-wrap">
                        <h3 class="section-title"><i class="fa-solid fa-fire" style="color: var(--primary);"></i> En Çok Okunanlar</h3>
                    </div>
                    <div class="popular-list">
                        <?php
                        $cat_popular = new WP_Query(array('posts_per_page' => 5));
                        $rk = 0;
                        if ($cat_popular->have_posts()) : while ($cat_popular->have_posts()) : $cat_popular->the_post();
                            $rk++;
                        ?>
                            <article class="popular-item">
                                <div class="popular-rank"><?php echo $rk; ?></div>
                                <div class="popular-info">
                                    <h4 class="popular-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <div class="popular-views"><i class="fa-regular fa-clock"></i> <?php echo get_the_date('H:i'); ?></div>
                                </div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </div>
                </div>

                <div class="newsletter-box">
                    <h3>Son Dakika Bildirimleri</h3>
                    <p>Önemli gelişmeler anında telefonunuza ve mailinize gelsin.</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Kaydınız alındı!');">
                        <input type="email" placeholder="E-posta adresiniz" required />
                        <button type="submit">Takip Et</button>
                    </form>
                </div>
            </aside>

        </div>

    </div>
</main>

<?php get_footer(); ?>
