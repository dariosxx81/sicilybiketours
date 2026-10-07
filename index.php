<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/data/faqs.php';

$pageTitle = t('hero_title') . ' | ' . SITE_NAME;
$pageDescription = SITE_DESCRIPTION;

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/navbar.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-media-bg">
        <img src="<?= BASE_URL ?>/assets/img/gallery/summit.jpg" alt="Sicily Bike Tours Etna">
    </div>
    <div class="hero-overlay"></div>

    <div class="container">
        <div class="hero-content">
            <span class="badge badge-accent" style="margin-bottom: 0.75rem;">
                <i class="fa-solid fa-bolt"></i> <?= t('hero_badge') ?>
            </span>
            <h1 class="hero-title">
                <?= CURRENT_LANG === 'en' ? 'Experience Authentic <span class="text-gradient">Sicily by E-Bike</span>' : 'Vivi la vera Sicilia in <span class="text-gradient">E-Bike</span>' ?>
            </h1>
            <p class="hero-subtitle">
                <?= t('hero_subtitle') ?>
            </p>

            <div class="hero-buttons">
                <a href="#esperienze" class="btn btn-accent btn-lg">
                    <i class="fa-solid fa-compass"></i> <?= t('hero_cta_explore') ?>
                </a>
                <a href="<?= BASE_URL ?>/personalizza-tour.php" class="btn btn-outline-white btn-lg">
                    <i class="fa-solid fa-sliders"></i> <?= t('hero_cta_custom') ?>
                </a>
            </div>

            <!-- Quick Finder Bar -->
            <div class="hero-filter-bar" x-data="{
                selectedType: 'all',
                selectedArea: 'all',
                applyFilter() {
                    if (this.selectedType === 'escursione') {
                        window.location.href = '<?= BASE_URL ?>/escursioni.php?area=' + this.selectedArea;
                    } else if (this.selectedType === 'tour') {
                        window.location.href = '<?= BASE_URL ?>/tour.php?area=' + this.selectedArea;
                    } else {
                        window.location.href = '<?= BASE_URL ?>/#esperienze';
                    }
                }
            }">
                <div class="hero-filter-item">
                    <span class="hero-filter-label">Tipologia Tour</span>
                    <select class="hero-filter-select" x-model="selectedType">
                        <option value="all">Tutte le esperienze</option>
                        <option value="escursione">Escursioni Giornaliere (1 giorno)</option>
                        <option value="tour">Tour Itineranti (Weekend & Settimane)</option>
                    </select>
                </div>
                <div class="hero-filter-item">
                    <span class="hero-filter-label">Destinazione</span>
                    <select class="hero-filter-select" x-model="selectedArea">
                        <option value="all">Tutta la Sicilia</option>
                        <option value="etna">Vulcano Etna & Cantine</option>
                        <option value="nebrodi">Parco dei Nebrodi & Borghi</option>
                        <option value="isole">Isole Eolie Bici & Barca</option>
                        <option value="barocco">Val di Noto & Costa</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary" @click="applyFilter()">
                    <i class="fa-solid fa-magnifying-glass"></i> Cerca
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Features Value Props Strip -->
<div class="container features-strip">
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon-box">
                <i class="fa-solid fa-mountain-sun" style="font-size: 1.4rem;"></i>
            </div>
            <h4><?= CURRENT_LANG === 'en' ? 'Authentic Trails' : 'Percorsi Autentici' ?></h4>
            <p><?= CURRENT_LANG === 'en' ? 'Trails away from mass tourism: from Etna craters to wild Nebrodi woods.' : 'Sentieri esclusivi lontani dal turismo di massa: dai crateri dell\'Etna ai boschi incontaminati.' ?></p>
        </div>

        <div class="feature-card">
            <div class="feature-icon-box">
                <i class="fa-solid fa-shield-halved" style="font-size: 1.4rem;"></i>
            </div>
            <h4><?= CURRENT_LANG === 'en' ? 'Certified Local Guides' : 'Guide Esperte & Assistenza' ?></h4>
            <p><?= CURRENT_LANG === 'en' ? 'Accompanied by Mariella and local guides with dedicated support vehicle.' : 'Guidati da Mariella e guide locali del territorio con furgone d\'appoggio al seguito.' ?></p>
        </div>

        <div class="feature-card">
            <div class="feature-icon-box">
                <i class="fa-solid fa-bolt-lightning" style="font-size: 1.4rem;"></i>
            </div>
            <h4><?= CURRENT_LANG === 'en' ? 'Top-End E-Bikes' : 'E-Bike di Ultima Generazione' ?></h4>
            <p><?= CURRENT_LANG === 'en' ? 'Full suspension & front e-mtb for maximum safety and comfort for all riders.' : 'E-MTB biammortizzate performanti con grande autonomia per pedalare senza fatica.' ?></p>
        </div>

        <div class="feature-card">
            <div class="feature-icon-box">
                <i class="fa-solid fa-wine-glass-empty" style="font-size: 1.4rem;"></i>
            </div>
            <h4><?= CURRENT_LANG === 'en' ? 'Sicilian Food & Wine' : 'Gusto & Tradizione' ?></h4>
            <p><?= CURRENT_LANG === 'en' ? 'Tasting of Etna DOC wines, gourmet home restaurants and authentic zero-km specialties.' : 'Degustazioni di vini Etna DOC, pranzi in home restaurant e prodotti tipici genuini a km 0.' ?></p>
        </div>
    </div>
