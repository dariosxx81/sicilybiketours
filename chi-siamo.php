<?php
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Chi Siamo | Sicily Bike Tours - La Passione di Mariella per la Sicilia in Bici';
$pageDescription = 'Scopri la storia di Mariella e del team di Sicily Bike Tours: guide cicloturistiche locali, escursioni autentiche in e-bike e amore per la nostra terra.';

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/navbar.php';
?>

<!-- Header Banner -->
<section style="background: linear-gradient(rgba(15, 44, 48, 0.85), rgba(15, 44, 48, 0.95)), url('<?= BASE_URL ?>/assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-106.jpg') center/cover no-repeat; padding: 8.5rem 0 4rem 0; color: var(--color-white); text-align: center;">
    <div class="container">
        <span class="badge badge-accent" style="margin-bottom: 0.8rem;">
            <i class="fa-solid fa-heart"></i> <?= t('nav_about') ?>
        </span>
        <h1 style="font-size: clamp(2.2rem, 4vw, 3.2rem); color: var(--color-white); margin-bottom: 1rem;">
            <?= CURRENT_LANG === 'en' ? 'Who We Are & Our Passion' : 'La Nostra Storia & la Passione per la Sicilia' ?>
        </h1>
        <p style="font-size: 1.15rem; color: rgba(255, 255, 255, 0.85); max-width: 700px; margin: 0 auto;">
            <?= CURRENT_LANG === 'en' ? 'Transforming a childhood love for nature and bicycles into unforgettable experiences across our island.' : 'Trasformare l\'amore per la natura e la bicicletta in avventure indimenticabili alla scoperta degli angoli più veri della Sicilia.' ?>
        </p>
    </div>
</section>

<!-- Story Section -->
<section class="section-spacing" style="background: var(--color-white);">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1.1fr; gap: 4rem; align-items: center;">
            <div style="position: relative;">
                <div style="border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-xl); height: 480px;">
                    <img src="<?= BASE_URL ?>/assets/img/gallery/escursioni-in-bicicletta-sicilia-tour-in-bici-sicilia-escursioni-sulletna-escursioni-sui-nebrodi-escursioni-alcantara-58.jpg" alt="Mariella e le guide Sicily Bike Tours" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="position: absolute; bottom: -1.5rem; right: -1.5rem; background: var(--color-primary); color: var(--color-white); padding: 1.5rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); max-width: 240px;">
                    <div style="font-size: 2rem; font-weight: 800; color: var(--color-accent); line-height: 1;">100%</div>
                    <div style="font-size: 0.88rem; margin-top: 0.3rem;">Sicilia Autentica, Guide Certificate & Amore per il Territorio</div>
                </div>
            </div>

            <div>
                <span class="section-tag"><i class="fa-solid fa-seedling"></i> La Nostra Missione</span>
                <h2 style="font-size: 2.3rem; color: var(--color-primary-dark); margin-bottom: 1.4rem;">
                    Vivi la Sicilia, pedala con noi
                </h2>
                
                <p style="font-size: 1.05rem; color: var(--color-gray-700); margin-bottom: 1.2rem; line-height: 1.7;">
                    <strong>Mariella</strong>, fondatrice e appassionata ciclista locale, ha trasformato la sua passione in una realtà dedicata a viaggiatori provenienti da tutto il mondo. Insieme a un team di guide esperte del territorio, condividiamo i segreti dell'isola con chi desidera conoscerla in modo autentico, lento e rispettoso.
                </p>

                <p style="font-size: 1.05rem; color: var(--color-gray-700); margin-bottom: 1.5rem; line-height: 1.7;">
                    Ogni tour è curato nei minimi dettagli per offrirvi un'esperienza sicura, ricca di emozioni e fuori dai classici percorsi di massa. Dalle creste laviche dell'Etna ai borghi medievali dei Nebrodi e alle acque cristalline delle Isole Eolie, ogni pedalata è un'opportunità per assaporare la storia, la cultura e l'enogastronomia genuina della nostra terra.
                </p>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-top: 2rem;">
                    <div style="background: var(--color-gray-50); padding: 1.2rem; border-radius: var(--radius-md); border-left: 4px solid var(--color-accent);">
                        <strong style="display: block; font-size: 1.05rem; color: var(--color-primary-dark); margin-bottom: 0.3rem;">Per Tutti (6-99 anni)</strong>
                        <span style="font-size: 0.85rem; color: var(--color-gray-600);">L'e-bike elimina lo sforzo in salita e rende il viaggio un puro piacere per gruppi e famiglie.</span>
                    </div>

                    <div style="background: var(--color-gray-50); padding: 1.2rem; border-radius: var(--radius-md); border-left: 4px solid var(--color-primary);">
                        <strong style="display: block; font-size: 1.05rem; color: var(--color-primary-dark); margin-bottom: 0.3rem;">Massima Sicurezza</strong>
                        <span style="font-size: 0.85rem; color: var(--color-gray-600);">Furgone d'appoggio al seguito, caschi omologati, kit riparazione e assicurazione inclusa.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bike Fleet Section -->
<section class="section-spacing" style="background: var(--color-gray-50);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="fa-solid fa-bicycle"></i> Il Nostro Parco Bici</span>
            <h2 class="section-title">E-Bike di Ultima Generazione</h2>
            <p class="section-subtitle">Comfort, potenza e affidabilità per ogni tipo di terreno: dalle piste vulcaniche alle strade panoramiche.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            <div class="feature-card">
                <div class="feature-icon-box">
                    <i class="fa-solid fa-mountain" style="font-size: 1.4rem;"></i>
                </div>
                <h4>E-MTB Full Suspension</h4>
                <p>Doppia ammortizzazione anteriore e posteriore, motori potenti (fino a 85Nm) e batteria da 625/750Wh per affrontare sentieri sconnessi, discese e pietraie in totale relax.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon-box">
                    <i class="fa-solid fa-route" style="font-size: 1.4rem;"></i>
                </div>
                <h4>E-MTB Front</h4>
                <p>Ammortizzatore anteriore, peso contenuto e grande agilità. La scelta ideale per le escursioni giornaliere su strade bianche, boschi e strade panoramiche collinari.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon-box">
                    <i class="fa-solid fa-toolbox" style="font-size: 1.4rem;"></i>
                </div>
                <h4>Equipaggiamento & Accessori</h4>
                <p>Caschi omologati igienizzati ad ogni uscita, sacche idriche, kit forature, borse da cicloturismo per i tour plurigiornalieri e batterie di scorta nel van di supporto.</p>
            </div>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
