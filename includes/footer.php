<!-- Main Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand & Mission -->
            <div class="footer-col">
                <img src="<?= BASE_URL ?>/assets/img/logo/logo-light.png" alt="<?= SITE_NAME ?>" style="height: 48px; margin-bottom: 1.2rem;">
                <p style="font-size: 0.92rem; line-height: 1.6; color: rgba(255, 255, 255, 0.75); margin-bottom: 1.5rem;">
                    <?= t('footer_about') ?>
                </p>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="<?= INSTAGRAM_URL ?>" target="_blank" class="btn btn-outline-white btn-icon-round" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="<?= FACEBOOK_URL ?>" target="_blank" class="btn btn-outline-white btn-icon-round" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://wa.me/<?= WA_NUMBER ?>" target="_blank" class="btn btn-outline-white btn-icon-round" aria-label="WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>

<?php
$footerMenusFile = BASE_PATH . '/data/menus.json';
$footerMenuData = file_exists($footerMenusFile) ? json_decode(file_get_contents($footerMenusFile), true) ?: [] : [];
$footerQuickLinks = $footerMenuData['footer_quick_links'] ?? [
    ['title_it' => 'Home', 'url' => ''],
    ['title_it' => 'Chi Siamo', 'url' => 'chi-siamo.php'],
    ['title_it' => 'Escursioni Giornaliere', 'url' => 'escursioni.php'],
    ['title_it' => 'Tour Itineranti', 'url' => 'tour.php'],
    ['title_it' => 'Tour su Misura', 'url' => 'personalizza-tour.php'],
    ['title_it' => 'Contatti & Info', 'url' => 'contatti.php']
];
$footerDestinations = $footerMenuData['footer_destinations'] ?? [
    ['title_it' => 'Vulcano Etna & Crateri', 'url' => 'escursioni.php?area=etna'],
    ['title_it' => 'Parco dei Monti Nebrodi', 'url' => 'escursioni.php?area=nebrodi'],
    ['title_it' => 'Megaliti dell\'Argimusco', 'url' => 'tour.php?area=nebrodi'],
    ['title_it' => 'Isole Eolie Bici & Barca', 'url' => 'tour.php?area=isole'],
    ['title_it' => 'Val di Noto & Città Barocche', 'url' => 'tour.php?area=barocco'],
    ['title_it' => 'Strada del Vino Etna DOC', 'url' => 'escursioni.php?area=etna']
];
?>
            <!-- Quick Links -->
            <div class="footer-col">
                <h5><?= t('footer_quick_links') ?></h5>
                <ul class="footer-links">
                    <?php foreach ($footerQuickLinks as $fLink): 
                        $fUrl = $fLink['url'] ?? '';
                        $fHref = str_starts_with($fUrl, 'http') ? $fUrl : (empty($fUrl) ? BASE_URL . '/' : BASE_URL . '/' . ltrim($fUrl, '/'));
                        $fTitle = $fLink['title_it'] ?? '';
                    ?>
                        <li><a href="<?= htmlspecialchars($fHref) ?>"><?= htmlspecialchars($fTitle) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Destinations -->
            <div class="footer-col">
                <h5><?= t('footer_destinations') ?></h5>
                <ul class="footer-links">
                    <?php foreach ($footerDestinations as $fDest): 
                        $dUrl = $fDest['url'] ?? '';
                        $dHref = str_starts_with($dUrl, 'http') ? $dUrl : (empty($dUrl) ? BASE_URL . '/' : BASE_URL . '/' . ltrim($dUrl, '/'));
                        $dTitle = $fDest['title_it'] ?? '';
                    ?>
                        <li><a href="<?= htmlspecialchars($dHref) ?>"><?= htmlspecialchars($dTitle) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Contact & Office -->
            <div class="footer-col">
                <h5><?= t('footer_contact_info') ?></h5>
                <ul class="footer-links" style="color: rgba(255, 255, 255, 0.85); font-size: 0.92rem;">
                    <li style="display: flex; gap: 0.6rem; align-items: flex-start;">
                        <i class="fa-solid fa-location-dot" style="color: var(--color-accent); margin-top: 0.25rem;"></i>
                        <span><?= CONTACT_ADDRESS ?></span>
                    </li>
                    <li style="display: flex; gap: 0.6rem; align-items: center;">
                        <i class="fa-solid fa-phone" style="color: var(--color-accent);"></i>
                        <a href="tel:<?= str_replace(' ', '', CONTACT_PHONE) ?>"><?= CONTACT_PHONE ?></a>
                    </li>
                    <li style="display: flex; gap: 0.6rem; align-items: center;">
                        <i class="fa-solid fa-envelope" style="color: var(--color-accent);"></i>
                        <a href="mailto:<?= CONTACT_EMAIL ?>"><?= CONTACT_EMAIL ?></a>
                    </li>
                    <li style="display: flex; gap: 0.6rem; align-items: center;">
                        <i class="fa-brands fa-whatsapp" style="color: var(--color-accent);"></i>
                        <a href="https://wa.me/<?= WA_NUMBER ?>" target="_blank">Chat WhatsApp Diretta</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <div>
                &copy; <?= date('Y') ?> <?= SITE_NAME ?>. <?= t('footer_rights') ?>
            </div>
            <div style="display: flex; gap: 1.5rem;">
                <a href="https://www.iubenda.com/privacy-policy/22750170" target="_blank">Privacy Policy</a>
                <a href="https://www.iubenda.com/privacy-policy/22750170/cookie-policy.pdf" target="_blank">Cookie Policy</a>
                <a href="<?= BASE_URL ?>/admin/">Area Gestione</a>
            </div>
        </div>
    </div>
</footer>

<!-- Floating WhatsApp Beacon -->
<a href="https://wa.me/<?= WA_NUMBER ?>?text=<?= urlencode('Ciao Sicily Bike Tours! Vorrei informazioni sui vostri tour in e-bike.') ?>" target="_blank" class="floating-whatsapp" aria-label="WhatsApp">
    <i class="fa-brands fa-whatsapp" style="font-size: 2rem;"></i>
</a>

<!-- Booking & Quick Quote Modal -->
<?php require_once BASE_PATH . '/includes/booking-modal.php'; ?>

</body>
</html>
