<?php
/**
 * Haber Portalı - 404.php (Sayfa Bulunamadı)
 */

get_header(); ?>

<main class="site-main" style="padding: 60px 0;">
    <div class="container" style="text-align: center; max-width: 600px;">
        <div style="font-size: 84px; font-weight: 900; color: var(--primary); line-height: 1;">404</div>
        <h1 style="font-size: 24px; margin: 15px 0 10px; color: var(--dark);">Aradığınız Sayfa veya Haber Bulunamadı</h1>
        <p style="color: var(--text-muted); margin-bottom: 25px;">Ulaşmaya çalıştığınız haber yayından kaldırılmış, taşınmış veya adresi değişmiş olabilir.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" style="display: inline-block; padding: 12px 24px; background: var(--primary); color: #fff; border-radius: 6px; font-weight: 700;">
            <i class="fa-solid fa-house"></i> Ana Sayfaya Dön
        </a>
    </div>
</main>

<?php get_footer(); ?>
