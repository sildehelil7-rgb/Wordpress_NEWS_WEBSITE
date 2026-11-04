<?php
/**
 * Haber Portalı - search.php (Arama Sonuçları)
 */

get_header(); ?>

<main class="site-main" style="padding: 25px 0;">
    <div class="container">
        
        <div class="archive-header">
            <h1><i class="fa-solid fa-magnifying-glass" style="color: var(--primary);"></i> Arama Sonuçları: "<?php echo get_search_query(); ?>"</h1>
            <p>Aradığınız kriterlere uygun haberler aşağıda listelenmiştir.</p>
        </div>

        <div class="main-content-layout">
            <div class="content-left-col">
                <?php if (have_posts()) : ?>
                    <div class="news-grid-2col">
                        <?php while (have_posts()) : the_post(); 
                            $cats = get_the_category();
                            $cat_name = !empty($cats) ? $cats[0]->name : 'Haber';
                            $cat_slug = !empty($cats) ? $cats[0]->slug : 'gundem';
                        ?>
                            <article class="news-card">
                                <div class="news-card-thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url(haber_get_thumbnail_url(get_the_ID(), 'haber-grid', $cat_slug)); ?>" alt="<?php the_title_attribute(); ?>" />
                                    </a>
                                </div>
                                <div class="news-card-body">
                                    <div class="news-meta">
                                        <span class="category"><?php echo esc_html($cat_name); ?></span>
                                        <span>&bull;</span>
                                        <span><i class="fa-regular fa-clock"></i> <?php echo get_the_date('j F Y'); ?></span>
                                    </div>
                                    <h2 class="news-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    <p class="news-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></p>
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
                    <div style="background: #fff; padding: 40px; border-radius: 8px; text-align: center;">
                        <i class="fa-solid fa-circle-question" style="font-size: 45px; color: #cbd5e1; margin-bottom: 15px;"></i>
                        <h3>Aramanızla eşleşen haber bulunamadı.</h3>
                        <p style="color: #64748b; margin-top: 8px;">Lütfen farklı anahtar kelimeler deneyin veya ana sayfaya dönün.</p>
                    </div>
                <?php endif; ?>
            </div>

            <aside class="sidebar-right-col">
                <div class="sidebar-widget">
                    <div class="section-title-wrap">
                        <h3 class="section-title"><i class="fa-solid fa-fire" style="color: var(--primary);"></i> Popüler Haberler</h3>
                    </div>
                    <div class="popular-list">
                        <?php
                        $pop = new WP_Query(array('posts_per_page' => 5));
                        $rk = 0;
                        if ($pop->have_posts()) : while ($pop->have_posts()) : $pop->the_post();
                            $rk++;
                        ?>
                            <article class="popular-item">
                                <div class="popular-rank"><?php echo $rk; ?></div>
                                <div class="popular-info">
                                    <h4 class="popular-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                </div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </div>
                </div>
            </aside>
        </div>

    </div>
</main>

<?php get_footer(); ?>
