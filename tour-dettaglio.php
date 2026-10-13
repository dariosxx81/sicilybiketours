<?php
require_once __DIR__ . '/config/config.php';

$slug = $_GET['slug'] ?? 'etna-summit-vulcano-avventura';
$tour = get_tour_by_slug($slug);

if (!$tour) {
    $tour = $tours[0];
}

$title = CURRENT_LANG === 'en' ? ($tour['title_en'] ?? $tour['title']) : $tour['title'];
$subtitle = CURRENT_LANG === 'en' ? ($tour['subtitle_en'] ?? $tour['subtitle']) : $tour['subtitle'];
$description = CURRENT_LANG === 'en' ? ($tour['description_en'] ?? $tour['description'] ?? '') : ($tour['description'] ?? '');
$itinerary = CURRENT_LANG === 'en' ? ($tour['itinerary_en'] ?? $tour['itinerary'] ?? '') : ($tour['itinerary'] ?? '');
$duration = CURRENT_LANG === 'en' ? ($tour['duration_en'] ?? $tour['duration']) : $tour['duration'];
$difficulty = CURRENT_LANG === 'en' ? ($tour['difficulty_en'] ?? $tour['difficulty']) : $tour['difficulty'];
$category = CURRENT_LANG === 'en' ? ($tour['category_en'] ?? $tour['category']) : $tour['category'];
$highlights = CURRENT_LANG === 'en' ? ($tour['highlights_en'] ?? $tour['highlights']) : $tour['highlights'];
$included = CURRENT_LANG === 'en' ? ($tour['included_en'] ?? $tour['included']) : $tour['included'];
$excluded = CURRENT_LANG === 'en' ? ($tour['excluded_en'] ?? $tour['excluded']) : $tour['excluded'];
$season = CURRENT_LANG === 'en' ? ($tour['season_en'] ?? $tour['season']) : $tour['season'];

$pageTitle = $title . ' | Sicily Bike Tours';
$pageDescription = !empty($description) ? substr(strip_tags($description), 0, 160) : $subtitle;
$pageImage = BASE_URL . '/' . $tour['image'];

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/navbar.php';
?>

<!-- Tour Hero Banner -->
<section style="background: linear-gradient(rgba(15, 44, 48, 0.82), rgba(15, 44, 48, 0.94)), url('<?= BASE_URL ?>/<?= htmlspecialchars($tour['image']) ?>') center/cover no-repeat; padding: 8.5rem 0 3.5rem 0; color: var(--color-white);">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.7); margin-bottom: 1rem; display: flex; gap: 0.5rem; align-items: center;">
            <a href="<?= BASE_URL ?>/">Home</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i>
            <a href="<?= BASE_URL ?>/<?= $tour['type'] === 'escursione' ? 'escursioni.php' : 'tour.php' ?>"><?= htmlspecialchars($category) ?></a>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i>
            <span style="color: var(--color-accent);"><?= htmlspecialchars($title) ?></span>
        </div>

        <div style="display: flex; gap: 0.6rem; flex-wrap: wrap; margin-bottom: 1rem;">
            <span class="badge badge-accent"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($tour['area']) ?></span>
            <span class="badge badge-dark"><i class="fa-solid fa-clock"></i> <?= htmlspecialchars($duration) ?></span>
            <span class="badge badge-dark"><i class="fa-solid fa-gauge"></i> <?= htmlspecialchars($difficulty) ?></span>
        </div>

        <h1 style="font-size: clamp(2rem, 4vw, 3rem); color: var(--color-white); max-width: 900px; line-height: 1.2; margin-bottom: 1rem;">
            <?= htmlspecialchars($title) ?>
        </h1>
        <p style="font-size: 1.15rem; color: rgba(255, 255, 255, 0.9); max-width: 800px;">
            <?= htmlspecialchars($subtitle) ?>
        </p>
    </div>
</section>

