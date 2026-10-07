<?php
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Crea il Tuo Tour in E-Bike su Misura in Sicilia | ' . SITE_NAME;
$pageDescription = 'Configura online la tua vacanza in bicicletta elettrica personalizzata: scegli le tappe tra Etna, Nebrodi, Eolie, Alcantara e Val di Noto, durata e servizi extra.';

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/navbar.php';
?>

<!-- Header Banner -->
<section style="background: linear-gradient(rgba(15, 44, 48, 0.85), rgba(15, 44, 48, 0.95)), url('<?= BASE_URL ?>/assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-113.jpg') center/cover no-repeat; padding: 8.5rem 0 4rem 0; color: var(--color-white); text-align: center;">
    <div class="container">
        <span class="badge badge-accent" style="margin-bottom: 0.8rem;">
            <i class="fa-solid fa-sliders"></i> <?= t('nav_custom') ?>
        </span>
        <h1 style="font-size: clamp(2.2rem, 4vw, 3.2rem); color: var(--color-white); margin-bottom: 1rem;">
            <?= CURRENT_LANG === 'en' ? 'Build Your Tailor-Made E-Bike Tour' : 'Crea il Tuo Tour in E-Bike su Misura' ?>
        </h1>
        <p style="font-size: 1.15rem; color: rgba(255, 255, 255, 0.85); max-width: 700px; margin: 0 auto 2rem auto;">
            <?= CURRENT_LANG === 'en' ? 'Tell us your dreams, dates and preferred pace. We will craft a 100% personalized itinerary in Sicily for you and your group.' : 'Dicci cosa desideri vedere, i tuoi giorni disponibili e il tuo ritmo preferito. Costruiremo un viaggio in bicicletta unico e personalizzato al 100%.' ?>
        </p>
    </div>
</section>

<!-- Full Tour Configurator -->
<section class="section-spacing" style="background: var(--color-gray-50);">
    <div class="container">
        <?php require_once BASE_PATH . '/includes/custom-tour-builder.php'; ?>
    </div>
</section>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