</div>

<!-- Tour Catalog Showcase (Alpine.js Interactive Filters) -->
<section id="esperienze" class="section-spacing" x-data="{
    activeCategory: 'all',
    activeArea: 'all',
    toursList: <?= htmlspecialchars(json_encode($tours)) ?>,
    
    get filteredTours() {
        return this.toursList.filter(t => {
            const matchCat = (this.activeCategory === 'all' || t.type === this.activeCategory);
            const matchArea = (this.activeArea === 'all' || t.area_tag === this.activeArea);
            return matchCat && matchArea;
        });
    }
}">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-bicycle"></i> Le Nostre Proposte</span>
            <h2 class="section-title">Esperienze in E-Bike & Tour Itineranti</h2>
            <p class="section-subtitle">Dalle escursioni giornaliere fino ai viaggi di più giorni: scegli l'avventura ideale per il tuo livello.</p>
        </div>

        <!-- Filter Nav Pills -->
        <div class="tours-filter-nav">
            <button class="filter-pill" :class="{ 'active': activeCategory === 'all' && activeArea === 'all' }" @click="activeCategory = 'all'; activeArea = 'all'">
                <?= t('filter_all') ?>
            </button>
            <button class="filter-pill" :class="{ 'active': activeCategory === 'escursione' }" @click="activeCategory = 'escursione'; activeArea = 'all'">
                <i class="fa-solid fa-sun"></i> <?= t('filter_day') ?>
            </button>
            <button class="filter-pill" :class="{ 'active': activeCategory === 'tour' }" @click="activeCategory = 'tour'; activeArea = 'all'">
                <i class="fa-solid fa-calendar-days"></i> <?= t('filter_multi') ?>
            </button>
            <button class="filter-pill" :class="{ 'active': activeArea === 'etna' }" @click="activeArea = 'etna'">
                <i class="fa-solid fa-volcano"></i> <?= t('filter_etna') ?>
            </button>
            <button class="filter-pill" :class="{ 'active': activeArea === 'nebrodi' }" @click="activeArea = 'nebrodi'">
                <i class="fa-solid fa-tree"></i> <?= t('filter_nebrodi') ?>
            </button>
            <button class="filter-pill" :class="{ 'active': activeArea === 'isole' }" @click="activeArea = 'isole'">
                <i class="fa-solid fa-ship"></i> <?= t('filter_islands') ?>
            </button>
        </div>

        <!-- Dynamic Tours Grid -->
        <div class="tours-grid">
            <?php foreach ($tours as $tour): ?>
                <?php require BASE_PATH . '/includes/tour-card.php'; ?>
            <?php endforeach; ?>
        </div>

        <div style="text-align: center; margin-top: 3.5rem;">
            <a href="<?= BASE_URL ?>/personalizza-tour.php" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-sliders"></i> <?= CURRENT_LANG === 'en' ? 'Want a custom itinerary? Build your Tour' : 'Vuoi un itinerario personalizzato? Crea il tuo Tour su Misura' ?>
            </a>
        </div>
    </div>
</section>

