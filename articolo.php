<?php
require_once __DIR__ . '/config/config.php';

$slug = $_GET['slug'] ?? 'guida-ebike-etna-percorsi-consigli';
$article = get_article_by_slug($slug);

if (!$article) {
    $article = $articles[0];
}

$title = CURRENT_LANG === 'en' ? ($article['title_en'] ?? $article['title']) : $article['title'];
$excerpt = CURRENT_LANG === 'en' ? ($article['excerpt_en'] ?? $article['excerpt']) : $article['excerpt'];
$content = CURRENT_LANG === 'en' ? ($article['content_en'] ?? $article['content_it']) : $article['content_it'];
$category = CURRENT_LANG === 'en' ? ($article['category_en'] ?? $article['category']) : $article['category'];
$date = CURRENT_LANG === 'en' ? ($article['date_en'] ?? $article['date']) : $article['date'];

$pageTitle = $title . ' | Sicily Bike Magazine';
$pageDescription = $excerpt;
$pageImage = BASE_URL . '/' . $article['image'];

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/navbar.php';
?>

<!-- Article Header -->
<section style="background: linear-gradient(rgba(15, 44, 48, 0.88), rgba(15, 44, 48, 0.96)), url('<?= BASE_URL ?>/<?= htmlspecialchars($article['image']) ?>') center/cover no-repeat; padding: 8.5rem 0 4rem 0; color: var(--color-white);">
    <div class="container container-narrow">
        <div style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.7); margin-bottom: 1.2rem; display: flex; gap: 0.5rem; align-items: center;">
            <a href="<?= BASE_URL ?>/">Home</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i>
            <a href="<?= BASE_URL ?>/magazine.php">Magazine</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i>
            <span style="color: var(--color-accent);"><?= htmlspecialchars($category) ?></span>
        </div>

        <div style="display: flex; gap: 0.75rem; align-items: center; margin-bottom: 1rem; flex-wrap: wrap;">
            <span class="badge badge-accent"><?= htmlspecialchars($category) ?></span>
            <span style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.8);"><i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($date) ?></span>
            <span style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.8);"><i class="fa-regular fa-clock"></i> <?= htmlspecialchars($article['read_time']) ?> di lettura</span>
        </div>

        <h1 style="font-size: clamp(2rem, 3.5vw, 2.8rem); color: var(--color-white); line-height: 1.25; margin-bottom: 1.2rem;">
            <?= htmlspecialchars($title) ?>
        </h1>

        <div style="display: flex; align-items: center; gap: 0.8rem;">
            <div style="width: 44px; height: 44px; border-radius: 50%; background: var(--color-accent); color: var(--color-primary-dark); display: flex; align-items: center; justify-content: center; font-weight: 800;">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <strong style="display: block; font-size: 0.95rem; color: var(--color-white);"><?= htmlspecialchars($article['author']) ?></strong>
                <span style="font-size: 0.8rem; color: rgba(255, 255, 255, 0.7);"><?= htmlspecialchars($article['author_role']) ?></span>
            </div>
        </div>
    </div>
</section>

<!-- Article Body Content -->
<article class="section-spacing" style="background: var(--color-white);">
    <div class="container container-narrow">
        <!-- Featured Image -->
        <div style="border-radius: var(--radius-xl); overflow: hidden; height: 420px; box-shadow: var(--shadow-xl); margin-bottom: 3rem;">
            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($title) ?>" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        <!-- Text Content -->
        <div style="font-size: 1.12rem; line-height: 1.8; color: var(--color-gray-800);" class="article-content">
            <?= $content ?>
        </div>

        <!-- Share & Tags -->
        <div style="margin-top: 3.5rem; padding-top: 2rem; border-top: 1px solid var(--color-gray-200); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <span style="font-weight: 700; color: var(--color-primary-dark); font-size: 0.95rem;">
                <i class="fa-solid fa-share-nodes"></i> Condividi questa guida:
            </span>
            <div style="display: flex; gap: 0.6rem;">
                <a href="https://wa.me/?text=<?= urlencode($title . ' - Leggi su: ' . ('https://www.sicilybiketours.it/articolo.php?slug=' . $article['slug'])) ?>" target="_blank" class="btn btn-accent btn-sm">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('https://www.sicilybiketours.it/articolo.php?slug=' . $article['slug']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="fa-brands fa-facebook-f"></i> Facebook
                </a>
            </div>
        </div>

        <!-- CTA Box Related Tours -->
        <div style="margin-top: 3rem; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); border-radius: var(--radius-xl); padding: 2.5rem; color: var(--color-white); text-align: center; box-shadow: var(--shadow-xl);">
            <span class="badge badge-accent" style="margin-bottom: 0.75rem;">Pronto a pedalare?</span>
            <h3 style="font-size: 1.8rem; color: var(--color-white); margin-bottom: 0.8rem;">Vuoi vivere questa esperienza in prima persona?</h3>
            <p style="font-size: 1.05rem; color: rgba(255, 255, 255, 0.85); max-width: 580px; margin: 0 auto 1.8rem auto;">
                Scopri le nostre escursioni guidate giornaliere e i tour di più giorni adatti a qualsiasi livello.
            </p>
            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <a href="<?= BASE_URL ?>/escursioni.php" class="btn btn-accent btn-lg">
                    <i class="fa-solid fa-bicycle"></i> Guarda i Tour Disponibili
                </a>
                <a href="<?= BASE_URL ?>/personalizza-tour.php" class="btn btn-outline-white btn-lg">
                    <i class="fa-solid fa-sliders"></i> Crea Tour su Misura
                </a>
            </div>
        </div>
    </div>
</article>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
