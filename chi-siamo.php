<?php
require_once __DIR__ . '/config/config.php';

$aboutFile = BASE_PATH . '/data/about.json';
$about = file_exists($aboutFile) ? json_decode(file_get_contents($aboutFile), true) ?: [] : [];

$pageTitle = $about['seo']['page_title'] ?? 'Chi Siamo | Sicily Bike Tours - La Passione di Mariella per la Sicilia in Bici';
$pageDescription = $about['seo']['meta_description'] ?? 'Scopri la storia di Mariella e del team di Sicily Bike Tours: guide cicloturistiche locali, escursioni autentiche in e-bike e amore per la nostra terra.';

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/navbar.php';

$headerBg = !empty($about['header']['bg_image']) ? $about['header']['bg_image'] : 'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-106.jpg';
$headerBadge = CURRENT_LANG === 'en' ? ($about['header']['badge_en'] ?? 'About Us') : ($about['header']['badge_it'] ?? t('nav_about'));
$headerTitle = CURRENT_LANG === 'en' ? ($about['header']['title_en'] ?? 'Who We Are & Our Passion') : ($about['header']['title_it'] ?? 'La Nostra Storia & la Passione per la Sicilia');
$headerSubtitle = CURRENT_LANG === 'en' ? ($about['header']['subtitle_en'] ?? 'Transforming a childhood love for nature and bicycles into unforgettable experiences across our island.') : ($about['header']['subtitle_it'] ?? 'Trasformare l\'amore per la natura e la bicicletta in avventure indimenticabili alla scoperta degli angoli più veri della Sicilia.');

$storyImg = !empty($about['story']['image']) ? $about['story']['image'] : 'assets/img/gallery/escursioni-in-bicicletta-sicilia-tour-in-bici-sicilia-escursioni-sulletna-escursioni-sui-nebrodi-escursioni-alcantara-58.jpg';
$storyBadgeNum = $about['story']['floating_badge_number'] ?? '100%';
$storyBadgeText = CURRENT_LANG === 'en' ? ($about['story']['floating_badge_text_en'] ?? 'Authentic Sicily, Certified Guides & Passion for Nature') : ($about['story']['floating_badge_text_it'] ?? 'Sicilia Autentica, Guide Certificate & Amore per il Territorio');
$storyTag = CURRENT_LANG === 'en' ? ($about['story']['tag_en'] ?? 'Our Mission') : ($about['story']['tag_it'] ?? 'La Nostra Missione');
$storyTitle = CURRENT_LANG === 'en' ? ($about['story']['title_en'] ?? 'Live Sicily, ride with us') : ($about['story']['title_it'] ?? 'Vivi la Sicilia, pedala con noi');
$storyP1 = $about['story']['paragraph_1_it'] ?? 'Mariella, fondatrice e appassionata ciclista locale, ha trasformato la sua passione in una realtà dedicata a viaggiatori provenienti da tutto il mondo. Insieme a un team di guide esperte del territorio, condividiamo i segreti dell\'isola con chi desidera conoscerla in modo autentico, lento e rispettoso.';
$storyP2 = $about['story']['paragraph_2_it'] ?? 'Ogni tour è curato nei minimi dettagli per offrirvi un\'esperienza sicura, ricca di emozioni e fuori dai classici percorsi di massa. Dalle creste laviche dell\'Etna ai borghi medievali dei Nebrodi e alle acque cristalline delle Isole Eolie, ogni pedalata è un\'opportunità per assaporare la storia, la cultura e l\'enogastronomia genuina della nostra terra.';
$valuesList = $about['story']['values'] ?? [];

$fleetTag = $about['fleet']['tag_it'] ?? 'Il Nostro Parco Bici';
$fleetTitle = $about['fleet']['title_it'] ?? 'E-Bike di Ultima Generazione';
$fleetSubtitle = $about['fleet']['subtitle_it'] ?? 'Comfort, potenza e affidabilità per ogni tipo di terreno: dalle piste vulcaniche alle strade panoramiche.';
$fleetItems = $about['fleet']['items'] ?? [];
?>