<!-- Interactive Availability Calendar Section -->
<section id="calendario" class="section-spacing calendar-section-wrapper" x-data="{
    currentMonth: 3, // 0-indexed, 3 = April 2026
    currentYear: 2026,
    selectedDate: '2026-04-18',
    monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
    
    // Sample scheduled departures from tours database
    departures: [
        { date: '2026-04-11', tourId: 4, tourTitle: 'Etna in E-Bike: Avventura e Degustazione Vino', time: '09:00', spots: 6, price: 90 },
        { date: '2026-04-15', tourId: 1, tourTitle: 'Etna Summit: la scalata del vulcano in E-Bike', time: '08:30', spots: 4, price: 85 },
        { date: '2026-04-18', tourId: 2, tourTitle: 'Escursione in E-Bike & Pranzo Gourmet', time: '09:30', spots: 8, price: 95 },
        { date: '2026-04-18', tourId: 8, tourTitle: 'Weekend: Randazzo, Megaliti Argimusco & Alcantara', time: '09:00', spots: 5, price: 240 },
        { date: '2026-04-22', tourId: 1, tourTitle: 'Etna Summit: la scalata del vulcano in E-Bike', time: '08:30', spots: 6, price: 85 },
        { date: '2026-04-24', tourId: 9, tourTitle: 'Tour 3 Giorni: Bike & Taste Etna, Randazzo & Bronte', time: '09:00', spots: 4, price: 390 },
        { date: '2026-04-29', tourId: 11, tourTitle: 'Cicloturismo alle Isole Eolie: Bici & Barca', time: '08:00', spots: 3, price: 790 },
        { date: '2026-05-02', tourId: 2, tourTitle: 'Escursione in E-Bike & Pranzo Gourmet', time: '09:30', spots: 6, price: 95 },
        { date: '2026-05-06', tourId: 1, tourTitle: 'Etna Summit: la scalata del vulcano in E-Bike', time: '08:30', spots: 8, price: 85 },
        { date: '2026-05-09', tourId: 8, tourTitle: 'Weekend: Randazzo, Megaliti Argimusco & Alcantara', time: '09:00', spots: 4, price: 240 },
        { date: '2026-05-15', tourId: 9, tourTitle: 'Tour 3 Giorni: Bike & Taste Etna, Randazzo & Bronte', time: '09:00', spots: 6, price: 390 },
        { date: '2026-05-20', tourId: 11, tourTitle: 'Cicloturismo alle Isole Eolie: Bici & Barca', time: '08:00', spots: 2, price: 790 }
    ],

    get daysInMonth() {
        return new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
    },
    get firstDayIndex() {
        let d = new Date(this.currentYear, this.currentMonth, 1).getDay();
        return (d === 0) ? 6 : d - 1; // Mon = 0
    },
    
    prevMonth() {
        if (this.currentMonth > 0) this.currentMonth--;
        else { this.currentMonth = 11; this.currentYear--; }
    },
    nextMonth() {
        if (this.currentMonth < 11) this.currentMonth++;
        else { this.currentMonth = 0; this.currentYear++; }
    },
    
    getDateStr(day) {
        let m = String(this.currentMonth + 1).padStart(2, '0');
        let d = String(day).padStart(2, '0');
        return `${this.currentYear}-${m}-${d}`;
    },
    
    hasDepartures(day) {
        let dStr = this.getDateStr(day);
        return this.departures.some(d => d.date === dStr);
    },
    
    getDeparturesForSelectedDate() {
        return this.departures.filter(d => d.date === this.selectedDate);
    }
}">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-calendar-check"></i> Partenze & Calendario</span>
            <h2 class="section-title"><?= t('calendar_title') ?></h2>
            <p class="section-subtitle"><?= t('calendar_subtitle') ?></p>
        </div>

        <div class="calendar-container">
            <!-- Calendar Grid -->
            <div>
                <div class="calendar-header-nav">
                    <button class="calendar-nav-btn" @click="prevMonth()"><i class="fa-solid fa-chevron-left"></i></button>
                    <span class="calendar-month-title" x-text="monthNames[currentMonth] + ' ' + currentYear"></span>
                    <button class="calendar-nav-btn" @click="nextMonth()"><i class="fa-solid fa-chevron-right"></i></button>
                </div>

                <div class="calendar-weekdays">
                    <span>Lun</span><span>Mar</span><span>Mer</span><span>Gio</span><span>Ven</span><span>Sab</span><span>Dom</span>
                </div>

                <div class="calendar-days-grid">
                    <!-- Blank days padding -->
                    <template x-for="i in firstDayIndex" :key="'blank-' + i">
                        <div class="cal-day-cell disabled"></div>
                    </template>

                    <!-- Month Days -->
                    <template x-for="day in daysInMonth" :key="'day-' + day">
                        <div class="cal-day-cell" 
                             :class="{ 
                                'selected': selectedDate === getDateStr(day),
                                'has-departure': hasDepartures(day)
                             }"
                             @click="selectedDate = getDateStr(day)">
                            <span x-text="day"></span>
                        </div>
                    </template>
                </div>

                <div style="display: flex; align-items: center; gap: 1.5rem; margin-top: 1.5rem; font-size: 0.85rem; color: var(--color-gray-600);">
                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--color-accent); display: inline-block;"></span>
                        <span>Partenza Programmata</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                        <span style="width: 12px; height: 12px; border-radius: 4px; background: var(--color-primary); display: inline-block;"></span>
                        <span>Data Selezionata</span>
                    </div>
                </div>
            </div>

            <!-- Departures Slot List on Selected Date -->
            <div class="calendar-slot-box">
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem;">
                        <h4 style="font-size: 1.2rem; color: var(--color-primary-dark);">
                            <i class="fa-solid fa-clock"></i> Partenze del <span x-text="selectedDate"></span>
                        </h4>
                    </div>

                    <template x-if="getDeparturesForSelectedDate().length > 0">
                        <div>
                            <template x-for="dep in getDeparturesForSelectedDate()" :key="dep.tourId">
                                <div class="slot-tour-item">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.4rem;">
                                        <h5 style="font-size: 1rem; color: var(--color-primary-dark);" x-text="dep.tourTitle"></h5>
                                        <span style="font-weight: 800; color: var(--color-primary);" x-text="'€' + dep.price"></span>
                                    </div>
                                    <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.85rem; color: var(--color-gray-600); margin-bottom: 0.75rem;">
                                        <span><i class="fa-regular fa-clock"></i> Ore <span x-text="dep.time"></span></span>
                                        <span class="badge badge-accent" style="font-size: 0.75rem;" x-text="dep.spots + ' posti liberi'"></span>
                                    </div>
                                    <button class="btn btn-primary btn-sm" style="width: 100%;" @click="openBooking({ id: dep.tourId, title: dep.tourTitle, price: dep.price })">
                                        <i class="fa-solid fa-check"></i> Prenota questa Partenza
                                    </button>
                                </div>
                            </template>
                        </div>
                    </template>

                    <template x-if="getDeparturesForSelectedDate().length === 0">
                        <div style="text-align: center; padding: 2rem 1rem; color: var(--color-gray-500);">
                            <i class="fa-regular fa-calendar-xmark" style="font-size: 2.2rem; margin-bottom: 0.75rem; color: var(--color-gray-400);"></i>
                            <p style="font-size: 0.95rem; margin-bottom: 1rem;">Nessuna partenza di gruppo fissa in questa data.</p>
                            <p style="font-size: 0.88rem; margin-bottom: 1.5rem;">Puoi comunque richiedere un <strong>Tour Privato</strong> o un'escursione su misura per te e i tuoi amici!</p>
                            <a :href="'<?= BASE_URL ?>/personalizza-tour.php?date=' + selectedDate" class="btn btn-accent btn-sm">
                                <i class="fa-solid fa-plus"></i> Richiedi Tour in questa Data
                            </a>
                        </div>
                    </template>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--color-gray-200); font-size: 0.85rem; color: var(--color-gray-600); display: flex; align-items: center; justify-content: space-between;">
                    <span>Hai date diverse o un gruppo numeroso?</span>
                    <a href="https://wa.me/<?= WA_NUMBER ?>" target="_blank" style="color: var(--color-primary); font-weight: 700;">
                        <i class="fa-brands fa-whatsapp"></i> Chiedi su WA
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom Tour Builder Section Preview -->
<section class="section-spacing" style="background: var(--color-gray-50);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-sliders"></i> Esperienze Su Misura</span>
            <h2 class="section-title"><?= t('custom_builder_title') ?></h2>
            <p class="section-subtitle"><?= t('custom_builder_subtitle') ?></p>
        </div>

        <?php require_once BASE_PATH . '/includes/custom-tour-builder.php'; ?>
    </div>
