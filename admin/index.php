<?php
require_once __DIR__ . '/../config/config.php';

$settingsFile = BASE_PATH . '/data/settings.json';
$currentSettings = file_exists($settingsFile) ? json_decode(file_get_contents($settingsFile), true) : [];
$savedMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentSettings['site_name'] = $_POST['site_name'] ?? $currentSettings['site_name'];
    $currentSettings['site_tagline'] = $_POST['site_tagline'] ?? $currentSettings['site_tagline'];
    $currentSettings['contact_phone'] = $_POST['contact_phone'] ?? $currentSettings['contact_phone'];
    $currentSettings['wa_number'] = preg_replace('/[^0-9]/', '', $_POST['wa_number'] ?? $currentSettings['wa_number']);
    $currentSettings['contact_email'] = $_POST['contact_email'] ?? $currentSettings['contact_email'];
    $currentSettings['contact_address'] = $_POST['contact_address'] ?? $currentSettings['contact_address'];
    $currentSettings['instagram_url'] = $_POST['instagram_url'] ?? $currentSettings['instagram_url'];
    $currentSettings['facebook_url'] = $_POST['facebook_url'] ?? $currentSettings['facebook_url'];

    file_put_contents($settingsFile, json_encode($currentSettings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $savedMessage = 'Impostazioni aggiornate con successo!';
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannello di Gestione | Sicily Bike Tours</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="<?= BASE_URL ?>/assets/js/alpine.min.js"></script>
</head>
<body style="background: var(--color-gray-100); padding: 3rem 1rem;">
    <div class="container container-narrow">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
            <div>
                <a href="<?= BASE_URL ?>/" class="btn btn-outline-primary btn-sm" style="margin-bottom: 0.5rem;">
                    <i class="fa-solid fa-arrow-left"></i> Torna al Sito Pubblico
                </a>
                <h1 style="font-size: 2rem; color: var(--color-primary-dark);">Pannello di Configurazione</h1>
                <p style="color: var(--color-gray-600); font-size: 0.95rem;">Modifica recapiti, WhatsApp, partner e consulta tour e articoli del magazine.</p>
            </div>
            <img src="<?= BASE_URL ?>/assets/img/logo/logo.png" alt="Logo" style="height: 50px;">
        </div>

        <?php if ($savedMessage): ?>
            <div style="background: #f0fdf4; border: 1.5px solid var(--color-accent); color: #166534; padding: 1.2rem; border-radius: var(--radius-md); margin-bottom: 2rem; font-weight: 700; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fa-solid fa-circle-check" style="font-size: 1.4rem; color: var(--color-accent);"></i>
                <?= htmlspecialchars($savedMessage) ?>
            </div>
        <?php endif; ?>

        <!-- General Settings Form -->
        <div style="background: var(--color-white); border-radius: var(--radius-xl); padding: 2.5rem; box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-200); margin-bottom: 2.5rem;">
            <form method="POST">
                <h3 style="font-size: 1.3rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--color-gray-100); padding-bottom: 0.75rem; color: var(--color-primary-dark);">
                    <i class="fa-solid fa-address-card" style="color: var(--color-primary);"></i> Recapiti & WhatsApp
                </h3>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Telefono Visualizzato</label>
                        <input type="text" name="contact_phone" class="form-control" value="<?= htmlspecialchars($currentSettings['contact_phone'] ?? CONTACT_PHONE) ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Numero WhatsApp (senza + o spazi, es. 393297568883)</label>
                        <input type="text" name="wa_number" class="form-control" value="<?= htmlspecialchars($currentSettings['wa_number'] ?? WA_NUMBER) ?>" required>
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Email di Ricezione Prenotazioni</label>
                        <input type="email" name="contact_email" class="form-control" value="<?= htmlspecialchars($currentSettings['contact_email'] ?? CONTACT_EMAIL) ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Indirizzo Sede / Base</label>
                        <input type="text" name="contact_address" class="form-control" value="<?= htmlspecialchars($currentSettings['contact_address'] ?? CONTACT_ADDRESS) ?>" required>
                    </div>
                </div>

                <h3 style="font-size: 1.3rem; margin: 2rem 0 1.5rem 0; border-bottom: 1px solid var(--color-gray-100); padding-bottom: 0.75rem; color: var(--color-primary-dark);">
                    <i class="fa-solid fa-share-nodes" style="color: var(--color-primary);"></i> Social & Canali
                </h3>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Instagram Link</label>
                        <input type="url" name="instagram_url" class="form-control" value="<?= htmlspecialchars($currentSettings['instagram_url'] ?? INSTAGRAM_URL) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Facebook Group Link</label>
                        <input type="url" name="facebook_url" class="form-control" value="<?= htmlspecialchars($currentSettings['facebook_url'] ?? FACEBOOK_URL) ?>">
                    </div>
                </div>

                <div style="margin-top: 2.5rem; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fa-solid fa-floppy-disk"></i> Salva Modifiche
                    </button>
                </div>
            </form>
        </div>

        <!-- Partners Management Box -->
        <div style="background: var(--color-white); border-radius: var(--radius-xl); padding: 2rem; box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-200); margin-bottom: 2.5rem;">
            <h3 style="font-size: 1.3rem; margin-bottom: 1rem; color: var(--color-primary-dark);">
                <i class="fa-solid fa-handshake" style="color: var(--color-primary);"></i> Partner Configurati in Home Page (<?= count($currentSettings['partners'] ?? []) ?>)
            </h3>
            <p style="font-size: 0.9rem; color: var(--color-gray-600); margin-bottom: 1.5rem;">I partner mostrati nella home page del sito per accrescere la fiducia dei clienti.</p>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1rem;">
                <?php foreach (($currentSettings['partners'] ?? []) as $p): ?>
                    <div style="padding: 1rem; background: var(--color-gray-50); border: 1px solid var(--color-gray-200); border-radius: var(--radius-md); display: flex; align-items: center; gap: 0.75rem;">
                        <i class="<?= htmlspecialchars($p['icon'] ?? 'fa-solid fa-check') ?>" style="font-size: 1.3rem; color: var(--color-primary);"></i>
                        <div>
                            <strong style="display: block; font-size: 0.95rem; color: var(--color-primary-dark);"><?= htmlspecialchars($p['name']) ?></strong>
                            <span style="font-size: 0.78rem; color: var(--color-gray-500);"><?= htmlspecialchars($p['role_it']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Magazine Articles Summary Box -->
        <div style="background: var(--color-white); border-radius: var(--radius-xl); padding: 2rem; box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-200); margin-bottom: 2.5rem;">
            <h3 style="font-size: 1.3rem; margin-bottom: 1rem; color: var(--color-primary-dark);">
                <i class="fa-solid fa-newspaper" style="color: var(--color-primary);"></i> Articoli Magazine Pubblicati (<?= count($articles) ?> Articoli)
            </h3>
            <p style="font-size: 0.9rem; color: var(--color-gray-600); margin-bottom: 1.5rem;">Articoli ottimizzati per la SEO turistica internazionale (Etna, Nebrodi, Eolie).</p>

            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <?php foreach ($articles as $art): ?>
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: var(--color-gray-50); border-radius: var(--radius-md); border: 1px solid var(--color-gray-200); flex-wrap: wrap; gap: 0.5rem;">
                        <div>
                            <strong style="color: var(--color-primary-dark);"><?= htmlspecialchars($art['title']) ?></strong>
                            <span style="font-size: 0.8rem; color: var(--color-gray-500); margin-left: 0.5rem;">(<?= htmlspecialchars($art['category']) ?> | <?= htmlspecialchars($art['date']) ?>)</span>
                        </div>
                        <a href="<?= BASE_URL ?>/articolo.php?slug=<?= urlencode($art['slug']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Leggi
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tour Quick List Summary -->
        <div style="background: var(--color-white); border-radius: var(--radius-xl); padding: 2rem; box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-200);">
            <h3 style="font-size: 1.3rem; margin-bottom: 1rem; color: var(--color-primary-dark);">
                <i class="fa-solid fa-bicycle" style="color: var(--color-primary);"></i> Catalogo Tour Registrati (<?= count($tours) ?> Tour)
            </h3>
            <p style="font-size: 0.9rem; color: var(--color-gray-600); margin-bottom: 1.5rem;">I dati dettagliati dei tour sono sincronizzati nel file centralizzato <code>data/tours.php</code>.</p>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <?php foreach ($tours as $t): ?>
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: var(--color-gray-50); border-radius: var(--radius-md); border: 1px solid var(--color-gray-200);">
                        <div>
                            <strong style="color: var(--color-primary-dark);"><?= htmlspecialchars($t['title']) ?></strong>
                            <span style="font-size: 0.8rem; color: var(--color-gray-500); margin-left: 0.5rem;">(<?= htmlspecialchars($t['type']) ?> | <?= htmlspecialchars($t['area']) ?>)</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span style="font-weight: 800; color: var(--color-primary);">€<?= $t['price'] ?></span>
                            <a href="<?= BASE_URL ?>/tour-dettaglio.php?slug=<?= urlencode($t['slug']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fa-solid fa-eye"></i> Vedi Pagina
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
