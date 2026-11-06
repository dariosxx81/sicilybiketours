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
$itinerary = CURRENT_LANG === 'en' ? ($tour['itinerary_en'] ?? $tour['itinerary'] ?? '') : ($tour['itinerary'] ?? $tour['itinerary_summary'] ?? '');
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

                <?php 
                $fullStory = !empty($itinerary) ? $itinerary : (!empty($tour['itinerary_summary']) ? $tour['itinerary_summary'] : $description);
                if (!empty($fullStory)): 
                ?>
                <!-- Full Description & Detailed Itinerary (Official Content from WordPress) -->
                <div style="background: var(--color-white); border-radius: var(--radius-lg); padding: 2.2rem; box-shadow: var(--shadow-sm); border: 1px solid var(--color-gray-200); margin-bottom: 2.5rem;">
                    <h3 style="font-size: 1.45rem; color: var(--color-primary-dark); margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.6rem;">
                        <i class="fa-solid fa-map-location-dot" style="color: var(--color-primary);"></i> Itinerario & Descrizione Completa
                    </h3>
                    
                    <div style="font-size: 1.02rem; line-height: 1.8; color: var(--color-gray-700); display: flex; flex-direction: column; gap: 1.1rem;">
                        <?php 
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
                <?php 
                $galleryImages = !empty($tour['gallery']) ? $tour['gallery'] : [$tour['image']];
                $galleryJson = json_encode(array_values(array_map(function($img) {
                    $clean = ltrim($img, '/');
                    $fullPath = BASE_PATH . '/' . $clean;
                    $ver = file_exists($fullPath) ? filemtime($fullPath) : 1;
                    return BASE_URL . '/' . $clean . '?v=' . $ver;
                }, $galleryImages)));
                ?>
                <style>
                .tour-gallery-thumbs {
                    display: grid !important;
                    grid-template-columns: repeat(auto-fill, minmax(72px, 1fr)) !important;
                    gap: 0.65rem !important;
                    width: 100% !important;
                }
                .tour-gallery-thumb {
                    position: relative !important;
                    width: 100% !important;
                    aspect-ratio: 1 / 1 !important;
                    border-radius: var(--radius-sm);
                    overflow: hidden !important;
                    cursor: pointer;
                    border: 2.5px solid transparent !important;
                    background: var(--color-gray-100);
                    transition: all 0.2s ease;
                    box-sizing: border-box !important;
                }
                .tour-gallery-thumb img {
                    position: absolute !important;
                    top: 0 !important;
                    left: 0 !important;
                    width: 100% !important;
                    height: 100% !important;
                    object-fit: cover !important;
                    display: block !important;
                }
                .tour-gallery-thumb.is-active {
                    border-color: var(--color-primary) !important;
                    box-shadow: 0 0 0 1px var(--color-primary) !important;
                    opacity: 1 !important;
                    transform: scale(0.96);
                }
                .tour-gallery-thumb:not(.is-active) {
                    opacity: 0.7;
                }
                .tour-gallery-thumb:hover {
                    opacity: 1;
                }

                /* Fullscreen Lightbox Modal */
                .tour-lightbox-modal {
                    position: fixed !important;
                    top: 0 !important;
                    left: 0 !important;
                    width: 100vw !important;
                    height: 100vh !important;
                    z-index: 999999 !important;
                    background: rgba(0, 0, 0, 0.94) !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    padding: 2rem !important;
                    box-sizing: border-box !important;
                }
                .tour-lightbox-modal[style*="display: none"] {
                    display: none !important;
                }
                .tour-lightbox-img {
                    max-width: 90vw !important;
                    max-height: 85vh !important;
                    width: auto !important;
                    height: auto !important;
                    object-fit: contain !important;
                    margin: auto !important;
                    display: block !important;
                    border-radius: var(--radius-sm);
                    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.8) !important;
                    user-select: none;
                }
                .tour-lightbox-close {
                    position: absolute !important;
                    top: 20px !important;
                    right: 25px !important;
                    background: rgba(255, 255, 255, 0.15) !important;
                    border: none !important;
                    color: #fff !important;
                    width: 44px !important;
                    height: 44px !important;
                    border-radius: 50% !important;
                    font-size: 1.4rem !important;
                    cursor: pointer !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    transition: background 0.2s ease !important;
                    z-index: 1000000 !important;
                }
                .tour-lightbox-close:hover {
                    background: rgba(255, 255, 255, 0.3) !important;
                }
                .tour-lightbox-counter {
                    position: absolute !important;
                    top: 25px !important;
                    left: 25px !important;
                    color: rgba(255, 255, 255, 0.85) !important;
                    font-size: 0.95rem !important;
                    font-weight: 600 !important;
                    z-index: 1000000 !important;
                }
                .tour-lightbox-nav {
                    position: absolute !important;
                    top: 50% !important;
                    transform: translateY(-50%) !important;
                    width: 50px !important;
                    height: 50px !important;
                    border-radius: 50% !important;
                    background: rgba(255, 255, 255, 0.15) !important;
                    color: #fff !important;
                    border: 1px solid rgba(255, 255, 255, 0.25) !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    cursor: pointer !important;
                    font-size: 1.2rem !important;
                    transition: background 0.2s ease !important;
                    z-index: 1000000 !important;
                }
                .tour-lightbox-nav:hover {
                    background: rgba(255, 255, 255, 0.3) !important;
                }
                .tour-lightbox-nav.prev {
                    left: 20px !important;
                }
                .tour-lightbox-nav.next {
                    right: 20px !important;
                }
                </style>
                <div style="background: var(--color-white); border-radius: var(--radius-lg); padding: 2.2rem; box-shadow: var(--shadow-sm); border: 1px solid var(--color-gray-200); margin-bottom: 2.5rem;" 
                     x-data="{
                        images: <?= htmlspecialchars($galleryJson) ?>,
                        currentIndex: 0,
                        modalOpen: false,
                        next() {
                            this.currentIndex = (this.currentIndex + 1) % this.images.length;
                        },
                        prev() {
                            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                        }
                     }"
                     @keydown.escape.window="modalOpen = false"
                     @keydown.arrow-right.window="modalOpen && next()"
                     @keydown.arrow-left.window="modalOpen && prev()">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
                        <h3 style="font-size: 1.45rem; color: var(--color-primary-dark); margin: 0; display: flex; align-items: center; gap: 0.6rem;">
                            <i class="fa-solid fa-camera" style="color: var(--color-primary);"></i> Galleria Fotografica
                        </h3>
                        <span style="font-size: 0.85rem; color: var(--color-gray-500); font-weight: 600;" x-text="(currentIndex + 1) + ' / ' + images.length + ' foto'"></span>
                    </div>
                    
                    <!-- Main Active Photo with Navigation Arrows -->
                    <div style="position: relative; border-radius: var(--radius-md); overflow: hidden; max-height: 440px; height: clamp(260px, 50vw, 440px); margin-bottom: 1rem; background: var(--color-gray-900); border: 1px solid var(--color-gray-200); user-select: none;">
                        <img :src="images[currentIndex]" alt="<?= htmlspecialchars($title) ?>" 
                             style="width: 100%; height: 100%; object-fit: cover; cursor: pointer; transition: opacity 0.3s ease;" 
                             @click="modalOpen = true">

                        <!-- Prev Button -->
                        <button type="button" @click.stop="prev()" 
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; border-radius: 50%; background: rgba(15, 44, 48, 0.75); color: #fff; border: 1px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; cursor: pointer; backdrop-filter: blur(4px); transition: background 0.2s;"
                                onmouseover="this.style.background='rgba(15, 44, 48, 0.95)'" 
                                onmouseout="this.style.background='rgba(15, 44, 48, 0.75)'"
                                aria-label="Foto precedente">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <!-- Next Button -->
                        <button type="button" @click.stop="next()" 
                                style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; border-radius: 50%; background: rgba(15, 44, 48, 0.75); color: #fff; border: 1px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; cursor: pointer; backdrop-filter: blur(4px); transition: background 0.2s;"
                                onmouseover="this.style.background='rgba(15, 44, 48, 0.95)'" 
                                onmouseout="this.style.background='rgba(15, 44, 48, 0.75)'"
                                aria-label="Foto successiva">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>

                        <!-- Zoom Indicator Pill -->
                        <div style="position: absolute; bottom: 12px; right: 12px; background: rgba(0, 0, 0, 0.65); color: #fff; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8rem; display: flex; align-items: center; gap: 0.4rem; pointer-events: none; backdrop-filter: blur(4px);">
                            <i class="fa-solid fa-expand"></i> Clicca per ingrandire
                        </div>
                    </div>

                    <!-- Thumbnails Carousel / Grid -->
                    <div class="tour-gallery-thumbs">
                        <?php foreach ($galleryImages as $idx => $img): ?>
                            <?php 
                            $cleanThumb = BASE_URL . '/' . ltrim($img, '/');
                            $fullThumbPath = BASE_PATH . '/' . ltrim($img, '/');
                            $verThumb = file_exists($fullThumbPath) ? filemtime($fullThumbPath) : 1;
                            $thumbSrc = $cleanThumb . '?v=' . $verThumb;
                            ?>
                            <div class="tour-gallery-thumb" 
                                 :class="{ 'is-active': currentIndex === <?= $idx ?> }"
                                 @click="currentIndex = <?= $idx ?>">
                                <img src="<?= htmlspecialchars($thumbSrc) ?>" alt="thumb <?= $idx + 1 ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Fullscreen Lightbox Modal -->
                    <div x-show="modalOpen" 
                         x-transition.opacity.duration.250ms
                         class="tour-lightbox-modal"
                         @click.self="modalOpen = false">
                        
                        <!-- Close button -->
                        <button type="button" @click="modalOpen = false" 
                                class="tour-lightbox-close"
                                aria-label="Chiudi galleria">
                            <i class="fa-solid fa-xmark"></i>
                        </button>

                        <!-- Counter -->
                        <div class="tour-lightbox-counter" 
                             x-text="(currentIndex + 1) + ' di ' + images.length"></div>

                        <!-- Modal Prev -->
                        <button type="button" @click.stop="prev()" 
                                class="tour-lightbox-nav prev"
                                aria-label="Foto precedente">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <!-- Main Big Image (Centered) -->
                        <img :src="images[currentIndex]" alt="<?= htmlspecialchars($title) ?>" 
                             class="tour-lightbox-img">

                        <!-- Modal Next -->
                        <button type="button" @click.stop="next()" 
                                class="tour-lightbox-nav next"
                                aria-label="Foto successiva">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
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
                <div style="background: var(--color-white); border-radius: 0; padding: 2.2rem; box-shadow: var(--shadow-xl); border: 1.5px solid rgba(144, 201, 92, 0.5);">
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