<!-- Main Tour Body Content & Sticky Booking Sidebar -->
<section class="section-spacing" style="background: var(--color-gray-50);">
    <div class="container">
        <div class="tour-detail-layout">
            
            <!-- Left Column: Tour Details & Gallery -->
            <div>
                <!-- Technical Specs Strip Card -->
                <div class="tour-specs-card-grid">
                    <div>
                        <i class="fa-solid fa-route" style="color: var(--color-primary); font-size: 1.3rem; margin-bottom: 0.3rem;"></i>
                        <strong style="display: block; font-size: 1.05rem;"><?= htmlspecialchars($tour['distance']) ?></strong>
                        <span style="font-size: 0.78rem; color: var(--color-gray-500); text-transform: uppercase;"><?= t('tour_distance') ?></span>
                    </div>
                    <div>
                        <i class="fa-solid fa-mountain" style="color: var(--color-primary); font-size: 1.3rem; margin-bottom: 0.3rem;"></i>
                        <strong style="display: block; font-size: 1.05rem;"><?= htmlspecialchars($tour['elevation']) ?></strong>
                        <span style="font-size: 0.78rem; color: var(--color-gray-500); text-transform: uppercase;"><?= t('tour_elevation') ?></span>
                    </div>
                    <div>
                        <i class="fa-solid fa-clock" style="color: var(--color-primary); font-size: 1.3rem; margin-bottom: 0.3rem;"></i>
                        <strong style="display: block; font-size: 1.05rem;"><?= htmlspecialchars($duration) ?></strong>
                        <span style="font-size: 0.78rem; color: var(--color-gray-500); text-transform: uppercase;"><?= t('tour_duration') ?></span>
                    </div>
                    <div>
                        <i class="fa-solid fa-calendar-check" style="color: var(--color-primary); font-size: 1.3rem; margin-bottom: 0.3rem;"></i>
                        <strong style="display: block; font-size: 0.85rem;"><?= htmlspecialchars($season) ?></strong>
                        <span style="font-size: 0.78rem; color: var(--color-gray-500); text-transform: uppercase;">Periodo</span>
                    </div>
                </div>

                <?php if (!empty($itinerary) || !empty($description)): ?>
                <!-- Full Description & Detailed Itinerary (Official Content from WordPress) -->
                <div style="background: var(--color-white); border-radius: var(--radius-lg); padding: 2.2rem; box-shadow: var(--shadow-sm); border: 1px solid var(--color-gray-200); margin-bottom: 2.5rem;">
                    <h3 style="font-size: 1.45rem; color: var(--color-primary-dark); margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.6rem;">
                        <i class="fa-solid fa-map-location-dot" style="color: var(--color-primary);"></i> Itinerario & Descrizione Completa
                    </h3>
                    
                    <div style="font-size: 1.02rem; line-height: 1.8; color: var(--color-gray-700); display: flex; flex-direction: column; gap: 1.1rem;">
                        <?php 
                        $fullStory = !empty($itinerary) ? $itinerary : $description;
                        $paragraphs = explode("\n\n", $fullStory);
                        foreach ($paragraphs as $para): 
                            $trimmed = trim($para);
                            if (empty($trimmed)) continue;
                        ?>
                            <p style="margin: 0; text-align: justify; text-justify: inter-word; hyphens: auto; -webkit-hyphens: auto;"><?= nl2br(htmlspecialchars($trimmed)) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Highlights Section -->
                <div style="background: var(--color-white); border-radius: var(--radius-lg); padding: 2.2rem; box-shadow: var(--shadow-sm); border: 1px solid var(--color-gray-200); margin-bottom: 2.5rem;">
                    <h3 style="font-size: 1.45rem; color: var(--color-primary-dark); margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.6rem;">
                        <i class="fa-solid fa-star" style="color: var(--color-volcano);"></i> <?= t('tour_highlights') ?>
                    </h3>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.85rem;">
                        <?php foreach ($highlights as $h): ?>
                            <li style="display: flex; align-items: flex-start; gap: 0.75rem; font-size: 1rem; color: var(--color-gray-700);">
                                <i class="fa-solid fa-circle-check" style="color: var(--color-accent); font-size: 1.15rem; margin-top: 0.2rem;"></i>
                                <span><?= htmlspecialchars($h) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Image Gallery Lightbox (Alpine.js) -->
                <div style="background: var(--color-white); border-radius: var(--radius-lg); padding: 2.2rem; box-shadow: var(--shadow-sm); border: 1px solid var(--color-gray-200); margin-bottom: 2.5rem;" x-data="{
                    activeImg: '<?= BASE_URL ?>/<?= htmlspecialchars($tour['gallery'][0] ?? $tour['image']) ?>',
                    modalOpen: false
                }">
                    <h3 style="font-size: 1.45rem; color: var(--color-primary-dark); margin-bottom: 1.2rem;">
                        <i class="fa-solid fa-camera" style="color: var(--color-primary);"></i> Galleria Fotografica
                    </h3>
                    
                    <!-- Main Active Photo -->
                    <div style="border-radius: var(--radius-md); overflow: hidden; max-height: 420px; height: clamp(260px, 50vw, 420px); margin-bottom: 1rem; cursor: pointer; background: var(--color-gray-100); border: 1px solid var(--color-gray-200);" @click="modalOpen = true">
                        <img :src="activeImg" alt="<?= htmlspecialchars($title) ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" class="hover:scale-105">
                    </div>

                    <!-- Thumbnails Carousel / Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(75px, 1fr)); gap: 0.65rem;">
                        <?php foreach ($tour['gallery'] as $img): ?>
                            <div style="border-radius: var(--radius-sm); overflow: hidden; height: 75px; cursor: pointer; border: 2.5px solid transparent; transition: all 0.2s ease; background: var(--color-gray-100);" 
                                 :style="activeImg === '<?= BASE_URL ?>/<?= htmlspecialchars($img) ?>' ? 'border-color: var(--color-primary); box-shadow: 0 0 0 1px var(--color-primary);' : 'opacity: 0.85;'"
                                 @click="activeImg = '<?= BASE_URL ?>/<?= htmlspecialchars($img) ?>'">
                                <img src="<?= BASE_URL ?>/<?= htmlspecialchars($img) ?>" alt="thumb" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Included & Excluded Breakdown -->
                <div class="tour-inc-exc-grid">
                    <!-- Included -->
                    <div style="background: #f0fdf4; border: 1.5px solid rgba(144, 201, 92, 0.6); border-radius: var(--radius-lg); padding: 1.8rem;">
                        <h4 style="font-size: 1.2rem; color: #166534; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-check"></i> <?= t('tour_included') ?>
                        </h4>
                        <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.6rem; font-size: 0.92rem; color: #14532d;">
                            <?php foreach ($included as $inc): ?>
                                <li style="display: flex; gap: 0.5rem; align-items: flex-start;">
                                    <i class="fa-solid fa-check" style="margin-top: 0.2rem; color: #15803d;"></i>
                                    <span><?= htmlspecialchars($inc) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Excluded -->
                    <div style="background: #fff1f2; border: 1.5px solid rgba(244, 63, 94, 0.4); border-radius: var(--radius-lg); padding: 1.8rem;">
                        <h4 style="font-size: 1.2rem; color: #9f1239; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-xmark"></i> <?= t('tour_excluded') ?>
                        </h4>
                        <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.6rem; font-size: 0.92rem; color: #881337;">
                            <?php foreach ($excluded as $exc): ?>
                                <li style="display: flex; gap: 0.5rem; align-items: flex-start;">
                                    <i class="fa-solid fa-minus" style="margin-top: 0.2rem; color: #be123c;"></i>
                                    <span><?= htmlspecialchars($exc) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sticky Booking Card -->
            <div style="position: sticky; top: 100px;">
                <div style="background: var(--color-white); border-radius: var(--radius-xl); padding: 2.2rem; box-shadow: var(--shadow-xl); border: 1.5px solid rgba(144, 201, 92, 0.5);">
                    <div style="margin-bottom: 1.2rem; border-bottom: 1px solid var(--color-gray-100); padding-bottom: 1.2rem;">
                        <span style="font-size: 0.85rem; color: var(--color-gray-500); text-transform: uppercase; font-weight: 700;"><?= t('tour_price_from') ?></span>
                        <div style="display: flex; align-items: baseline; gap: 0.4rem; margin-top: 0.2rem;">
                            <span style="font-size: 2.4rem; font-weight: 800; color: var(--color-primary-dark);">€<?= htmlspecialchars($tour['price']) ?></span>
                            <span style="font-size: 0.88rem; color: var(--color-gray-500);"><?= CURRENT_LANG === 'en' ? $tour['price_note_en'] : $tour['price_note'] ?></span>
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem; font-size: 0.9rem; color: var(--color-gray-600); display: flex; flex-direction: column; gap: 0.6rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span><i class="fa-solid fa-map-pin" style="color: var(--color-primary);"></i> Partenza da:</span>
                            <strong style="color: var(--color-gray-800);"><?= htmlspecialchars($tour['start_location']) ?></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span><i class="fa-solid fa-users" style="color: var(--color-primary);"></i> Gruppi:</span>
                            <strong style="color: var(--color-gray-800);">Min. 2 - Max 12 persone</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span><i class="fa-solid fa-bicycle" style="color: var(--color-primary);"></i> Mezzo:</span>
                            <strong style="color: var(--color-gray-800);">E-Bike MTB Inclusa</strong>
                        </div>
                    </div>

                    <button class="btn btn-accent btn-lg" style="width: 100%; margin-bottom: 0.85rem;" @click="openBooking(<?= htmlspecialchars(json_encode([
                        'id' => $tour['id'],
                        'slug' => $tour['slug'],
                        'title' => $title,
                        'price' => $tour['price'],
                        'duration' => $duration
                    ])) ?>)">
                        <i class="fa-solid fa-calendar-check"></i> Prenota / Richiedi Data
                    </button>

                    <a href="https://wa.me/<?= WA_NUMBER ?>?text=<?= urlencode('Ciao Mariella! Vorrei prenotare o chiedere info per il tour: ' . $title) ?>" target="_blank" class="btn btn-outline-primary" style="width: 100%; margin-bottom: 1.5rem;">
                        <i class="fa-brands fa-whatsapp"></i> Chiedi subito su WhatsApp
                    </a>

                    <div style="text-align: center; font-size: 0.8rem; color: var(--color-gray-500); border-top: 1px solid var(--color-gray-100); padding-top: 1rem;">
                        <i class="fa-solid fa-shield-halved" style="color: var(--color-primary);"></i> Cancellazione gratuita fino a 48h prima o cambio data in caso di maltempo.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Mobile Sticky Bottom Booking CTA Bar -->
<div class="mobile-sticky-cta">
    <div class="price-box">
        <span class="price-lbl"><?= t('tour_price_from') ?></span>
        <span class="price-val">€<?= htmlspecialchars($tour['price']) ?></span>
    </div>
    <div class="cta-actions">
        <a href="https://wa.me/<?= WA_NUMBER ?>?text=<?= urlencode('Ciao Mariella! Vorrei info per il tour: ' . $title) ?>" target="_blank" class="btn btn-sm" style="background: #25D366; color: #fff; padding: 0.65rem 0.85rem;" aria-label="WhatsApp">
            <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem;"></i>
        </a>
        <button class="btn btn-accent btn-sm" @click="openBooking(<?= htmlspecialchars(json_encode([
            'id' => $tour['id'],
            'slug' => $tour['slug'],
            'title' => $title,
            'price' => $tour['price'],
            'duration' => $duration
        ])) ?>)">
            <i class="fa-solid fa-calendar-check"></i> Prenota Ora
        </button>
    </div>
</div>

<script>
document.body.classList.add('has-sticky-cta');
</script>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
