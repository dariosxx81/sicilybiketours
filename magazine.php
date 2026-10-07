<?php
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Sicily Bike Magazine & Guide | Consigli, Itinerari e Segreti dell\'E-Bike in Sicilia';
$pageDescription = 'Articoli, guide e approfondimenti sul cicloturismo in Sicilia: come pedalare sull\'Etna, itinerari nei Nebrodi e consigli per le Isole Eolie.';

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/navbar.php';
?>

<!-- Header Banner -->
<section style="background: linear-gradient(rgba(15, 44, 48, 0.85), rgba(15, 44, 48, 0.95)), url('<?= BASE_URL ?>/assets/img/gallery/summit.jpg') center/cover no-repeat; padding: 8.5rem 0 4rem 0; color: var(--color-white); text-align: center;">
    <div class="container">
        <span class="badge badge-accent" style="margin-bottom: 0.8rem;">
            <i class="fa-solid fa-newspaper"></i> <?= t('nav_magazine') ?>
        </span>
        <h1 style="font-size: clamp(2.2rem, 4vw, 3.2rem); color: var(--color-white); margin-bottom: 1rem;">
            <?= t('magazine_title') ?>
        </h1>
        <p style="font-size: 1.15rem; color: rgba(255, 255, 255, 0.85); max-width: 700px; margin: 0 auto;">
            <?= t('magazine_subtitle') ?>
        </p>
    </div>
</section>

<!-- Magazine Articles Grid -->
<section class="section-spacing" style="background: var(--color-gray-50);">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2.2rem;">
            <?php foreach ($articles as $art): ?>
                <?php
                $artTitle = CURRENT_LANG === 'en' ? ($art['title_en'] ?? $art['title']) : $art['title'];
                $artExcerpt = CURRENT_LANG === 'en' ? ($art['excerpt_en'] ?? $art['excerpt']) : $art['excerpt'];
                $artCategory = CURRENT_LANG === 'en' ? ($art['category_en'] ?? $art['category']) : $art['category'];
                $artDate = CURRENT_LANG === 'en' ? ($art['date_en'] ?? $art['date']) : $art['date'];
                $artLink = BASE_URL . '/articolo.php?slug=' . urlencode($art['slug']);
                ?>
                <div class="tour-card" style="display: flex; flex-direction: column;">
                    <div class="tour-card-media" style="height: 220px;">
                        <a href="<?= $artLink ?>">
                            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($art['image']) ?>" alt="<?= htmlspecialchars($artTitle) ?>" loading="lazy">
                        </a>
                        <div class="tour-card-badges">
                            <span class="badge badge-dark">
                                <i class="fa-solid fa-tag"></i> <?= htmlspecialchars($artCategory) ?>
                            </span>
                        </div>
                    </div>

                    <div class="tour-card-body" style="flex: 1; display: flex; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--color-gray-500); margin-bottom: 0.5rem;">
                            <span><i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($artDate) ?></span>
                            <span><i class="fa-regular fa-clock"></i> <?= htmlspecialchars($art['read_time']) ?></span>
                        </div>

                        <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; line-height: 1.35;">
                            <a href="<?= $artLink ?>" style="color: inherit;">
                                <?= htmlspecialchars($artTitle) ?>
                            </a>
                        </h3>

                        <p style="font-size: 0.92rem; color: var(--color-gray-600); margin-bottom: 1.5rem; flex: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6;">
                            <?= htmlspecialchars($artExcerpt) ?>
                        </p>

                        <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--color-gray-100); padding-top: 1rem;">
                            <span style="font-size: 0.85rem; font-weight: 700; color: var(--color-primary-dark);">
                                <i class="fa-solid fa-pen-nib" style="color: var(--color-primary);"></i> <?= htmlspecialchars($art['author']) ?>
                            </span>
                            <a href="<?= $artLink ?>" class="btn btn-outline-primary btn-sm">
                                <?= t('magazine_read_more') ?> <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
