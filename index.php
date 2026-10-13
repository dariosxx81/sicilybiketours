<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/data/faqs.php';

// Caricamento Dati Dinamici Homepage, Categorie e Recensioni
$hpFile = BASE_PATH . '/data/homepage.json';
$hp = file_exists($hpFile) ? json_decode(file_get_contents($hpFile), true) : [];

$categoriesFile = BASE_PATH . '/data/categories.json';
$categories = file_exists($categoriesFile) ? json_decode(file_get_contents($categoriesFile), true) : [];
usort($categories, fn($a, $b) => ($a['order'] ?? 10) <=> ($b['order'] ?? 10));

$reviewsFile = BASE_PATH . '/data/reviews.json';
$reviews = file_exists($reviewsFile) ? json_decode(file_get_contents($reviewsFile), true) : ($reviews ?? []);

$heroBg = !empty($hp['hero']['bg_image']) ? $hp['hero']['bg_image'] : 'assets/img/gallery/summit.jpg';
$heroBadgeIcon = !empty($hp['hero']['badge_icon']) ? $hp['hero']['badge_icon'] : 'bolt';
$qf = $hp['hero']['quick_finder'] ?? ['enabled' => true];

$rawHeroTitle = $hp['hero']['title_it'] ?? t('hero_title');
$pageTitle = strip_tags($rawHeroTitle) . ' | ' . SITE_NAME;
$pageDescription = SITE_DESCRIPTION;

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/navbar.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-media-bg">
        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($heroBg) ?>" alt="<?= htmlspecialchars(SITE_NAME) ?>">
    </div>
    <div class="hero-overlay"></div>

    <div class="container">
        <div class="hero-content">
            <span class="badge badge-accent" style="margin-bottom: 0.75rem;">
                <i class="fa-solid fa-<?= htmlspecialchars($heroBadgeIcon) ?>"></i> <?= htmlspecialchars($hp['hero']['badge'] ?? t('hero_badge')) ?>
            </span>
            <h1 class="hero-title">
                <?= $hp['hero']['title_it'] ?? 'Vivi la vera Sicilia in <span class="text-gradient">E-Bike</span>' ?>
            </h1>
            <p class="hero-subtitle">
                <?= htmlspecialchars($hp['hero']['subtitle_it'] ?? t('hero_subtitle')) ?>
            </p>

            <div class="hero-buttons">
                <a href="<?= htmlspecialchars($hp['hero']['cta_explore_link'] ?? '#esperienze') ?>" class="btn btn-accent btn-lg">
                    <i class="fa-solid fa-compass"></i> <?= htmlspecialchars($hp['hero']['cta_explore_text'] ?? t('hero_cta_explore')) ?>
                </a>
                <a href="<?= BASE_URL ?>/<?= htmlspecialchars($hp['hero']['cta_custom_link'] ?? 'personalizza-tour.php') ?>" class="btn btn-outline-white btn-lg">
                    <i class="fa-solid fa-sliders"></i> <?= htmlspecialchars($hp['hero']['cta_custom_text'] ?? t('hero_cta_custom')) ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Box di Ricerca Rapida a cavallo tra Hero e Sezione Successiva -->
