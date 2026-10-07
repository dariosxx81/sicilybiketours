<?php
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Tour Itineranti in E-Bike in Sicilia: Weekend e Viaggi di Più Giorni | ' . SITE_NAME;
$pageDescription = 'Tour cicloturistici itineranti in Sicilia di 2, 3, 4, 5 e 7 giorni. Viaggi guidati con e-bike e van di supporto tra Etna, Nebrodi, Isole Eolie e Val di Noto.';

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/navbar.php';

$multiTours = array_filter($tours, function($t) { return $t['type'] === 'tour'; });
?>

<!-- Page Header Banner -->
<section style="background: linear-gradient(rgba(15, 44, 48, 0.85), rgba(15, 44, 48, 0.95)), url('<?= BASE_URL ?>/assets/img/gallery/IMG-20251008-WA0031-scaled.jpg') center/cover no-repeat; padding: 8.5rem 0 4rem 0; color: var(--color-white); text-align: center;">
    <div class="container">
        <span class="badge badge-accent" style="margin-bottom: 0.8rem;">
            <i class="fa-solid fa-calendar-days"></i> <?= t('nav_tours') ?>
        </span>
        <h1 style="font-size: clamp(2.2rem, 4vw, 3.2rem); color: var(--color-white); margin-bottom: 1rem;">
            <?= CURRENT_LANG === 'en' ? 'Multi-Day E-Bike Tours in Sicily' : 'Tour Itineranti & Weekend in E-Bike' ?>
        </h1>
        <p style="font-size: 1.15rem; color: rgba(255, 255, 255, 0.85); max-width: 700px; margin: 0 auto 2rem auto;">
            <?= CURRENT_LANG === 'en' ? 'Immersive cycling journeys from 2 to 7 days with luggage transport, charming stays and local guides.' : 'Vacanze in bicicletta complete da 2 a 7 giorni con pernottamento in dimore di charme, furgone appoggio e trasporto bagagli.' ?>
        </p>
    </div>
</section>

<!-- Tours Catalog -->
<section class="section-spacing" x-data="{
    filterArea: 'all',
    
    match(tour) {
        let areaMatch = (this.filterArea === 'all' || tour.area_tag === this.filterArea);
        return areaMatch;
    }
}">
    <div class="container">
        <!-- Filter Toolbar -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: var(--color-white); padding: 1.2rem 1.6rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); border: 1px solid var(--color-gray-200);">
            <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;">
                <span style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: var(--color-gray-500); margin-right: 0.4rem;">Filtra Destinazione:</span>
                <button class="filter-pill btn-sm" :class="{ 'active': filterArea === 'all' }" @click="filterArea = 'all'">Tutte le Destinazioni</button>
                <button class="filter-pill btn-sm" :class="{ 'active': filterArea === 'etna' }" @click="filterArea = 'etna'">Etna & Dintorni</button>
                <button class="filter-pill btn-sm" :class="{ 'active': filterArea === 'nebrodi' }" @click="filterArea = 'nebrodi'">Nebrodi & Megaliti</button>
                <button class="filter-pill btn-sm" :class="{ 'active': filterArea === 'isole' }" @click="filterArea = 'isole'">Isole Eolie</button>
                <button class="filter-pill btn-sm" :class="{ 'active': filterArea === 'barocco' }" @click="filterArea = 'barocco'">Val di Noto</button>
            </div>
            
            <a href="<?= BASE_URL ?>/personalizza-tour.php" class="btn btn-accent btn-sm">
                <i class="fa-solid fa-sliders"></i> Richiedi Tour su Misura
            </a>
        </div>

        <div class="tours-grid">
            <?php foreach ($multiTours as $tour): ?>
                <div x-show="match(<?= htmlspecialchars(json_encode($tour)) ?>)" x-transition>
                    <?php require BASE_PATH . '/includes/tour-card.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
