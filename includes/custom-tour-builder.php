<?php
/**
 * SICILY BIKE TOURS - Tailor Made Custom Tour Builder Component
 * Configurato dinamicamente tramite data/configurator.json
 */

$configuratorFile = BASE_PATH . '/data/configurator.json';
$cfg = file_exists($configuratorFile) ? json_decode(file_get_contents($configuratorFile), true) : [];

$cfgDestinations = $cfg['destinations'] ?? [
    ['id' => 'Etna', 'name' => 'Vulcano Etna', 'desc_it' => 'Crateri, colate laviche, grotte e pinete d\'alta quota.', 'image' => 'assets/img/gallery/Etna-home-page.jpg'],
    ['id' => 'Nebrodi', 'name' => 'Parco dei Nebrodi', 'desc_it' => 'La Sicilia verde: laghi montani, faggete e borghi.', 'image' => 'assets/img/gallery/summit.jpg']
];
$cfgBikes = $cfg['bike_types'] ?? [
    ['name_it' => 'E-MTB Biammortizzata (Comfort e tenuta massima)'],
    ['name_it' => 'E-MTB Front (Ammortizzata solo anteriore)'],
    ['name_it' => 'E-Gravel / Touring']
];
$cfgDifficulties = $cfg['difficulty_levels'] ?? [
    ['name_it' => 'Facile / Relax (Asfalto panoramico e strade facili)'],
    ['name_it' => 'Medio (Sterrati forestali e ritmo piacevole)'],
    ['name_it' => 'Sportivo / Esperto (Single-track e pietraie laviche)']
];
$cfgExtras = $cfg['extra_experiences'] ?? [
    ['name_it' => 'Pranzo Tipico / Home Restaurant', 'desc_it' => 'Sosta gourmet con sapori tradizionali autentici.', 'icon' => 'utensils', 'price' => 28],
    ['name_it' => 'Degustazione Vini DOC Etna', 'desc_it' => 'Visita in cantina storica con calici e tagliere.', 'icon' => 'wine-glass', 'price' => 30],
    ['name_it' => 'Notte in Dimora / Agriturismo', 'desc_it' => 'Pernottamento immerso nella natura siciliana.', 'icon' => 'bed', 'price' => 70],
    ['name_it' => 'Barca Privata Isole Eolie', 'desc_it' => 'Traversate con skipper e bici a bordo.', 'icon' => 'ship', 'price' => 120],
    ['name_it' => 'Furgone di Supporto al Seguito & Trasporto Bagagli', 'desc_it' => 'Valigie trasferite da tappa a tappa e van di supporto.', 'icon' => 'van-shuttle', 'price' => 35]
];
$basePerDay = intval($cfg['pricing']['base_per_day_person'] ?? 90);
$showPrices = !empty($cfg['pricing']['show_prices']);
?>
<!-- Tailor Made Custom Tour Builder Component (Alpine.js) -->
<div class="builder-box" x-data="{
    step: 1,
    showPrices: <?= $showPrices ? 'true' : 'false' ?>,
    selectedRegions: ['Etna', 'Nebrodi'],
    durationDays: 3,
    participants: 2,
    difficultyLevel: 'Medio (Sterrati forestali e ritmo piacevole)',
    ebikeType: 'E-MTB Biammortizzata (Comfort e tenuta massima)',
    selectedExtras: ['Pranzo Tipico / Home Restaurant', 'Degustazione Vini DOC Etna'],
    customerName: '',
    customerEmail: '',
    customerPhone: '',
    customerNotes: '',
    referralCode: '<?= ACTIVE_REFERRAL_CODE ?>',
    builderSubmitted: false,
    isSubmitting: false,
    
    toggleRegion(region) {
        if (this.selectedRegions.includes(region)) {
            if (this.selectedRegions.length > 1) {
                this.selectedRegions = this.selectedRegions.filter(r => r !== region);
            }
        } else {
            this.selectedRegions.push(region);
        }
    },
    
    toggleExtra(extra) {
        if (this.selectedExtras.includes(extra)) {
            this.selectedExtras = this.selectedExtras.filter(e => e !== extra);
        } else {
            this.selectedExtras.push(extra);
        }
    },
    
    calculateEstimate() {
        let basePerDay = <?= $basePerDay ?>;
        let total = basePerDay * this.durationDays * this.participants;
        if (this.selectedExtras.includes('Notte in Dimora / Agriturismo')) total += (70 * (this.durationDays - 1) * this.participants);
        if (this.selectedExtras.includes('Barca Privata Isole Eolie')) total += (120 * this.participants);
        if (this.selectedExtras.includes('Degustazione Vini DOC Etna')) total += (30 * this.participants);
        if (this.selectedExtras.includes('Pranzo Tipico / Home Restaurant')) total += (28 * this.participants);
        if (this.selectedExtras.includes('Furgone di Supporto al Seguito & Trasporto Bagagli')) total += (35 * this.durationDays * this.participants);
        return total;
    },

    submitBuilder() {
        this.isSubmitting = true;
        fetch('<?= BASE_URL ?>/api/submit-lead.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name: this.customerName,
                email: this.customerEmail,
                phone: this.customerPhone,
                type: 'configuratore',
                tour_title: 'Tour su Misura (' + this.selectedRegions.join(', ') + ')',
                participants: this.participants,
                referral_code: this.referralCode,
                notes: this.customerNotes,
                details: {
                    destinations: this.selectedRegions,
                    duration_days: this.durationDays,
                    participants: this.participants,
                    difficulty: this.difficultyLevel,
                    ebike: this.ebikeType,
                    extras: this.selectedExtras,
                    estimate: this.calculateEstimate()
                }
            })
        }).then(r => r.json()).then(res => {
            this.isSubmitting = false;
            this.builderSubmitted = true;
        }).catch(e => {
            this.isSubmitting = false;
            this.builderSubmitted = true;
        });
    },
    
    getCustomWaLink() {
        let priceLine = this.showPrices 
            ? `💰 Stima orientativa: circa €${this.calculateEstimate()}`
            : `📋 Preventivo: Richiesta preventivo su misura per il gruppo`;
        let text = `*RICHIESTA TOUR SU MISURA - SICILY BIKE TOURS*\n` +
                   `📍 Aree scelte: ${this.selectedRegions.join(', ')}\n` +
                   `⏱ Durata: ${this.durationDays} Giorni\n` +
                   `👥 Partecipanti: ${this.participants} persone\n` +
                   `🚴 Livello: ${this.difficultyLevel}\n` +
                   `🚲 Bici: ${this.ebikeType}\n` +
                   `⭐ Extra: ${this.selectedExtras.join(', ') || 'Nessuno'}\n` +
                   `👤 Nome: ${this.customerName || 'Cliente'}\n` +
                   `📞 Tel: ${this.customerPhone || 'Non specificato'}\n` +
                   `📝 Note: ${this.customerNotes || 'Nessuna'}\n` +
                   priceLine;
        return `https://wa.me/<?= WA_NUMBER ?>?text=` + encodeURIComponent(text);
    }
}">
    <div class="builder-steps-indicator">
        <div class="step-indicator-item" :class="{ 'active': step === 1, 'completed': step > 1 }">
            <div class="step-indicator-circle">1</div>
            <span class="step-indicator-label">Destinazioni</span>
        </div>
        <div class="step-indicator-item" :class="{ 'active': step === 2, 'completed': step > 2 }">
            <div class="step-indicator-circle">2</div>
            <span class="step-indicator-label">Giorni & Persone</span>
        </div>
        <div class="step-indicator-item" :class="{ 'active': step === 3, 'completed': step > 3 }">
            <div class="step-indicator-circle">3</div>
            <span class="step-indicator-label">Livello & Bici</span>
        </div>
        <div class="step-indicator-item" :class="{ 'active': step === 4, 'completed': step > 4 }">
            <div class="step-indicator-circle">4</div>
            <span class="step-indicator-label">Esperienze</span>
        </div>
        <div class="step-indicator-item" :class="{ 'active': step === 5, 'completed': builderSubmitted }">
            <div class="step-indicator-circle">5</div>
            <span class="step-indicator-label">Riepilogo</span>
        </div>
    </div>

    <!-- Indicatore mobile compatto e leggibile -->
    <div style="text-align: center;" class="hide-on-desktop">
        <div class="builder-step-active-pill">
            <i class="fa-solid fa-compass" style="color: var(--color-primary);"></i>
            Passo <span x-text="step"></span> di 5: <strong x-text="['Destinazioni in Sicilia', 'Durata & Partecipanti', 'Livello & Tipologia Bici', 'Esperienze & Comfort Extra', 'Riepilogo & Preventivo'][step - 1]"></strong>
        </div>
    </div>

    <!-- STEP 1: DESTINAZIONI -->
    <div x-show="step === 1" x-transition>
        <div class="builder-step-header">
            <h3>Dove desideri pedalare in Sicilia?</h3>
            <p>Seleziona una o più zone che vorresti esplorare nel tuo viaggio su misura.</p>
        </div>

        <div class="regions-selection-grid">
            <?php foreach ($cfgDestinations as $dest): 
                $destName = $dest['name'] ?? $dest['id'];
                $destImg = $dest['image'] ?? 'assets/img/gallery/summit.jpg';
                $destDesc = $dest['desc_it'] ?? '';
            ?>
            <div class="region-checkbox-card" :class="{ 'selected': selectedRegions.includes('<?= addslashes($destName) ?>') }" @click="toggleRegion('<?= addslashes($destName) ?>')">
                <img src="<?= BASE_URL ?>/<?= htmlspecialchars($destImg) ?>" alt="<?= htmlspecialchars($destName) ?>" class="region-card-img">
                <div class="region-card-content">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.3rem;">
                        <h4 style="font-size: 1.15rem;"><?= htmlspecialchars($destName) ?></h4>
                        <i class="fa-solid fa-circle-check" style="font-size: 1.25rem;" :style="selectedRegions.includes('<?= addslashes($destName) ?>') ? 'color: var(--color-primary)' : 'color: var(--color-gray-300)'"></i>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--color-gray-600);"><?= htmlspecialchars($destDesc) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="builder-nav-actions" style="justify-content: flex-end;">
            <button class="btn btn-primary btn-next" @click="step = 2">
                Continua (Giorni & Persone) <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </div>

    <!-- STEP 2: GIORNI & PERSONE -->
    <div x-show="step === 2" x-transition style="display: none;">
        <div class="builder-step-header">
            <h3>Durata del Viaggio & Numero Partecipanti</h3>
            <p>Configura la lunghezza del tour e per quante persone organizzare l'esperienza.</p>
        </div>

        <div style="max-width: 650px; margin: 0 auto;">
            <!-- Giorni Slider -->
            <div class="builder-card-compact" style="background: var(--color-gray-50); border: 1.5px solid var(--color-gray-200); border-radius: var(--radius-lg); padding: 1.8rem; margin-bottom: 1.8rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <span style="font-weight: 700; font-size: 1.05rem; color: var(--color-primary-dark);">Durata del Tour:</span>
                    <span style="font-size: 1.4rem; font-weight: 800; color: var(--color-primary);" x-text="durationDays + (durationDays == 1 ? ' Giorno' : ' Giorni')"></span>
                </div>
                <input type="range" min="1" max="14" x-model="durationDays" style="width: 100%; accent-color: var(--color-primary); cursor: pointer; height: 8px;">
                <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--color-gray-500); margin-top: 0.5rem; flex-wrap: wrap; gap: 0.3rem;">
                    <span>1 giorno (Escursione)</span>
                    <span>3-4 giorni (Weekend)</span>
                    <span>7-10+ giorni (Grand Tour)</span>
                </div>
            </div>

            <!-- Partecipanti Counter -->
            <div class="builder-card-compact builder-participants-box" style="background: var(--color-gray-50); border: 1.5px solid var(--color-gray-200); border-radius: var(--radius-lg); padding: 1.8rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <span style="font-weight: 700; font-size: 1.05rem; color: var(--color-primary-dark); display: block;">Numero Partecipanti:</span>
                    <span style="font-size: 0.85rem; color: var(--color-gray-500);">Gruppi privati, coppie o famiglie</span>
                </div>
                <div class="builder-participants-counter" style="display: flex; align-items: center; gap: 1rem;">
                    <button type="button" class="btn btn-outline-primary btn-icon-round" style="width: 44px; height: 44px;" @click="if (participants > 1) participants--">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <span style="font-size: 1.5rem; font-weight: 800; min-width: 32px; text-align: center; color: var(--color-primary-dark);" x-text="participants"></span>
                    <button type="button" class="btn btn-primary btn-icon-round" style="width: 44px; height: 44px;" @click="participants++">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="builder-nav-actions">
                <button class="btn btn-primary btn-next" @click="step = 3">
                    Continua (Livello & Bici) <i class="fa-solid fa-arrow-right"></i>
                </button>
                <button class="btn btn-outline-primary btn-prev" @click="step = 1">
                    <i class="fa-solid fa-arrow-left"></i> Indietro
                </button>
            </div>
        </div>
    </div>

    <!-- STEP 3: LIVELLO & BICI -->
    <div x-show="step === 3" x-transition style="display: none;">
        <div class="builder-step-header">
            <h3>Ritmo di Pedalata & Tipologia E-Bike</h3>
            <p>Scegli il livello di impegno fisico desiderato e il tipo di mezzo preferito.</p>
        </div>

        <div style="max-width: 650px; margin: 0 auto;">
            <div class="form-group" style="margin-bottom: 1.8rem;">
                <label class="form-label" style="font-weight: 700;">Livello Ciclistico del Gruppo:</label>
                <select class="form-control" x-model="difficultyLevel">
                    <?php foreach ($cfgDifficulties as $diff): ?>
                        <option value="<?= htmlspecialchars($diff['name_it']) ?>"><?= htmlspecialchars($diff['name_it']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label" style="font-weight: 700;">Tipologia di E-Bike Preferita:</label>
                <select class="form-control" x-model="ebikeType">
                    <?php foreach ($cfgBikes as $b): ?>
                        <option value="<?= htmlspecialchars($b['name_it']) ?>"><?= htmlspecialchars($b['name_it']) ?></option>
                    <?php endforeach; ?>
                    <option value="Bici Propria (Partecipiamo con le nostre bici)">🔧 Utilizziamo le nostre bici personali</option>
                </select>
            </div>

            <div class="builder-nav-actions">
                <button class="btn btn-primary btn-next" @click="step = 4">
                    Continua (Esperienze Extra) <i class="fa-solid fa-arrow-right"></i>
                </button>
                <button class="btn btn-outline-primary btn-prev" @click="step = 2">
                    <i class="fa-solid fa-arrow-left"></i> Indietro
                </button>
            </div>
        </div>
    </div>

    <!-- STEP 4: ESPERIENZE EXTRA -->
    <div x-show="step === 4" x-transition style="display: none;">
        <div class="builder-step-header">
            <h3>Esperienze Autentiche & Comfort Extra</h3>
            <p>Rendi il tuo tour indimenticabile aggiungendo degustazioni, notti in dimora e servizi.</p>
        </div>

        <div style="max-width: 650px; margin: 0 auto; display: flex; flex-direction: column; gap: 0.85rem; margin-bottom: 2rem;">
            <?php foreach ($cfgExtras as $extra): 
                $extraName = $extra['name_it'] ?? '';
                $extraDesc = $extra['desc_it'] ?? '';
                $extraIcon = $extra['icon'] ?? 'check';
                $extraPrice = intval($extra['price'] ?? 0);
            ?>
            <div class="region-checkbox-card builder-extra-card" :class="{ 'selected': selectedExtras.includes('<?= addslashes($extraName) ?>') }" @click="toggleExtra('<?= addslashes($extraName) ?>')">
                <div class="extra-info-left">
                    <i class="fa-solid fa-<?= htmlspecialchars($extraIcon) ?>" style="color: var(--color-primary); font-size: 1.3rem; margin-top: 3px;"></i>
                    <div>
                        <strong style="display: block; font-size: 0.98rem; color: var(--color-primary-dark); margin-bottom: 0.2rem;"><?= htmlspecialchars($extraName) ?></strong>
                        <span style="font-size: 0.82rem; color: var(--color-gray-600); line-height: 1.4; display: block;"><?= htmlspecialchars($extraDesc) ?></span>
                    </div>
                </div>
                <div class="extra-action-right">
                    <?php if ($showPrices && $extraPrice > 0): ?>
                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--color-primary);">+€<?= $extraPrice ?></span>
                    <?php elseif (!$showPrices): ?>
                        <span style="font-size: 0.74rem; font-weight: 700; color: var(--color-primary-dark); background: rgba(144, 201, 92, 0.25); border: 1px solid rgba(144, 201, 92, 0.5); padding: 0.2rem 0.55rem; border-radius: 9999px; white-space: nowrap;">
                            <i class="fa-solid fa-check" style="font-size: 0.7rem;"></i> <?= t('custom_extra_included') ?>
                        </span>
                    <?php endif; ?>
                    <input type="checkbox" :checked="selectedExtras.includes('<?= addslashes($extraName) ?>')" style="accent-color: var(--color-primary); transform: scale(1.3); cursor: pointer;">
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="max-width: 650px; margin: 0 auto;">
            <div class="builder-nav-actions">
                <button class="btn btn-primary btn-next" @click="step = 5">
                    Vedi Riepilogo & Invia <i class="fa-solid fa-arrow-right"></i>
                </button>
                <button class="btn btn-outline-primary btn-prev" @click="step = 3">
                    <i class="fa-solid fa-arrow-left"></i> Indietro
                </button>
            </div>
        </div>
    </div>

    <!-- STEP 5: RIEPILOGO & CONTATTO -->
    <div x-show="step === 5" x-transition style="display: none;">
        <div class="builder-step-header">
            <h3>Il tuo Tour su Misura è Pronto!</h3>
            <p>Ecco il riassunto delle tue scelte. Inserisci i tuoi recapiti per ricevere la proposta personalizzata.</p>
        </div>

        <div class="builder-summary-grid">
            <!-- Box Riepilogo -->
            <div style="background: var(--color-accent-light); border: 1.5px solid rgba(144, 201, 92, 0.5); border-radius: var(--radius-lg); padding: 1.5rem;" class="builder-card-compact">
                <h4 style="font-size: 1.15rem; margin-bottom: 1rem; color: var(--color-primary-dark); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-clipboard-list" style="color: var(--color-primary);"></i> Riepilogo Configurazione:
                </h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.65rem; font-size: 0.92rem; color: var(--color-gray-800); padding: 0; margin: 0;">
                    <li><strong>📍 Destinazioni:</strong> <span x-text="selectedRegions.join(', ')"></span></li>
                    <li><strong>⏱ Durata:</strong> <span x-text="durationDays + ' Giorni'"></span></li>
                    <li><strong>👥 Partecipanti:</strong> <span x-text="participants + ' persone'"></span></li>
                    <li><strong>🚴 Ritmo:</strong> <span x-text="difficultyLevel"></span></li>
                    <li><strong>🚲 E-Bike:</strong> <span x-text="ebikeType"></span></li>
                    <li><strong>⭐ Extra selezionati:</strong> <span x-text="selectedExtras.join(', ') || 'Nessuno'"></span></li>
                </ul>

                <?php if ($showPrices): ?>
                <div style="margin-top: 1.4rem; padding-top: 1rem; border-top: 1px dashed rgba(24, 68, 73, 0.2); display: flex; align-items: center; justify-content: space-between;">
                    <span style="font-size: 0.88rem; font-weight: 700; color: var(--color-primary);"><?= t('custom_estimate_label') ?></span>
                    <span style="font-size: 1.5rem; font-weight: 800; color: var(--color-primary-dark);" x-text="'€' + calculateEstimate()"></span>
                </div>
                <?php else: ?>
                <div style="margin-top: 1.25rem; padding: 0.95rem 1rem; border-radius: var(--radius-md); background: #ffffff; border: 1.5px solid rgba(144, 201, 92, 0.6); display: flex; align-items: center; gap: 0.75rem; box-shadow: var(--shadow-sm);">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--color-accent-light); color: var(--color-primary-dark); display: flex; align-items: center; justify-content: center; font-size: 1.15rem; flex-shrink: 0;">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                    <div>
                        <strong style="display: block; font-size: 0.9rem; color: var(--color-primary-dark);"><?= t('custom_quote_badge') ?></strong>
                        <span style="font-size: 0.78rem; color: var(--color-gray-600); line-height: 1.35; display: block;">
                            <?= t('custom_quote_desc') ?>
                        </span>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Form Invio -->
            <div>
                <form @submit.prevent="submitBuilder">
                    <div class="form-group">
                        <label class="form-label" style="font-weight: 700;"><?= t('form_name') ?> *</label>
                        <input type="text" class="form-control" placeholder="Mario Rossi" x-model="customerName" required>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 700;"><?= t('form_email') ?> *</label>
                            <input type="email" class="form-control" placeholder="mario@email.com" x-model="customerEmail" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 700;"><?= t('form_phone') ?> *</label>
                            <input type="tel" class="form-control" placeholder="+39 333 1234567" x-model="customerPhone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" style="font-weight: 700;"><?= t('form_notes') ?></label>
                        <textarea class="form-control" rows="2" placeholder="Periodo dell'anno preferito, richieste speciali per noleggio o hotel..." x-model="customerNotes"></textarea>
                    </div>

                    <div class="builder-submit-actions">
                        <button type="submit" class="btn btn-primary btn-submit-main" :disabled="isSubmitting">
                            <span x-show="!isSubmitting">
                                <i class="fa-solid fa-paper-plane"></i> <?= $showPrices ? 'Invia Richiesta Tour' : t('custom_request_quote') ?>
                            </span>
                            <span x-show="isSubmitting"><i class="fa-solid fa-spinner fa-spin"></i> Invio in corso...</span>
                        </button>
                        <a :href="getCustomWaLink()" target="_blank" class="btn btn-accent btn-submit-wa">
                            <i class="fa-brands fa-whatsapp"></i> Invia su WhatsApp
                        </a>
                        <button type="button" class="btn btn-outline-primary btn-prev" @click="step = 4">
                            <i class="fa-solid fa-arrow-left"></i> Torna a Modificare le Opzioni
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Success Message -->
        <div x-show="builderSubmitted" style="display: none; text-align: center; margin-top: 2rem; padding: 2rem; background: var(--color-white); border-radius: var(--radius-lg); border: 2px solid var(--color-accent);">
            <i class="fa-solid fa-circle-check" style="font-size: 2.5rem; color: var(--color-accent); margin-bottom: 0.75rem;"></i>
            <h3 style="font-size: 1.5rem; color: var(--color-primary-dark);">Richiesta Preventivo Inviata con Successo!</h3>
            <p style="color: var(--color-gray-600); margin-top: 0.5rem;">Grazie! Mariella e il team di Sicily Bike Tours hanno ricevuto tutti i dettagli del tuo tour personalizzato e ti ricontatteranno via email o WhatsApp entro 24 ore.</p>
        </div>
    </div>
</div>