<?php if (($qf['enabled'] ?? true) !== false): ?>
<div class="hero-search-overlap-wrapper">
    <div class="container">
        <div class="hero-filter-bar" x-data="{
            selectedType: 'all',
            selectedCat: 'all',
            applyFilter() {
                let targetUrl = '<?= BASE_URL ?>/escursioni.php';
                if (this.selectedType === 'tour') {
                    targetUrl = '<?= BASE_URL ?>/tour.php';
                }
                if (this.selectedCat !== 'all') {
                    targetUrl += '?cat=' + encodeURIComponent(this.selectedCat);
                }
                window.location.href = targetUrl;
            }
        }">
            <div class="hero-filter-item">
                <span class="hero-filter-label"><i class="fa-solid fa-layer-group" style="color: var(--color-primary); margin-right: 4px;"></i> <?= htmlspecialchars(CURRENT_LANG === 'en' ? ($qf['type_label_en'] ?? 'Tour Type') : ($qf['type_label_it'] ?? 'Tipologia Tour')) ?></span>
                <select class="hero-filter-select" x-model="selectedType">
                    <option value="all"><?= CURRENT_LANG === 'en' ? 'All Experiences' : 'Tutte le esperienze' ?></option>
                    <option value="escursione"><?= CURRENT_LANG === 'en' ? 'Day Excursions (1 day)' : 'Escursioni Giornaliere (1 giorno)' ?></option>
                    <option value="tour"><?= CURRENT_LANG === 'en' ? 'Multi-Day Tours' : 'Tour Itineranti (Weekend & Settimane)' ?></option>
                </select>
            </div>
            <div class="hero-filter-item">
                <span class="hero-filter-label"><i class="fa-solid fa-shapes" style="color: var(--color-primary); margin-right: 4px;"></i> <?= htmlspecialchars(CURRENT_LANG === 'en' ? ($qf['cat_label_en'] ?? 'Experience / Category') : ($qf['cat_label_it'] ?? 'Categoria Esperienza')) ?></span>
                <select class="hero-filter-select" x-model="selectedCat">
                    <option value="all"><?= CURRENT_LANG === 'en' ? 'All Categories' : 'Tutte le categorie' ?></option>
                    <?php foreach ($categories as $catItem): ?>
                        <option value="<?= htmlspecialchars($catItem['slug'] ?? $catItem['id']) ?>">
                            <?= htmlspecialchars($catItem['name_it']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="button" class="btn btn-primary" @click="applyFilter()" style="padding: 0.85rem 1.6rem; font-weight: 700; white-space: nowrap; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-magnifying-glass"></i> <?= htmlspecialchars(CURRENT_LANG === 'en' ? ($qf['btn_text_en'] ?? 'Search Tours') : ($qf['btn_text_it'] ?? 'Cerca Tour')) ?>
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Sezione Categorie Dinamiche & Badge Esperienze -->
<?php if (($hp['categories_section']['enabled'] ?? true) !== false): ?>
<section class="category-badges-section" style="padding: 3.5rem 0 4rem 0; background: var(--color-white);">
    <div class="container">
        <div class="section-header" style="max-width: 860px; margin: 0 auto 2.5rem auto;">
            <span class="section-tag">
                <i class="fa-solid fa-shapes"></i> <?= htmlspecialchars($hp['categories_section']['tag'] ?? 'Esperienze Su Misura per Tutti') ?>
            </span>
            <h2 class="section-title">
                <?= htmlspecialchars($hp['categories_section']['title'] ?? 'Tour in E-Bike per Ogni Livello, Ritmo e Passione') ?>
            </h2>
            <p class="section-subtitle" style="font-size: 1.12rem; color: var(--color-gray-700); line-height: 1.7;">
                <?= htmlspecialchars($hp['categories_section']['subtitle'] ?? 'Pedalare in Sicilia con le nostre E-MTB di ultima generazione è un\'emozione accessibile a tutti.') ?>
            </p>
        </div>

        <!-- Griglia Categorie Dinamiche (Collegate ai filtri) -->
        <div class="category-badges-grid">
            <?php foreach ($categories as $cat): 
                if (isset($cat['show_in_home']) && $cat['show_in_home'] === false) continue;
                $catSlug = $cat['slug'] ?? $cat['id'];
                $catIcon = $cat['icon'] ?? 'bicycle';
                $catName = CURRENT_LANG === 'en' ? ($cat['name_en'] ?? $cat['name_it']) : $cat['name_it'];
                $filterType = $cat['filter_type'] ?? 'all';
                
                // Determinazione link intelligente
                if ($filterType === 'tour') {
                    $catUrl = BASE_URL . '/tour.php?cat=' . urlencode($catSlug);
                } elseif ($filterType === 'su_misura') {
                    $catUrl = BASE_URL . '/personalizza-tour.php';
                } else {
                    $catUrl = BASE_URL . '/escursioni.php?cat=' . urlencode($catSlug);
                }
            ?>
                <a href="<?= $catUrl ?>" class="category-badge-card" title="<?= htmlspecialchars($cat['badge_desc'] ?? $catName) ?>">
                    <div class="category-badge-icon">
                        <i class="fa-solid fa-<?= htmlspecialchars($catIcon) ?>"></i>
                    </div>
                    <span class="category-badge-title"><?= htmlspecialchars($catName) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Vetrina Esperienze & Tour Carousel -->
<?php if (($hp['showcase_section']['enabled'] ?? true) !== false): ?>
<?php 
    $cFilter = $hp['showcase_section']['carousel_filter'] ?? 'all';
    $cTours = $cFilter === 'featured' ? array_values(array_filter($tours, fn($t) => !empty($t['featured']))) : $tours;
    if (empty($cTours)) $cTours = $tours;
?>
<section id="esperienze" class="section-spacing" style="background: var(--color-gray-50);" x-data="{
    scrollContainer: null,
    canScrollLeft: false,
    canScrollRight: true,
    init() {
        this.scrollContainer = this.$refs.slider;
        this.$nextTick(() => { this.updateScrollButtons(); });
    },
    scroll(direction) {
        const container = this.$refs.slider;
        if (!container) return;
        const item = container.querySelector('.tours-carousel-item');
        const cardWidth = item ? (item.offsetWidth + 28) : 380;
        const scrollAmount = direction === 'next' ? cardWidth : -cardWidth;
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        setTimeout(() => this.updateScrollButtons(), 350);
    },
    updateScrollButtons() {
        const el = this.$refs.slider;
        if (!el) return;
        this.canScrollLeft = el.scrollLeft > 15;
        this.canScrollRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 15);
    }
}">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.2rem; flex-wrap: wrap; gap: 1.25rem;">
            <div style="max-width: 720px;">
                <span class="section-tag">
                    <i class="fa-solid fa-bicycle"></i> <?= htmlspecialchars($hp['showcase_section']['tag'] ?? 'Le Nostre Proposte') ?>
                </span>
                <h2 class="section-title" style="margin-bottom: 0.5rem;">
                    <?= htmlspecialchars($hp['showcase_section']['title'] ?? 'Esperienze in E-Bike & Tour Itineranti') ?>
                </h2>
                <p class="section-subtitle" style="margin-bottom: 0;">
                    <?= htmlspecialchars($hp['showcase_section']['subtitle'] ?? 'Scorri tra le nostre migliori avventure su due ruote.') ?>
                </p>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <button type="button" class="carousel-btn prev" @click="scroll('prev')" :disabled="!canScrollLeft" aria-label="Precedente">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button type="button" class="carousel-btn next" @click="scroll('next')" :disabled="!canScrollRight" aria-label="Successivo">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Tours Carousel Track -->
        <div class="tours-carousel-wrapper">
            <div class="tours-carousel-track" x-ref="slider" @scroll.debounce.50ms="updateScrollButtons()">
                <?php foreach ($cTours as $tour): ?>
                    <div class="tours-carousel-item">
                        <?php require BASE_PATH . '/includes/tour-card.php'; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Due Riferimenti Cataloghi: Escursioni 1 Giorno & Tour Itineranti -->
        <?php 
            $dayCard = $hp['showcase_section']['day_card'] ?? [];
            $multiCard = $hp['showcase_section']['multi_card'] ?? [];
            $dayIcon = $dayCard['icon'] ?? 'sun';
            $multiIcon = $multiCard['icon'] ?? 'calendar-days';
        ?>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.75rem; margin-top: 3.5rem;" class="experience-catalog-cta-grid">
            <div style="background: var(--color-white); border: 1.5px solid var(--color-gray-200); border-radius: var(--radius-xl); padding: 2rem; display: flex; flex-direction: column; justify-content: space-between; box-shadow: var(--shadow-md);" class="exp-cta-card">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 0.85rem;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--color-accent-light); color: var(--color-primary); display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                            <i class="fa-solid fa-<?= htmlspecialchars($dayIcon) ?>"></i>
                        </div>
                        <div>
                            <span style="font-size: 0.78rem; font-weight: 700; text-transform: uppercase; color: var(--color-volcano); letter-spacing: 0.05em;"><?= htmlspecialchars($dayCard['badge'] ?? 'Avventure di 1 Giorno') ?></span>
                            <h3 style="font-size: 1.35rem; color: var(--color-primary-dark); margin: 0;"><?= htmlspecialchars($dayCard['title'] ?? 'Escursioni Giornaliere') ?></h3>
                        </div>
                    </div>
                    <p style="font-size: 0.95rem; color: var(--color-gray-600); line-height: 1.6; margin-bottom: 1.5rem;">
                        <?= htmlspecialchars($dayCard['desc'] ?? 'Uscite da mezza giornata o giornata intera tra colate laviche, crateri, boschi e degustazioni in cantina.') ?>
                    </p>
                </div>
                <a href="<?= BASE_URL ?>/<?= htmlspecialchars($dayCard['link'] ?? 'escursioni.php') ?>" class="btn btn-outline-primary" style="width: 100%; font-weight: 700;">
                    <i class="fa-solid fa-compass"></i> <?= htmlspecialchars($dayCard['btn_text'] ?? 'Scopri tutte le Escursioni') ?> <i class="fa-solid fa-arrow-right" style="margin-left: 0.3rem;"></i>
                </a>
            </div>

            <div style="background: var(--color-white); border: 1.5px solid var(--color-gray-200); border-radius: var(--radius-xl); padding: 2rem; display: flex; flex-direction: column; justify-content: space-between; box-shadow: var(--shadow-md);" class="exp-cta-card">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 0.85rem;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--color-accent-light); color: var(--color-primary); display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                            <i class="fa-solid fa-<?= htmlspecialchars($multiIcon) ?>"></i>
                        </div>
                        <div>
                            <span style="font-size: 0.78rem; font-weight: 700; text-transform: uppercase; color: var(--color-primary); letter-spacing: 0.05em;"><?= htmlspecialchars($multiCard['badge'] ?? 'Vacanze in Bici da 2 a 7 Giorni') ?></span>
                            <h3 style="font-size: 1.35rem; color: var(--color-primary-dark); margin: 0;"><?= htmlspecialchars($multiCard['title'] ?? 'Tour Itineranti & Weekend') ?></h3>
                        </div>
                    </div>
                    <p style="font-size: 0.95rem; color: var(--color-gray-600); line-height: 1.6; margin-bottom: 1.5rem;">
                        <?= htmlspecialchars($multiCard['desc'] ?? 'Vacanze complete in e-bike con pernottamento in dimore di charme, trasporto valigie e furgone d\'appoggio.') ?>
                    </p>
                </div>
                <a href="<?= BASE_URL ?>/<?= htmlspecialchars($multiCard['link'] ?? 'tour.php') ?>" class="btn btn-primary" style="width: 100%; font-weight: 700;">
                    <i class="fa-solid fa-route"></i> <?= htmlspecialchars($multiCard['btn_text'] ?? 'Scopri tutti i Tour Itineranti') ?> <i class="fa-solid fa-arrow-right" style="margin-left: 0.3rem;"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Custom Tour Builder Section Preview -->
