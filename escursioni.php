<?php
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Escursioni Giornaliere in E-Bike sull\'Etna e Nebrodi | ' . SITE_NAME;
$pageDescription = 'Scopri le migliori escursioni giornaliere in e-bike in Sicilia orientale. Percorsi guidati sull\'Etna, nei boschi dei Nebrodi e degustazioni enogastronomiche.';

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/navbar.php';

$dayTours = array_filter($tours, function($t) { return $t['type'] === 'escursione'; });
?>

<!-- Page Header Banner -->
<section style="background: linear-gradient(rgba(15, 44, 48, 0.85), rgba(15, 44, 48, 0.95)), url('<?= BASE_URL ?>/assets/img/gallery/summit.jpg') center/cover no-repeat; padding: 8.5rem 0 4rem 0; color: var(--color-white); text-align: center;">
    <div class="container">
        <span class="badge badge-accent" style="margin-bottom: 0.8rem;">
            <i class="fa-solid fa-sun"></i> <?= t('nav_excursions') ?>
        </span>
        <h1 style="font-size: clamp(2.2rem, 4vw, 3.2rem); color: var(--color-white); margin-bottom: 1rem;">
            <?= CURRENT_LANG === 'en' ? 'Day E-Bike Excursions in Sicily' : 'Escursioni Giornaliere in E-Bike' ?>
        </h1>
        <p style="font-size: 1.15rem; color: rgba(255, 255, 255, 0.85); max-width: 700px; margin: 0 auto 2rem auto;">
            <?= CURRENT_LANG === 'en' ? 'Half-day and full-day guided e-bike rides through volcanic craters, centuries-old beech forests and historic wineries.' : 'Avventure da mezza giornata o giornata intera tra i crateri dell\'Etna, le faggete dei Nebrodi e antiche cantine vulcaniche.' ?>
        </p>
    </div>
</section>

<!-- Escursioni Catalog -->
<section class="section-spacing" x-data="{
    filterArea: 'all',
    filterDifficulty: 'all',
    
    match(tour) {
        let areaMatch = (this.filterArea === 'all' || tour.area_tag === this.filterArea);
        return areaMatch;
    }
}">
    <div class="container">
        <!-- Filter Toolbar -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: var(--color-white); padding: 1.2rem 1.6rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); border: 1px solid var(--color-gray-200);">
            <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;">
                <span style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: var(--color-gray-500); margin-right: 0.4rem;">Filtra per Area:</span>
                <button class="filter-pill btn-sm" :class="{ 'active': filterArea === 'all' }" @click="filterArea = 'all'">Tutte le Aree</button>
                <button class="filter-pill btn-sm" :class="{ 'active': filterArea === 'etna' }" @click="filterArea = 'etna'">Etna Nord & Crateri</button>
                <button class="filter-pill btn-sm" :class="{ 'active': filterArea === 'nebrodi' }" @click="filterArea = 'nebrodi'">Parco dei Nebrodi</button>
            </div>
            
            <span style="font-size: 0.9rem; color: var(--color-gray-500); font-weight: 600;">
                <?= count($dayTours) ?> Escursioni Disponibili
            </span>
        </div>

        <div class="tours-grid">
            <?php foreach ($dayTours as $tour): ?>
                <div x-show="match(<?= htmlspecialchars(json_encode($tour)) ?>)" x-transition>
                    <?php require BASE_PATH . '/includes/tour-card.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
