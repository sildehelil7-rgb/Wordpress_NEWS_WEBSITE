<?php
/**
 * Haber Portalı - single.php (Haber Detay Sayfası)
 */

get_header();

// Okunma sayısını artır
if (have_posts()) {
    while (have_posts()) {
        the_post();
        haber_set_post_views(get_the_ID());
    }
}
rewind_posts();
?>

<main class="site-main" style="padding: 25px 0;">
    <div class="container">
        
        <?php if (have_posts()) : while (have_posts()) : the_post(); 
            $cats = get_the_category();
            $cat_name = !empty($cats) ? $cats[0]->name : 'Gündem';
            $cat_link = !empty($cats) ? get_category_link($cats[0]->term_id) : '#';
            $cat_slug = !empty($cats) ? $cats[0]->slug : 'gundem';
            $thumb_url = haber_get_thumbnail_url(get_the_ID(), 'large', $cat_slug);
        ?>

        <!-- Breadcrumb Gezintisi -->
        <nav class="post-breadcrumbs" aria-label="Gezinti">
            <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house"></i> Anasayfa</a>
            <span>&gt;</span>
            <a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a>
            <span>&gt;</span>
            <span><?php the_title(); ?></span>
        </nav>

        <div class="main-content-layout">
            
            <!-- Sol Kolon: Haber İçeriği -->
            <div class="content-left-col">
                <article class="single-post-wrapper">
                    
                    <div class="post-header-area">
                        <a href="<?php echo esc_url($cat_link); ?>" class="single-cat-badge"><?php echo esc_html($cat_name); ?></a>
                        <h1 class="single-title"><?php the_title(); ?></h1>
                        
                        <?php if (has_excerpt()) : ?>
                            <div class="single-lead">
                                <?php echo get_the_excerpt(); ?>
                            </div>
                        <?php endif; ?>

                        <div class="single-meta-bar">
                            <div class="meta-author">
                                <i class="fa-solid fa-circle-user" style="font-size: 20px; color: var(--primary);"></i>
                                <span><?php the_author(); ?></span>
                            </div>
                            <div class="meta-stats">
                                <span><i class="fa-regular fa-calendar"></i> <?php echo get_the_date('j F Y, H:i'); ?></span>
                                <span><i class="fa-regular fa-clock"></i> <?php echo haber_reading_time(get_the_ID()); ?></span>
                                <span><i class="fa-regular fa-eye"></i> <?php echo haber_get_post_views(get_the_ID()); ?> Okunma</span>
                            </div>
                        </div>
                    </div>

                    <!-- Öne Çıkan Görsel -->
                    <figure class="single-featured-image">
                        <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>" />
                        <figcaption><i class="fa-solid fa-camera"></i> Haber Fotoğrafı / Temsili Medya Arşivi</figcaption>
                    </figure>

                    <!-- Haber Metin Gövdesi -->
                    <div class="post-content-body">
                        <?php the_content(); ?>
                    </div>

                    <!-- Etiketler & Paylaş Butonları -->
                    <div class="post-tags-share">
                        <div class="post-tags">
                            <span style="font-size: 13px; font-weight: 700; color: var(--dark); margin-right: 5px;"><i class="fa-solid fa-tags"></i> Etiketler:</span>
                            <?php
                            $tags = get_the_tags();
                            if ($tags) {
                                foreach ($tags as $tag) {
                                    echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="post-tag">#' . esc_html($tag->name) . '</a>';
                                }
                            } else {
                                echo '<span class="post-tag">#Haber</span><span class="post-tag">#' . esc_html($cat_name) . '</span><span class="post-tag">#Gündem</span>';
                            }
                            ?>
                        </div>

                        <div class="post-share">
                            <span>Paylaş:</span>
                            <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title()); ?>&url=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="share-btn tw"><i class="fa-brands fa-x-twitter"></i> X</a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="share-btn fb"><i class="fa-brands fa-facebook-f"></i> Paylaş</a>
                            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="share-btn wa"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                        </div>
                    </div>

                    <!-- İlgili Haberler (Related Posts) -->
                    <div style="margin-top: 40px; padding-top: 25px; border-top: 2px solid var(--gray-200);">
                        <h3 class="section-title" style="margin-bottom: 20px;"><i class="fa-solid fa-layer-group" style="color: var(--primary);"></i> İlgili Diğer Haberler</h3>
                        <div class="news-grid-2col">
                            <?php
                            $related_query = new WP_Query(array(
                                'category__in'   => wp_get_post_categories(get_the_ID()),
                                'post__not_in'   => array(get_the_ID()),
                                'posts_per_page' => 2,
                            ));

                            if ($related_query->have_posts()) :
                                while ($related_query->have_posts()) : $related_query->the_post();
                                    $rel_cats = get_the_category();
                                    $rel_slug = !empty($rel_cats) ? $rel_cats[0]->slug : 'gundem';
                                    ?>
                                    <div class="news-card">
                                        <div class="news-card-thumb" style="height: 140px;">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php echo esc_url(haber_get_thumbnail_url(get_the_ID(), 'haber-grid', $rel_slug)); ?>" alt="<?php the_title_attribute(); ?>" />
                                            </a>
                                        </div>
                                        <div class="news-card-body" style="padding: 12px;">
                                            <h4 class="news-card-title" style="font-size: 14px;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        </div>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>

                </article>
            </div>

            <!-- Sağ Kolon: Sidebar -->
            <aside class="sidebar-right-col">
                <div class="sidebar-widget">
                    <div class="section-title-wrap">
                        <h3 class="section-title"><i class="fa-solid fa-fire" style="color: var(--primary);"></i> En Çok Okunanlar</h3>
                    </div>
                    <div class="popular-list">
                        <?php
                        $side_pop = new WP_Query(array(
                            'posts_per_page' => 5,
                            'post__not_in'   => array(get_the_ID()),
                        ));
                        $rk = 0;
                        if ($side_pop->have_posts()) : while ($side_pop->have_posts()) : $side_pop->the_post();
                            $rk++;
                            $c = get_the_category();
                            $cn = !empty($c) ? $c[0]->name : 'Haber';
                        ?>
                            <article class="popular-item">
                                <div class="popular-rank"><?php echo $rk; ?></div>
                                <div class="popular-info">
                                    <span class="popular-cat"><?php echo esc_html($cn); ?></span>
                                    <h4 class="popular-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <div class="popular-views"><i class="fa-regular fa-eye"></i> <?php echo haber_get_post_views(get_the_ID()); ?></div>
                                </div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </div>
                </div>

                <div class="newsletter-box">
                    <h3>Günün Manşetleri</h3>
                    <p>En güncel gelişmelerden haberdar olmak için bültenimize kaydolun.</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Kaydınız alındı!');">
                        <input type="email" placeholder="E-posta adresiniz" required />
                        <button type="submit">Takip Et</button>
                    </form>
                </div>
            </aside>

        </div>

        <?php endwhile; endif; ?>

    </div>
</main>

<?php get_footer(); ?>