<?php if (($hp['custom_builder_section']['enabled'] ?? true) !== false): ?>
<section class="section-spacing" style="background: var(--color-white); border-top: 1px solid var(--color-gray-200);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-sliders"></i> <?= htmlspecialchars($hp['custom_builder_section']['tag'] ?? 'Esperienze Su Misura') ?></span>
            <h2 class="section-title"><?= htmlspecialchars($hp['custom_builder_section']['title'] ?? 'Configura il tuo Viaggio in E-Bike su Misura') ?></h2>
            <p class="section-subtitle"><?= htmlspecialchars($hp['custom_builder_section']['subtitle'] ?? 'Personalizza tappe, ritmo, pernottamenti ed esperienze gastronomiche esclusive.') ?></p>
        </div>

        <?php require_once BASE_PATH . '/includes/custom-tour-builder.php'; ?>
    </div>
</section>
<?php endif; ?>

<!-- Magazine & Stories Section -->
<?php if (($hp['magazine_section']['enabled'] ?? true) !== false): ?>
<?php $magLimit = intval($hp['magazine_section']['show_count'] ?? 3); ?>
<section class="section-spacing" style="background: var(--color-white);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-newspaper"></i> <?= htmlspecialchars($hp['magazine_section']['tag'] ?? 'Il Nostro Magazine') ?></span>
            <h2 class="section-title"><?= htmlspecialchars($hp['magazine_section']['title'] ?? 'Storie, Percorsi & Consigli di Cicloturismo') ?></h2>
            <p class="section-subtitle"><?= htmlspecialchars($hp['magazine_section']['subtitle'] ?? 'Guide ai sentieri, altimetrie e racconti per scoprire la Sicilia autentica.') ?></p>
        </div>

        <div class="magazine-grid" style="margin-bottom: 2.5rem;">
            <?php foreach (array_slice($articles, 0, $magLimit) as $art): ?>
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
                                Leggi Articolo <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align: center;">
            <a href="<?= BASE_URL ?>/<?= htmlspecialchars($hp['magazine_section']['btn_link'] ?? 'magazine.php') ?>" class="btn btn-primary">
                <i class="fa-solid fa-book-open"></i> <?= htmlspecialchars($hp['magazine_section']['btn_text'] ?? 'Visita Magazine Completo') ?>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Testimonials & Reviews Dinamiche -->
