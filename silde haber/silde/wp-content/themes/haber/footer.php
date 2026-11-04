<?php
/**
 * Haber Portalı - footer.php
 */
?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" style="color: #fff; margin-bottom: 15px;">
                    <i class="fa-solid fa-newspaper" style="color: var(--primary);"></i>
                    <span>HABER</span><span class="highlight">PORTALI</span>
                </a>
                <p>
                    En son dakika haberleri, güncel siyaset, ekonomi, teknoloji, spor ve dünya gündemini tarafsız, ilkeli ve hızlı habercilik anlayışıyla aktaran dijital haber platformu.
                </p>
                <div style="display: flex; gap: 10px; margin-top: 15px;">
                    <a href="#" style="background: #1e293b; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 4px; color: #fff;"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#" style="background: #1e293b; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 4px; color: #fff;"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" style="background: #1e293b; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 4px; color: #fff;"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" style="background: #1e293b; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 4px; color: #fff;"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Kategoriler</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url(home_url('/category/gundem/')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i> Gündem</a></li>
                    <li><a href="<?php echo esc_url(home_url('/category/teknoloji/')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i> Teknoloji</a></li>
                    <li><a href="<?php echo esc_url(home_url('/category/ekonomi/')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i> Ekonomi</a></li>
                    <li><a href="<?php echo esc_url(home_url('/category/spor/')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i> Spor</a></li>
                    <li><a href="<?php echo esc_url(home_url('/category/dunya/')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i> Dünya</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Kurumsal</h4>
                <ul class="footer-links">
                    <li><a href="#"><i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i> Hakkımızda</a></li>
                    <li><a href="#"><i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i> Künye & İletişim</a></li>
                    <li><a href="#"><i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i> Yayın İlkeleri</a></li>
                    <li><a href="#"><i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i> Gizlilik ve Çerez Politikası</a></li>
                    <li><a href="#"><i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i> RSS Kaynağı</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Günün Özeti Bülteni</h4>
                <p>Türkiye ve dünyadan önemli gelişmeleri her sabah doğrudan gelen kutunuzda okuyun.</p>
                <form onsubmit="event.preventDefault(); alert('Bülten aboneliğiniz başarıyla kaydedildi!');" style="display: flex; gap: 6px;">
                    <input type="email" placeholder="E-posta adresiniz" required style="padding: 8px 12px; border-radius: 4px; border: 1px solid #334155; background: #1e293b; color: #fff; font-size: 13px; width: 100%;" />
                    <button type="submit" style="background: var(--primary); color: #fff; border: none; padding: 0 16px; border-radius: 4px; font-weight: 700; cursor: pointer;">Kayıt</button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            <div>
                &copy; <?php echo date('Y'); ?> <strong>Haber Portalı</strong>. Tüm Hakları Saklıdır. | Üniversite Bitirme Projesi (Final Submission)
            </div>
            <div>
                Öğrenci Projesi - WordPress Custom News Architecture
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
