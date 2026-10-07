<?php
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Contatti & Richiesta Preventivo | ' . SITE_NAME;
$pageDescription = 'Contatta Sicily Bike Tours per richiedere informazioni sulle escursioni in e-bike o per prenotare un tour personalizzato. Telefono, WhatsApp ed email.';

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/navbar.php';
?>

<!-- Header Banner -->
<section style="background: linear-gradient(rgba(15, 44, 48, 0.85), rgba(15, 44, 48, 0.95)), url('<?= BASE_URL ?>/assets/img/gallery/summit.jpg') center/cover no-repeat; padding: 8.5rem 0 4rem 0; color: var(--color-white); text-align: center;">
    <div class="container">
        <span class="badge badge-accent" style="margin-bottom: 0.8rem;">
            <i class="fa-solid fa-envelope"></i> <?= t('nav_contact') ?>
        </span>
        <h1 style="font-size: clamp(2.2rem, 4vw, 3.2rem); color: var(--color-white); margin-bottom: 1rem;">
            <?= CURRENT_LANG === 'en' ? 'Get in Touch with Us' : 'Contatti & Richieste' ?>
        </h1>
        <p style="font-size: 1.15rem; color: rgba(255, 255, 255, 0.85); max-width: 700px; margin: 0 auto;">
            <?= CURRENT_LANG === 'en' ? 'Questions about a tour or want to customize your cycling trip? We are here to help.' : 'Vuoi maggiori informazioni su un\'escursione o desideri organizzare un tour personalizzato? Scrivici o chiamaci.' ?>
        </p>
    </div>
</section>