</section>

<!-- Magazine & Stories Section (3 Articoli) -->
<section class="section-spacing" style="background: var(--color-white);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-newspaper"></i> <?= t('nav_magazine') ?></span>
            <h2 class="section-title"><?= t('magazine_title') ?></h2>
            <p class="section-subtitle"><?= t('magazine_subtitle') ?></p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-bottom: 2.5rem;">
            <?php foreach (array_slice($articles, 0, 3) as $art): ?>
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

        <div style="text-align: center;">
            <a href="<?= BASE_URL ?>/magazine.php" class="btn btn-primary">
                <i class="fa-solid fa-book-open"></i> <?= t('magazine_all') ?>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials & Reviews -->
<section class="section-spacing" style="background: var(--color-gray-50);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-heart"></i> Dicono di Noi</span>
            <h2 class="section-title">Le Esperienze dei Nostri Viaggiatori</h2>
            <p class="section-subtitle">Ospiti provenienti da tutto il mondo che hanno pedalato con noi tra vulcano e mare.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            <?php foreach ($reviews as $rev): ?>
                <div class="feature-card" style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="color: var(--color-volcano); margin-bottom: 0.8rem; font-size: 1.1rem;">
                            <?php for ($i = 0; $i < $rev['rating']; $i++): ?>
                                <i class="fa-solid fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <p style="font-size: 0.95rem; color: var(--color-gray-700); font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">
                            "<?= CURRENT_LANG === 'en' ? $rev['text_en'] : $rev['text_it'] ?>"
                        </p>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--color-gray-100); padding-top: 1rem;">
                        <div>
                            <strong style="display: block; font-size: 0.95rem; color: var(--color-primary-dark);"><?= htmlspecialchars($rev['author']) ?></strong>
                            <span style="font-size: 0.8rem; color: var(--color-gray-500);"><?= htmlspecialchars($rev['country']) ?></span>
                        </div>
                        <span class="badge badge-accent" style="font-size: 0.72rem;"><?= htmlspecialchars($rev['tour']) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Partners Section (Configurabile da settings.json) -->
