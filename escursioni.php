<?php
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Escursioni Giornaliere in E-Bike sull\'Etna e Nebrodi | ' . SITE_NAME;
$pageDescription = 'Scopri le migliori escursioni giornaliere in e-bike in Sicilia orientale. Percorsi guidati sull\'Etna, nei boschi dei Nebrodi e degustazioni enogastronomiche.';

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/navbar.php';

$dayTours = array_filter($tours, function($t) { return ($t['type'] ?? '') === 'escursione'; });

$categoriesFile = BASE_PATH . '/data/categories.json';
$allCategories = file_exists($categoriesFile) ? json_decode(file_get_contents($categoriesFile), true) : [];
$excursionCategories = array_filter($allCategories, function($c) {
    return in_array($c['filter_type'] ?? 'all', ['all', 'escursione']);
});
usort($excursionCategories, function($a, $b) {
    return ($a['order'] ?? 10) <=> ($b['order'] ?? 10);
});

$initialCat = isset($_GET['cat']) ? $_GET['cat'] : 'all';
$initialArea = isset($_GET['area']) ? $_GET['area'] : 'all';
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

<!-- Escursioni Catalog & Dynamic Category Filters -->
<section class="section-spacing" x-data="{
    filterCat: '<?= htmlspecialchars($initialCat) ?>',
    filterArea: '<?= htmlspecialchars($initialArea) ?>',
    
    init() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('cat')) this.filterCat = urlParams.get('cat');
        if (urlParams.get('area')) this.filterArea = urlParams.get('area');
    },

    setCat(cat) {
        this.filterCat = cat;
        this.updateUrl();
    },

    setArea(area) {
        this.filterArea = area;
        this.updateUrl();
    },

    updateUrl() {
        const url = new URL(window.location);
        if (this.filterCat === 'all') url.searchParams.delete('cat');
        else url.searchParams.set('cat', this.filterCat);

        if (this.filterArea === 'all') url.searchParams.delete('area');
        else url.searchParams.set('area', this.filterArea);

        window.history.replaceState({}, '', url);
    },

    match(tour) {
        // Filtro Area
        const areaMatch = (this.filterArea === 'all' || 
                          tour.area_tag === this.filterArea || 
                          (tour.area && tour.area.toLowerCase().includes(this.filterArea.toLowerCase())));
        
        // Filtro Categoria Dinamico
        if (this.filterCat === 'all') return areaMatch;

        const cat = this.filterCat.toLowerCase();
        const catMatch = (
            (tour.category_slug && tour.category_slug.toLowerCase() === cat) ||
            (tour.categories && Array.isArray(tour.categories) && tour.categories.map(c => c.toLowerCase()).includes(cat)) ||
            (tour.category && tour.category.toLowerCase().includes(cat)) ||
            (tour.area_tag && tour.area_tag.toLowerCase() === cat) ||
            (tour.slug && tour.slug.toLowerCase().includes(cat)) ||
            (tour.difficulty && tour.difficulty.toLowerCase().includes(cat)) ||
            (tour.title && tour.title.toLowerCase().includes(cat))
        );

        return areaMatch && catMatch;
    }
}">
    <div class="container">
        <!-- Dynamic Filter Toolbar -->
        <div style="background: var(--color-white); padding: 1.5rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); border: 1px solid var(--color-gray-200); margin-bottom: 2.5rem;">
            
            <!-- Riga 1: Categorie Dinamiche -->
            <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-gray-100);">
                <span style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: var(--color-primary-dark); margin-right: 0.5rem;">
                    <i class="fa-solid fa-shapes" style="color: var(--color-primary);"></i> Categorie:
                </span>
                <button type="button" class="filter-pill btn-sm" :class="{ 'active': filterCat === 'all' }" @click="setCat('all')">
                    Tutte le Categorie
                </button>
                <?php foreach ($excursionCategories as $c): ?>
                    <button type="button" class="filter-pill btn-sm" :class="{ 'active': filterCat === '<?= $c['slug'] ?>' }" @click="setCat('<?= $c['slug'] ?>')">
                        <i class="fa-solid fa-<?= htmlspecialchars($c['icon'] ?? 'check') ?>"></i> <?= htmlspecialchars($c['name_it']) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Riga 2: Aree Geografiche -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;">
                    <span style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: var(--color-gray-600); margin-right: 0.5rem;">
                        <i class="fa-solid fa-map-location-dot" style="color: var(--color-primary);"></i> Area:
                    </span>
                    <button type="button" class="filter-pill btn-sm" :class="{ 'active': filterArea === 'all' }" @click="setArea('all')">Tutta la Sicilia</button>
                    <button type="button" class="filter-pill btn-sm" :class="{ 'active': filterArea === 'etna' }" @click="setArea('etna')">Etna Nord & Crateri</button>
                    <button type="button" class="filter-pill btn-sm" :class="{ 'active': filterArea === 'nebrodi' }" @click="setArea('nebrodi')">Parco dei Nebrodi</button>
                </div>

                <a href="<?= BASE_URL ?>/personalizza-tour.php" class="btn btn-accent btn-sm">
                    <i class="fa-solid fa-sliders"></i> Richiedi Tour su Misura
                </a>
            </div>
        </div>

        <!-- Tours Grid -->
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
