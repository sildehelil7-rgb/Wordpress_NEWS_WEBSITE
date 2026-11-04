<?php
/**
 * Haber Portalı - index.php
 */

get_header(); ?>

<main class="site-main" style="padding: 30px 0;">
    <div class="container">
        <div class="main-content-layout">
            <div class="content-left-col">
                <div class="section-title-wrap">
                    <h1 class="section-title">
                        <?php
                        if (is_home() && !is_front_page()) {
                            single_post_title();
                        } else {
                            echo 'Son Haberler ve Gelişmeler';
                        }
                        ?>
                    </h1>
                </div>

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
                                        <img src="<?php echo esc_url(haber_get_thumbnail_url(get_the_ID(), 'haber-grid', $cat_slug)); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
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
                            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
                        ));
                        ?>
                    </div>

                <?php else : ?>
                    <p>Henüz bu alanda yayınlanmış haber bulunmamaktadır.</p>
                <?php endif; ?>
            </div>

            <!-- Sağ Sütun -->
            <aside class="sidebar-right-col">
                <div class="sidebar-widget">
                    <div class="section-title-wrap">
                        <h3 class="section-title"><i class="fa-solid fa-fire" style="color: var(--primary);"></i> Öne Çıkanlar</h3>
                    </div>
                    <div class="popular-list">
                        <?php
                        $side_query = new WP_Query(array('posts_per_page' => 5));
                        $r = 0;
                        if ($side_query->have_posts()) : while ($side_query->have_posts()) : $side_query->the_post();
                            $r++;
                        ?>
                            <article class="popular-item">
                                <div class="popular-rank"><?php echo $r; ?></div>
                                <div class="popular-info">
                                    <h4 class="popular-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <div class="popular-views"><i class="fa-regular fa-clock"></i> <?php echo get_the_date('H:i'); ?></div>
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