<!-- Header Banner -->
<section style="background: linear-gradient(rgba(15, 44, 48, 0.85), rgba(15, 44, 48, 0.95)), url('<?= BASE_URL ?>/<?= htmlspecialchars($headerBg) ?>') center/cover no-repeat; padding: 8.5rem 0 4rem 0; color: var(--color-white); text-align: center;">
    <div class="container">
        <span class="badge badge-accent" style="margin-bottom: 0.8rem;">
            <i class="fa-solid fa-heart"></i> <?= htmlspecialchars($headerBadge) ?>
        </span>
        <h1 style="font-size: clamp(2.2rem, 4vw, 3.2rem); color: var(--color-white); margin-bottom: 1rem;">
            <?= htmlspecialchars($headerTitle) ?>
        </h1>
        <p style="font-size: 1.15rem; color: rgba(255, 255, 255, 0.85); max-width: 700px; margin: 0 auto;">
            <?= htmlspecialchars($headerSubtitle) ?>
        </p>
    </div>
</section>

<!-- Story Section -->
<section class="section-spacing" style="background: var(--color-white);">
    <div class="container">
        <div class="about-story-grid">
            <div style="position: relative;">
                <div class="about-img-wrapper">
                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars($storyImg) ?>" alt="Mariella e le guide Sicily Bike Tours" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="about-badge-floating">
                    <div style="font-size: 2rem; font-weight: 800; color: var(--color-accent); line-height: 1;"><?= htmlspecialchars($storyBadgeNum) ?></div>
                    <div style="font-size: 0.88rem; margin-top: 0.3rem;"><?= htmlspecialchars($storyBadgeText) ?></div>
                </div>
            </div>

            <div>
                <span class="section-tag"><i class="fa-solid fa-seedling"></i> <?= htmlspecialchars($storyTag) ?></span>
                <h2 style="font-size: clamp(1.8rem, 3.5vw, 2.3rem); color: var(--color-primary-dark); margin-bottom: 1.4rem;">
                    <?= htmlspecialchars($storyTitle) ?>
                </h2>
                
                <p style="font-size: 1.05rem; color: var(--color-gray-700); margin-bottom: 1.2rem; line-height: 1.7;">
                    <?= nl2br(htmlspecialchars($storyP1)) ?>
                </p>

                <?php if (!empty($storyP2)): ?>
                    <p style="font-size: 1.05rem; color: var(--color-gray-700); margin-bottom: 1.5rem; line-height: 1.7;">
                        <?= nl2br(htmlspecialchars($storyP2)) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($valuesList)): ?>
                    <div class="about-values-grid">
                        <?php foreach ($valuesList as $vIdx => $val): ?>
                            <div style="background: var(--color-gray-50); padding: 1.2rem; border-radius: var(--radius-md); border-left: 4px solid <?= $vIdx % 2 === 0 ? 'var(--color-accent)' : 'var(--color-primary)' ?>;">
                                <strong style="display: block; font-size: 1.05rem; color: var(--color-primary-dark); margin-bottom: 0.3rem;">
                                    <?= htmlspecialchars($val['title_it'] ?? '') ?>
                                </strong>
                                <span style="font-size: 0.85rem; color: var(--color-gray-600);">
                                    <?= htmlspecialchars($val['desc_it'] ?? '') ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Bike Fleet Section -->
<section class="section-spacing" style="background: var(--color-gray-50);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-bicycle"></i> <?= htmlspecialchars($fleetTag) ?></span>
            <h2 class="section-title"><?= htmlspecialchars($fleetTitle) ?></h2>
            <p class="section-subtitle"><?= htmlspecialchars($fleetSubtitle) ?></p>
        </div>

        <?php if (!empty($fleetItems)): ?>
            <div class="fleet-grid">
                <?php foreach ($fleetItems as $item): ?>
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="fa-solid fa-<?= htmlspecialchars($item['icon'] ?? 'bicycle') ?>" style="font-size: 1.4rem;"></i>
                        </div>
                        <h4><?= htmlspecialchars($item['title_it'] ?? '') ?></h4>
                        <p><?= htmlspecialchars($item['desc_it'] ?? '') ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>