<!-- Contact Form & Info Grid -->
<section class="section-spacing" style="background: var(--color-gray-50);">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1.3fr; gap: 3.5rem; align-items: start;">
            
            <!-- Left Contact Info Cards -->
            <div>
                <span class="section-tag"><i class="fa-solid fa-address-book"></i> Recapiti Diretti</span>
                <h2 style="font-size: 2rem; color: var(--color-primary-dark); margin-bottom: 1.5rem;">Siamo a tua completa disposizione</h2>
                
                <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 2.5rem;">
                    <div style="background: var(--color-white); border-radius: var(--radius-lg); padding: 1.4rem; box-shadow: var(--shadow-sm); border: 1px solid var(--color-gray-200); display: flex; align-items: center; gap: 1rem;">
                        <div class="feature-icon-box" style="margin-bottom: 0;">
                            <i class="fa-brands fa-whatsapp" style="font-size: 1.6rem; color: #25D366;"></i>
                        </div>
                        <div>
                            <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--color-gray-500); font-weight: 700;">WhatsApp Diretto (Consigliato)</span>
                            <a href="https://wa.me/<?= WA_NUMBER ?>" target="_blank" style="display: block; font-size: 1.15rem; font-weight: 800; color: var(--color-primary-dark);"><?= CONTACT_PHONE ?></a>
                        </div>
                    </div>

                    <div style="background: var(--color-white); border-radius: var(--radius-lg); padding: 1.4rem; box-shadow: var(--shadow-sm); border: 1px solid var(--color-gray-200); display: flex; align-items: center; gap: 1rem;">
                        <div class="feature-icon-box" style="margin-bottom: 0;">
                            <i class="fa-solid fa-envelope" style="font-size: 1.4rem;"></i>
                        </div>
                        <div>
                            <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--color-gray-500); font-weight: 700;">Email Ufficiale</span>
                            <a href="mailto:<?= CONTACT_EMAIL ?>" style="display: block; font-size: 1.15rem; font-weight: 800; color: var(--color-primary-dark);"><?= CONTACT_EMAIL ?></a>
                        </div>
                    </div>

                    <div style="background: var(--color-white); border-radius: var(--radius-lg); padding: 1.4rem; box-shadow: var(--shadow-sm); border: 1px solid var(--color-gray-200); display: flex; align-items: center; gap: 1rem;">
                        <div class="feature-icon-box" style="margin-bottom: 0;">
                            <i class="fa-solid fa-location-dot" style="font-size: 1.4rem;"></i>
                        </div>
                        <div>
                            <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--color-gray-500); font-weight: 700;">Sede Operativa</span>
                            <span style="display: block; font-size: 1rem; font-weight: 700; color: var(--color-primary-dark);"><?= CONTACT_ADDRESS ?></span>
                        </div>
                    </div>
                </div>

                <!-- Operating Info Box -->
                <div style="background: var(--color-accent-light); border: 1px solid rgba(144, 201, 92, 0.4); border-radius: var(--radius-lg); padding: 1.5rem;">
                    <h4 style="font-size: 1.1rem; color: var(--color-primary-dark); margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-clock"></i> Orari di Apertura & Partenze
                    </h4>
                    <p style="font-size: 0.9rem; color: var(--color-gray-700); line-height: 1.6;">
                        Siamo aperti tutti i giorni dal Lunedì alla Domenica dalle 08:00 alle 20:00.<br>
                        Le partenze dei tour guidati si svolgono regolarmente su prenotazione.
                    </p>
                </div>
            </div>

            <!-- Right Interactive Contact Form -->
            <div style="background: var(--color-white); border-radius: var(--radius-xl); padding: 2.5rem; box-shadow: var(--shadow-xl); border: 1px solid var(--color-gray-200);" x-data="{
                formType: 'giornaliera',
                selectedTourName: '',
                name: '',
                email: '',
                phone: '',
                date: '<?= date('Y-m-d', strtotime('+3 days')) ?>',
                riders: 2,
                hasEbikeExperience: 'yes',
                notes: '',
                sent: false,
                
                getFormWaLink() {
                    let msg = `*RICHIESTA DAL SITO SICILY BIKE TOURS*\n` +
                              `Tipologia: ${this.formType}\n` +
                              `Tour: ${this.selectedTourName || 'Generale'}\n` +
                              `Data: ${this.date}\n` +
                              `Partecipanti: ${this.riders}\n` +
                              `Nome: ${this.name}\n` +
                              `Email: ${this.email}\n` +
                              `Tel: ${this.phone}\n` +
                              `Note: ${this.notes || 'Nessuna'}`;
                    return `https://wa.me/<?= WA_NUMBER ?>?text=` + encodeURIComponent(msg);
                }
            }">
                <template x-if="!sent">
                    <form @submit.prevent="sent = true">
                        <h3 style="font-size: 1.6rem; color: var(--color-primary-dark); margin-bottom: 1.5rem;">Inviaci un Messaggio</h3>

                        <div class="form-group">
                            <label class="form-label">A quale tipologia di esperienza sei interessato?</label>
                            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                                <label style="display: flex; align-items: center; gap: 0.4rem; cursor: pointer; font-size: 0.95rem;">
                                    <input type="radio" name="ftype" value="giornaliera" x-model="formType"> Escursione Giornaliera
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.4rem; cursor: pointer; font-size: 0.95rem;">
                                    <input type="radio" name="ftype" value="plurigiornaliero" x-model="formType"> Tour di Più Giorni
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.4rem; cursor: pointer; font-size: 0.95rem;">
                                    <input type="radio" name="ftype" value="su-misura" x-model="formType"> Tour Personalizzato
                                </label>
                            </div>
                        </div>

                        <div class="form-group" x-show="formType !== 'su-misura'">
                            <label class="form-label">Seleziona il Tour:</label>
                            <select class="form-control" x-model="selectedTourName">
                                <option value="">-- Scegli un tour dal catalogo --</option>
                                <?php foreach ($tours as $t): ?>
                                    <option value="<?= htmlspecialchars($t['title']) ?>"><?= htmlspecialchars($t['title']) ?> (<?= htmlspecialchars($t['duration']) ?> - da €<?= $t['price'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-row-2">
                            <div class="form-group">
                                <label class="form-label"><?= t('form_name') ?> *</label>
                                <input type="text" class="form-control" placeholder="Mario Rossi" x-model="name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><?= t('form_phone') ?> *</label>
                                <input type="tel" class="form-control" placeholder="+39 333 1234567" x-model="phone" required>
                            </div>
                        </div>

                        <div class="form-row-2">
                            <div class="form-group">
                                <label class="form-label"><?= t('form_email') ?> *</label>
                                <input type="email" class="form-control" placeholder="mario@email.com" x-model="email" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Data Desiderata</label>
                                <input type="date" class="form-control" x-model="date" min="<?= date('Y-m-d') ?>">
                            </div>
                        </div>

                        <div class="form-row-2">
                            <div class="form-group">
                                <label class="form-label"><?= t('form_people') ?></label>
                                <input type="number" class="form-control" x-model="riders" min="1" max="50">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><?= t('form_experienced') ?></label>
                                <div style="display: flex; gap: 1.2rem; margin-top: 0.5rem;">
                                    <label style="display: flex; align-items: center; gap: 0.35rem; cursor: pointer;">
                                        <input type="radio" name="exp" value="yes" x-model="hasEbikeExperience"> Sì
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 0.35rem; cursor: pointer;">
                                        <input type="radio" name="exp" value="no" x-model="hasEbikeExperience"> No (Prima volta)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><?= t('form_notes') ?></label>
                            <textarea class="form-control" rows="3" placeholder="Scrivi qui eventuali richieste speciali o domande..." x-model="notes"></textarea>
                        </div>

                        <div style="font-size: 0.8rem; color: var(--color-gray-500); margin-bottom: 1.5rem;">
                            Inviando questo modulo dichiari di aver preso visione della nostra <a href="https://www.iubenda.com/privacy-policy/22750170" target="_blank" style="text-decoration: underline;">Privacy Policy</a>.
                        </div>

                        <div style="display: flex; gap: 0.8rem; flex-wrap: wrap;">
                            <button type="submit" class="btn btn-primary" style="flex: 1;">
                                <i class="fa-solid fa-paper-plane"></i> Invia Messaggio
                            </button>
                            <a :href="getFormWaLink()" target="_blank" class="btn btn-accent">
                                <i class="fa-brands fa-whatsapp"></i> Invia su WhatsApp
                            </a>
                        </div>
                    </form>
                </template>

                <template x-if="sent">
                    <div style="text-align: center; padding: 3rem 1rem;">
                        <i class="fa-solid fa-circle-check" style="font-size: 3rem; color: var(--color-accent); margin-bottom: 1rem;"></i>
                        <h3 style="font-size: 1.8rem; color: var(--color-primary-dark); margin-bottom: 0.75rem;">Messaggio Inviato!</h3>
                        <p style="color: var(--color-gray-600); max-width: 460px; margin: 0 auto 2rem auto;">
                            Grazie <strong x-text="name"></strong>! Abbiamo ricevuto la tua richiesta. Ti contatteremo al più presto per organizzare la tua esperienza.
                        </p>
                        <button class="btn btn-primary" @click="sent = false">Invia un altro messaggio</button>
                    </div>
                </template>
            </div>

        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
