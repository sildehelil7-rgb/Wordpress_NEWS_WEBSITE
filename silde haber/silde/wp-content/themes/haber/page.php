<?php
/**
 * Haber Portalı - page.php (Statik Sayfalar: Hakkımızda, Künye, İletişim vb.)
 */

get_header(); ?>

<main class="site-main" style="padding: 30px 0;">
    <div class="container" style="max-width: 900px;">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article class="single-post-wrapper">
                <h1 class="single-title" style="margin-bottom: 20px;"><?php the_title(); ?></h1>
                <div class="post-content-body">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; endif; ?>
    </div>
</main>

<?php get_footer(); ?>