<?php if (($hp['reviews_section']['enabled'] ?? true) !== false): ?>
<section class="section-spacing" style="background: var(--color-gray-50);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-heart"></i> <?= htmlspecialchars($hp['reviews_section']['tag'] ?? 'Dicono di Noi') ?></span>
            <h2 class="section-title"><?= htmlspecialchars($hp['reviews_section']['title'] ?? 'Le Esperienze dei Nostri Viaggiatori') ?></h2>
            <p class="section-subtitle"><?= htmlspecialchars($hp['reviews_section']['subtitle'] ?? 'Ospiti provenienti da tutto il mondo che hanno pedalato con noi tra vulcano e mare.') ?></p>
        </div>

        <div class="reviews-grid">
            <?php foreach ($reviews as $rev): ?>
                <div class="feature-card" style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="color: var(--color-volcano); margin-bottom: 0.8rem; font-size: 1.1rem;">
                            <?php for ($i = 0; $i < ($rev['rating'] ?? 5); $i++): ?>
                                <i class="fa-solid fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <p style="font-size: 0.95rem; color: var(--color-gray-700); font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">
                            "<?= htmlspecialchars(CURRENT_LANG === 'en' ? ($rev['text_en'] ?? $rev['text_it']) : $rev['text_it']) ?>"
                        </p>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--color-gray-100); padding-top: 1rem;">
                        <div>
                            <strong style="display: block; font-size: 0.95rem; color: var(--color-primary-dark);"><?= htmlspecialchars($rev['author']) ?></strong>
                            <span style="font-size: 0.8rem; color: var(--color-gray-500);"><?= htmlspecialchars($rev['country'] ?? '') ?></span>
                        </div>
                        <span class="badge badge-accent" style="font-size: 0.72rem;"><?= htmlspecialchars($rev['tour'] ?? '') ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Partners Section Dinamica -->
