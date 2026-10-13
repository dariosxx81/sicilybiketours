<?php
/**
 * SICILY BIKE TOURS - Tour Card Component
 * Parametri attesi: $tour (array dal catalogo $tours)
 */
if (!isset($tour)) return;

$title = CURRENT_LANG === 'en' ? ($tour['title_en'] ?? $tour['title']) : $tour['title'];
$subtitle = CURRENT_LANG === 'en' ? ($tour['subtitle_en'] ?? $tour['subtitle']) : $tour['subtitle'];
$duration = CURRENT_LANG === 'en' ? ($tour['duration_en'] ?? $tour['duration']) : $tour['duration'];
$difficulty = CURRENT_LANG === 'en' ? ($tour['difficulty_en'] ?? $tour['difficulty']) : $tour['difficulty'];
$category = CURRENT_LANG === 'en' ? ($tour['category_en'] ?? $tour['category']) : $tour['category'];
$detailUrl = BASE_URL . '/tour-dettaglio.php?slug=' . urlencode($tour['slug']);
?>
<div class="tour-card" 
     data-category="<?= htmlspecialchars($tour['type']) ?>" 
     data-area="<?= htmlspecialchars($tour['area_tag']) ?>"
     x-show="typeof activeCategory === 'undefined' || ((activeCategory === 'all' || activeCategory === '<?= $tour['type'] ?>') && (activeArea === 'all' || activeArea === '<?= $tour['area_tag'] ?>'))"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 transform scale-95"
     x-transition:enter-end="opacity-100 transform scale-100">
    <div class="tour-card-media">
        <a href="<?= $detailUrl ?>">
            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($tour['image']) ?>" alt="<?= htmlspecialchars($title) ?>" loading="lazy">
        </a>
        
        <div class="tour-card-badges">
            <span class="badge badge-dark">
                <i class="fa-solid fa-clock"></i> <?= htmlspecialchars($duration) ?>
            </span>
            <?php if (!empty($tour['category'])): ?>
                <span class="badge badge-accent" style="font-weight: 700;">
                    <i class="fa-solid fa-tag"></i> <?= htmlspecialchars($tour['category']) ?>
                </span>
            <?php endif; ?>
            <?php if (!empty($tour['featured'])): ?>
                <span class="badge badge-volcano" style="background: var(--color-volcano); color: #fff;">
                    <i class="fa-solid fa-star"></i> Top Choice
                </span>
            <?php endif; ?>
        </div>

        <div class="tour-card-price-tag">
            <?= t('tour_price_from') ?> <span>€<?= htmlspecialchars($tour['price']) ?></span>
        </div>
    </div>

    <div class="tour-card-body">
        <div class="tour-card-area">
            <i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($tour['area']) ?>
        </div>

        <h3 class="tour-card-title">
            <a href="<?= $detailUrl ?>" style="color: inherit;">
                <?= htmlspecialchars($title) ?>
            </a>
        </h3>

        <p class="tour-card-desc">
            <?= htmlspecialchars($subtitle) ?>
        </p>

        <div class="tour-specs-strip">
            <div class="tour-spec-item">
                <i class="fa-solid fa-route tour-spec-icon"></i>
                <span class="tour-spec-val"><?= htmlspecialchars($tour['distance']) ?></span>
                <span class="tour-spec-lbl"><?= t('tour_distance') ?></span>
            </div>
            <div class="tour-spec-item">
                <i class="fa-solid fa-mountain tour-spec-icon"></i>
                <span class="tour-spec-val"><?= htmlspecialchars($tour['elevation']) ?></span>
                <span class="tour-spec-lbl"><?= t('tour_elevation') ?></span>
            </div>
            <div class="tour-spec-item">
                <i class="fa-solid fa-gauge-high tour-spec-icon"></i>
                <span class="tour-spec-val" style="font-size: 0.78rem;"><?= htmlspecialchars($difficulty) ?></span>
                <span class="tour-spec-lbl"><?= t('tour_difficulty') ?></span>
            </div>
        </div>

        <div class="tour-card-footer" style="display: flex; gap: 0.6rem; align-items: stretch;">
            <a href="<?= $detailUrl ?>" class="btn btn-outline-primary" style="flex: 1; height: 42px; min-height: 42px; display: inline-flex; align-items: center; justify-content: center; padding: 0 0.6rem; font-size: 0.88rem; white-space: nowrap;">
                <i class="fa-solid fa-circle-info"></i> <?= t('tour_details') ?>
            </a>
            <button class="btn btn-accent" style="flex: 1; height: 42px; min-height: 42px; display: inline-flex; align-items: center; justify-content: center; padding: 0 0.6rem; font-size: 0.88rem; white-space: nowrap;" @click="openBooking(<?= htmlspecialchars(json_encode([
                'id' => $tour['id'],
                'slug' => $tour['slug'],
                'title' => $title,
                'price' => $tour['price'],
                'duration' => $duration
            ])) ?>)">
                <i class="fa-solid fa-calendar-check"></i> <?= t('tour_book') ?>
            </button>
        </div>
    </div>
</div>
