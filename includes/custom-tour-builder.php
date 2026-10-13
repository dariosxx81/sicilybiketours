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
?>
<!-- Tailor Made Custom Tour Builder Component (Alpine.js) -->
<div class="builder-box" x-data="{
    step: 1,
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
                   `💰 Stima orientativa: circa €${this.calculateEstimate()}`;
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

    <!-- STEP 1: DESTINAZIONI -->
    <div x-show="step === 1" x-transition>
        <div style="margin-bottom: 1.8rem; text-align: center;">
            <h3 style="font-size: 1.6rem; color: var(--color-primary-dark); margin-bottom: 0.4rem;">Dove desideri pedalare in Sicilia?</h3>
            <p style="color: var(--color-gray-600); font-size: 0.98rem;">Seleziona una o più zone che vorresti esplorare nel tuo viaggio su misura.</p>
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

        <div style="display: flex; justify-content: flex-end; margin-top: 2rem;">
            <button class="btn btn-primary" @click="step = 2">
                Continua (Giorni & Persone) <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </div>

    <!-- STEP 2: GIORNI & PERSONE -->
    <div x-show="step === 2" x-transition style="display: none;">
        <div style="margin-bottom: 2rem; text-align: center;">
            <h3 style="font-size: 1.6rem; color: var(--color-primary-dark); margin-bottom: 0.4rem;">Durata del Viaggio & Numero Partecipanti</h3>
            <p style="color: var(--color-gray-600); font-size: 0.98rem;">Configura la lunghezza del tour e per quante persone organizzare l'esperienza.</p>
        </div>

        <div style="max-width: 650px; margin: 0 auto;">
            <!-- Giorni Slider -->
            <div style="background: var(--color-gray-50); border: 1.5px solid var(--color-gray-200); border-radius: var(--radius-lg); padding: 1.8rem; margin-bottom: 1.8rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <span style="font-weight: 700; font-size: 1.05rem; color: var(--color-primary-dark);">Durata del Tour:</span>
                    <span style="font-size: 1.4rem; font-weight: 800; color: var(--color-primary);" x-text="durationDays + (durationDays == 1 ? ' Giorno' : ' Giorni')"></span>
                </div>
                <input type="range" min="1" max="14" x-model="durationDays" style="width: 100%; accent-color: var(--color-primary); cursor: pointer; height: 8px;">
                <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--color-gray-500); margin-top: 0.5rem;">
                    <span>1 giorno (Escursione)</span>
                    <span>3-4 giorni (Weekend)</span>
                    <span>7-10+ giorni (Grand Tour)</span>
                </div>
            </div>

            <!-- Partecipanti Counter -->
            <div style="background: var(--color-gray-50); border: 1.5px solid var(--color-gray-200); border-radius: var(--radius-lg); padding: 1.8rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <span style="font-weight: 700; font-size: 1.05rem; color: var(--color-primary-dark); display: block;">Numero Partecipanti:</span>
                    <span style="font-size: 0.85rem; color: var(--color-gray-500);">Gruppi privati, coppie o famiglie</span>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <button type="button" class="btn btn-outline-primary btn-icon-round" @click="if (participants > 1) participants--">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <span style="font-size: 1.5rem; font-weight: 800; min-width: 32px; text-align: center; color: var(--color-primary-dark);" x-text="participants"></span>
                    <button type="button" class="btn btn-primary btn-icon-round" @click="participants++">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <button class="btn btn-outline-primary" @click="step = 1">
                    <i class="fa-solid fa-arrow-left"></i> Indietro
                </button>
                <button class="btn btn-primary" @click="step = 3">
                    Continua (Livello & Bici) <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- STEP 3: LIVELLO & BICI -->
    <div x-show="step === 3" x-transition style="display: none;">
        <div style="margin-bottom: 2rem; text-align: center;">
            <h3 style="font-size: 1.6rem; color: var(--color-primary-dark); margin-bottom: 0.4rem;">Ritmo di Pedalata & Tipologia E-Bike</h3>
            <p style="color: var(--color-gray-600); font-size: 0.98rem;">Scegli il livello di impegno fisico desiderato e il tipo di mezzo preferito.</p>
        </div>

        <div style="max-width: 650px; margin: 0 auto;">
            <div class="form-group" style="margin-bottom: 1.8rem;">
                <label class="form-label">Livello Ciclistico del Gruppo:</label>
                <select class="form-control" x-model="difficultyLevel">
                    <?php foreach ($cfgDifficulties as $diff): ?>
                        <option value="<?= htmlspecialchars($diff['name_it']) ?>"><?= htmlspecialchars($diff['name_it']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label">Tipologia di E-Bike Preferita:</label>
                <select class="form-control" x-model="ebikeType">
                    <?php foreach ($cfgBikes as $b): ?>
                        <option value="<?= htmlspecialchars($b['name_it']) ?>"><?= htmlspecialchars($b['name_it']) ?></option>
                    <?php endforeach; ?>
                    <option value="Bici Propria (Partecipiamo con le nostre bici)">🔧 Utilizziamo le nostre bici personali</option>
                </select>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <button class="btn btn-outline-primary" @click="step = 2">
                    <i class="fa-solid fa-arrow-left"></i> Indietro
                </button>
                <button class="btn btn-primary" @click="step = 4">
                    Continua (Esperienze Extra) <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- STEP 4: ESPERIENZE EXTRA -->
    <div x-show="step === 4" x-transition style="display: none;">
        <div style="margin-bottom: 2rem; text-align: center;">
            <h3 style="font-size: 1.6rem; color: var(--color-primary-dark); margin-bottom: 0.4rem;">Esperienze Autentiche & Comfort Extra</h3>
            <p style="color: var(--color-gray-600); font-size: 0.98rem;">Rendi il tuo tour indimenticabile aggiungendo degustazioni, notti in dimora e servizi.</p>
        </div>

        <div style="max-width: 650px; margin: 0 auto; display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
            <?php foreach ($cfgExtras as $extra): 
                $extraName = $extra['name_it'] ?? '';
                $extraDesc = $extra['desc_it'] ?? '';
                $extraIcon = $extra['icon'] ?? 'check';
                $extraPrice = intval($extra['price'] ?? 0);
            ?>
            <div class="region-checkbox-card" style="padding: 1.25rem; display: flex; align-items: center; justify-content: space-between;" :class="{ 'selected': selectedExtras.includes('<?= addslashes($extraName) ?>') }" @click="toggleExtra('<?= addslashes($extraName) ?>')">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <i class="fa-solid fa-<?= htmlspecialchars($extraIcon) ?>" style="color: var(--color-primary); font-size: 1.3rem;"></i>
                    <div>
                        <strong style="display: block; font-size: 0.98rem;"><?= htmlspecialchars($extraName) ?></strong>
                        <span style="font-size: 0.82rem; color: var(--color-gray-500);"><?= htmlspecialchars($extraDesc) ?></span>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <?php if ($extraPrice > 0): ?>
                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--color-primary);">+€<?= $extraPrice ?></span>
                    <?php endif; ?>
                    <input type="checkbox" :checked="selectedExtras.includes('<?= addslashes($extraName) ?>')" style="accent-color: var(--color-primary); transform: scale(1.3);">
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="max-width: 650px; margin: 0 auto; display: flex; justify-content: space-between;">
            <button class="btn btn-outline-primary" @click="step = 3">
                <i class="fa-solid fa-arrow-left"></i> Indietro
            </button>
            <button class="btn btn-primary" @click="step = 5">
                Vedi Riepilogo & Invia <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </div>

    <!-- STEP 5: RIEPILOGO & CONTATTO -->
    <div x-show="step === 5" x-transition style="display: none;">
        <div style="margin-bottom: 2rem; text-align: center;">
            <h3 style="font-size: 1.6rem; color: var(--color-primary-dark); margin-bottom: 0.4rem;">Il tuo Tour su Misura è Pronto!</h3>
            <p style="color: var(--color-gray-600); font-size: 0.98rem;">Ecco il riassunto delle tue scelte. Inserisci i tuoi recapiti per ricevere la proposta personalizzata.</p>
        </div>

        <div class="builder-summary-grid">
            <!-- Box Riepilogo -->
            <div style="background: var(--color-accent-light); border: 1.5px solid rgba(144, 201, 92, 0.5); border-radius: var(--radius-lg); padding: 1.6rem;">
                <h4 style="font-size: 1.15rem; margin-bottom: 1rem; color: var(--color-primary-dark);">Riepilogo Configurazione:</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.6rem; font-size: 0.92rem; color: var(--color-gray-700);">
                    <li><strong>📍 Destinazioni:</strong> <span x-text="selectedRegions.join(', ')"></span></li>
                    <li><strong>⏱ Durata:</strong> <span x-text="durationDays + ' Giorni'"></span></li>
                    <li><strong>👥 Partecipanti:</strong> <span x-text="participants + ' persone'"></span></li>
                    <li><strong>🚴 Ritmo:</strong> <span x-text="difficultyLevel"></span></li>
                    <li><strong>🚲 E-Bike:</strong> <span x-text="ebikeType"></span></li>
                    <li><strong>⭐ Extra selezionati:</strong> <span x-text="selectedExtras.join(', ') || 'Nessuno'"></span></li>
                </ul>

                <div style="margin-top: 1.4rem; padding-top: 1rem; border-top: 1px dashed rgba(24, 68, 73, 0.2); display: flex; align-items: center; justify-content: space-between;">
                    <span style="font-size: 0.88rem; font-weight: 700; color: var(--color-primary);">Stima Orientativa Gruppo:</span>
                    <span style="font-size: 1.5rem; font-weight: 800; color: var(--color-primary-dark);" x-text="'€' + calculateEstimate()"></span>
                </div>
            </div>

            <!-- Form Invio -->
            <div>
                <form @submit.prevent="submitBuilder">
                    <div class="form-group">
                        <label class="form-label"><?= t('form_name') ?> *</label>
                        <input type="text" class="form-control" placeholder="Mario Rossi" x-model="customerName" required>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label"><?= t('form_email') ?> *</label>
                            <input type="email" class="form-control" placeholder="mario@email.com" x-model="customerEmail" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?= t('form_phone') ?> *</label>
                            <input type="tel" class="form-control" placeholder="+39 333 1234567" x-model="customerPhone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= t('form_notes') ?></label>
                        <textarea class="form-control" rows="2" placeholder="Periodo dell'anno preferito, richieste speciali per noleggio o hotel..." x-model="customerNotes"></textarea>
                    </div>

                    <div style="display: flex; gap: 0.8rem; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;" :disabled="isSubmitting">
                            <span x-show="!isSubmitting"><i class="fa-solid fa-paper-plane"></i> Invia Richiesta Tour</span>
                            <span x-show="isSubmitting"><i class="fa-solid fa-spinner fa-spin"></i> Invio in corso...</span>
                        </button>
                        <a :href="getCustomWaLink()" target="_blank" class="btn btn-accent">
                            <i class="fa-brands fa-whatsapp"></i> Invia su WhatsApp
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Success Message -->
        <div x-show="builderSubmitted" style="display: none; text-align: center; margin-top: 2rem; padding: 2rem; background: var(--color-white); border-radius: var(--radius-lg); border: 2px solid var(--color-accent);">
            <i class="fa-solid fa-circle-check" style="font-size: 2.5rem; color: var(--color-accent); margin-bottom: 0.75rem;"></i>
            <h3 style="font-size: 1.5rem; color: var(--color-primary-dark);">Configurazione Inviata con Successo!</h3>
            <p style="color: var(--color-gray-600); margin-top: 0.5rem;">Grazie! Mariella e il team di Sicily Bike Tours prepareranno il tuo preventivo personalizzato su misura entro 24 ore.</p>
        </div>
    </div>
</div>