<?php $partnersList = $settings['partners'] ?? []; ?>
<?php if ((($hp['partners_section']['enabled'] ?? true) !== false) && !empty($partnersList)): ?>
<section class="section-spacing" style="background: var(--color-white); border-top: 1px solid var(--color-gray-200);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-handshake"></i> <?= htmlspecialchars($hp['partners_section']['tag'] ?? 'Network di Qualità') ?></span>
            <h2 class="section-title"><?= htmlspecialchars($hp['partners_section']['title'] ?? 'Partner Ufficiali & Istituzionali') ?></h2>
            <p class="section-subtitle"><?= htmlspecialchars($hp['partners_section']['subtitle'] ?? 'Collaboriamo con i migliori enti parco e produttori per garantire la massima qualità.') ?></p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;" class="partners-responsive-grid">
            <?php foreach ($partnersList as $p): ?>
                <div class="partner-card" style="background: var(--color-white); border: 1px solid var(--color-gray-200); padding: 1.6rem 1rem; text-align: center; border-radius: var(--radius-xl); display: flex; flex-direction: column; align-items: center; justify-content: space-between; transition: all var(--transition-normal); height: 100%; box-shadow: var(--shadow-sm);">
                    <div class="partner-logo-container" style="height: 52px; width: 100%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; padding: 0 0.5rem;">
                        <?php if (!empty($p['logo'])): ?>
                            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($p['logo']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="max-height: 48px; max-width: 100%; width: auto; height: auto; object-fit: contain;">
                        <?php else: ?>
                            <div class="feature-icon-box" style="margin: 0 auto; width: 48px; height: 48px;">
                                <i class="<?= htmlspecialchars($p['icon'] ?? 'fa-solid fa-check') ?>" style="font-size: 1.4rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <h4 style="font-size: 1rem; margin-bottom: 0.25rem; color: var(--color-primary-dark); font-weight: 700;"><?= htmlspecialchars($p['name']) ?></h4>
                        <span style="font-size: 0.8rem; color: var(--color-gray-500); display: block;"><?= CURRENT_LANG === 'en' ? ($p['role_en'] ?? $p['role_it']) : $p['role_it'] ?></span>
                    </div>
                    <span class="badge badge-accent" style="font-size: 0.72rem; margin-top: auto;"><?= htmlspecialchars($p['badge'] ?? '') ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAQs Section Dinamica -->
<?php if (($hp['faqs_section']['enabled'] ?? true) !== false): ?>
<section class="section-spacing" style="background: var(--color-gray-50);">
    <div class="container container-narrow">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-circle-question"></i> <?= htmlspecialchars($hp['faqs_section']['tag'] ?? 'Domande Frequenti') ?></span>
            <h2 class="section-title"><?= htmlspecialchars($hp['faqs_section']['title'] ?? 'Tutto quello che c\'è da sapere') ?></h2>
            <p class="section-subtitle"><?= htmlspecialchars($hp['faqs_section']['subtitle'] ?? 'Hai dubbi sulle nostre escursioni o sui tour in e-bike? Ecco le risposte più comuni.') ?></p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1rem;" x-data="{ openFaq: 0 }">
            <?php foreach ($faqs as $idx => $faq): ?>
                <div class="feature-card" style="padding: 1.25rem 1.6rem; cursor: pointer;" @click="openFaq = (openFaq === <?= $idx ?> ? null : <?= $idx ?>)">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <h4 style="font-size: 1.08rem; color: var(--color-primary-dark);">
                            <?= CURRENT_LANG === 'en' ? ($faq['q_en'] ?? $faq['q_it']) : $faq['q_it'] ?>
                        </h4>
                        <i class="fa-solid" :class="openFaq === <?= $idx ?> ? 'fa-minus' : 'fa-plus'" style="color: var(--color-primary); font-size: 0.9rem;"></i>
                    </div>
                    <div x-show="openFaq === <?= $idx ?>" x-transition style="display: none; margin-top: 0.85rem; padding-top: 0.85rem; border-top: 1px solid var(--color-gray-100); color: var(--color-gray-600); font-size: 0.95rem; line-height: 1.6;">
                        <?= CURRENT_LANG === 'en' ? ($faq['a_en'] ?? $faq['a_it']) : $faq['a_it'] ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