<?php $partnersList = $settings['partners'] ?? []; ?>
<?php if (!empty($partnersList)): ?>
<section class="section-spacing" style="background: var(--color-white); border-top: 1px solid var(--color-gray-200);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-handshake"></i> Network di Qualità</span>
            <h2 class="section-title"><?= t('partners_title') ?></h2>
            <p class="section-subtitle"><?= t('partners_subtitle') ?></p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(<?= count($partnersList) ?>, 1fr); gap: 1.25rem;" class="partners-responsive-grid">
            <?php foreach ($partnersList as $p): ?>
                <div class="feature-card" style="padding: 1.6rem 1.2rem; text-align: center; border-radius: var(--radius-lg); display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <div class="feature-icon-box" style="margin: 0 auto 1rem auto; width: 56px; height: 56px;">
                        <i class="<?= htmlspecialchars($p['icon'] ?? 'fa-solid fa-check') ?>" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 style="font-size: 1.1rem; margin-bottom: 0.35rem; color: var(--color-primary-dark);"><?= htmlspecialchars($p['name']) ?></h4>
                    <span style="font-size: 0.82rem; color: var(--color-gray-500); margin-bottom: 0.6rem;"><?= CURRENT_LANG === 'en' ? ($p['role_en'] ?? $p['role_it']) : $p['role_it'] ?></span>
                    <span class="badge badge-accent" style="font-size: 0.72rem;"><?= htmlspecialchars($p['badge']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAQs Section -->
<section class="section-spacing" style="background: var(--color-gray-50);">
    <div class="container container-narrow">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-circle-question"></i> Domande Frequenti</span>
            <h2 class="section-title">Tutto quello che c'è da sapere</h2>
            <p class="section-subtitle">Hai dubbi sulle nostre escursioni o sui tour in e-bike? Ecco le risposte più comuni.</p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1rem;" x-data="{ openFaq: 0 }">
            <?php foreach ($faqs as $idx => $faq): ?>
                <div class="feature-card" style="padding: 1.25rem 1.6rem; cursor: pointer;" @click="openFaq = (openFaq === <?= $idx ?> ? null : <?= $idx ?>)">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <h4 style="font-size: 1.08rem; color: var(--color-primary-dark);">
                            <?= CURRENT_LANG === 'en' ? $faq['q_en'] : $faq['q_it'] ?>
                        </h4>
                        <i class="fa-solid" :class="openFaq === <?= $idx ?> ? 'fa-minus' : 'fa-plus'" style="color: var(--color-primary); font-size: 0.9rem;"></i>
                    </div>
                    <div x-show="openFaq === <?= $idx ?>" x-transition style="display: none; margin-top: 0.85rem; padding-top: 0.85rem; border-top: 1px solid var(--color-gray-100); color: var(--color-gray-600); font-size: 0.95rem; line-height: 1.6;">
                        <?= CURRENT_LANG === 'en' ? $faq['a_en'] : $faq['a_it'] ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>

