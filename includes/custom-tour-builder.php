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

<style>
/* Stili dedicati ed ergonomici per il configuratore su misura */
#configuratore.builder-box {
    box-sizing: border-box;
    width: 100%;
}

/* Extra Cards Ergonomia Desktop & Mobile */
.builder-extra-card {
    background: #ffffff;
    border: 1.5px solid var(--color-gray-200);
    border-radius: var(--radius-lg);
    padding: 1.15rem 1.25rem;
    cursor: pointer;
    transition: all var(--transition-fast);
    display: flex;
    flex-direction: column;
    gap: 0.55rem;
    box-sizing: border-box;
    width: 100%;
    position: relative;
}
.builder-extra-card:hover {
    border-color: var(--color-accent);
    transform: translateY(-2px);
}
.builder-extra-card.selected {
    border-color: var(--color-primary) !important;
    background: #f7faf5 !important;
    box-shadow: 0 4px 15px -2px rgba(144, 201, 92, 0.25) !important;
}
.extra-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
    width: 100%;
}
.extra-card-title-wrap {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
    min-width: 0;
}
.extra-card-icon-box {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(144, 201, 92, 0.16);
    color: var(--color-primary-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
    flex-shrink: 0;
}
.extra-card-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--color-primary-dark);
    margin: 0;
    line-height: 1.35;
}
.extra-card-checkbox-wrap {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
.extra-card-checkbox {
    width: 24px;
    height: 24px;
    accent-color: var(--color-primary);
    cursor: pointer;
    border-radius: 4px;
}
.extra-card-desc {
    font-size: 0.86rem;
    color: var(--color-gray-600);
    line-height: 1.45;
    margin: 0;
    padding-left: 0;
}
.extra-card-meta {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-top: 0.15rem;
}
.extra-included-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.76rem;
    font-weight: 700;
    color: var(--color-primary-dark);
    background: rgba(144, 201, 92, 0.22);
    border: 1px solid rgba(144, 201, 92, 0.55);
    padding: 0.25rem 0.65rem;
    border-radius: var(--radius-full);
}
.extra-price-tag {
    font-size: 0.94rem;
    font-weight: 800;
    color: var(--color-primary);
}

/* Partecipanti Box */
.builder-participants-box {
    background: var(--color-gray-50);
    border: 1.5px solid var(--color-gray-200);
    border-radius: var(--radius-lg);
    padding: 1.6rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-sizing: border-box;
    width: 100%;
}
.builder-participants-info {
    flex: 1;
}
.builder-participants-title {
    font-weight: 700;
    font-size: 1.05rem;
    color: var(--color-primary-dark);
    display: block;
    margin-bottom: 0.2rem;
}
.builder-participants-sub {
    font-size: 0.85rem;
    color: var(--color-gray-500);
}
.builder-participants-counter {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-shrink: 0;
}
.builder-participants-counter .btn-counter {
    width: 48px;
    height: 48px;
    min-width: 48px;
    min-height: 48px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    font-size: 1.15rem;
    cursor: pointer;
    border: 1.5px solid var(--color-primary);
}
.builder-participants-num {
    font-size: 1.7rem;
    font-weight: 800;
    min-width: 36px;
    text-align: center;
    color: var(--color-primary-dark);
}

/* Pulsanti Navigazione & Invio Step (Desktop standard) */
.builder-nav-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
    box-sizing: border-box;
    width: 100%;
}
.builder-nav-actions .btn-prev {
    order: 1;
}
.builder-nav-actions .btn-next {
    order: 2;
}
.builder-submit-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-top: 1.5rem;
    width: 100%;
    box-sizing: border-box;
}

/* ADATTAMENTO MOBILE RESPONSIVE (<= 768px) */
@media (max-width: 768px) {
    #configuratore.builder-box {
        padding: 1.25rem 0.85rem !important;
        border-radius: var(--radius-lg) !important;
        overflow: hidden !important;
    }
    
    /* Box Partecipanti: Impilato e centrato su mobile per non andare mai off-screen */
    .builder-participants-box {
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
        gap: 1.1rem !important;
        padding: 1.35rem 1rem !important;
    }
    .builder-participants-info {
        text-align: center !important;
    }
    .builder-participants-counter {
        width: 100% !important;
        justify-content: center !important;
        gap: 1.75rem !important;
    }
    .builder-participants-counter .btn-counter {
        width: 50px !important;
        height: 50px !important;
        min-width: 50px !important;
        min-height: 50px !important;
    }
    .builder-participants-num {
        font-size: 2rem !important;
        min-width: 50px !important;
    }

    /* Extra Card su mobile */
    .builder-extra-card {
        padding: 1rem 0.95rem !important;
        gap: 0.65rem !important;
    }
    .extra-card-title {
        font-size: 0.96rem !important;
    }
    .extra-card-desc {
        font-size: 0.83rem !important;
        line-height: 1.4 !important;
    }

    /* TUTTI I PULSANTI MOBILE: Stessa Lunghezza (100%), Perfettamente Allineati e Spaziati */
    .builder-nav-actions,
    .builder-submit-actions {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        gap: 0.75rem !important;
        margin-top: 1.5rem !important;
        box-sizing: border-box !important;
    }
    .builder-nav-actions .btn,
    .builder-nav-actions button,
    .builder-submit-actions .btn,
    .builder-submit-actions button,
    .builder-submit-actions a {
        width: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-height: 50px !important;
        font-size: 0.98rem !important;
        font-weight: 700 !important;
        border-radius: var(--radius-md) !important;
        padding: 0.85rem 1.25rem !important;
        box-sizing: border-box !important;
        text-align: center !important;
        margin: 0 !important;
        gap: 0.55rem !important;
        box-shadow: var(--shadow-sm) !important;
    }
    .builder-nav-actions .btn-next,
    .builder-submit-actions .btn-submit-main {
        order: 1 !important;
        background: var(--color-primary-dark) !important;
        color: #ffffff !important;
        border: none !important;
    }
    .builder-submit-actions .btn-submit-wa {
        order: 2 !important;
        background: var(--color-accent) !important;
        color: var(--color-primary-dark) !important;
        border: none !important;
    }
    .builder-nav-actions .btn-prev {
        order: 2 !important;
        background: #ffffff !important;
        border: 1.5px solid var(--color-gray-300) !important;
        color: var(--color-gray-700) !important;
        box-shadow: none !important;
    }
    .builder-submit-actions .btn-prev {
        order: 3 !important;
        background: #ffffff !important;
        border: 1.5px solid var(--color-gray-300) !important;
        color: var(--color-gray-700) !important;
        box-shadow: none !important;
    }
}
</style>

<!-- Tailor Made Custom Tour Builder Component (Alpine.js) -->
<div class="builder-box" id="configuratore" x-data="{
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
    
    goToStep(newStep) {
        this.step = newStep;
        this.$nextTick(() => {
            const el = document.getElementById('configuratore');
            if (el) {
                const rect = el.getBoundingClientRect();
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const offset = 80; // Offset per la navbar fissa
                window.scrollTo({
                    top: Math.max(0, rect.top + scrollTop - offset),
                    behavior: 'smooth'
                });
            }
        });
    },

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
            <button type="button" class="btn btn-primary btn-next" @click="goToStep(2)">
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
            <div class="builder-card-compact" style="background: var(--color-gray-50); border: 1.5px solid var(--color-gray-200); border-radius: var(--radius-lg); padding: 1.6rem; margin-bottom: 1.6rem;">
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

            <!-- Partecipanti Counter (Ergonomico e Anti-Overflow) -->
            <div class="builder-card-compact builder-participants-box">
                <div class="builder-participants-info">
                    <span class="builder-participants-title">Numero Partecipanti:</span>
                    <span class="builder-participants-sub">Gruppi privati, coppie o famiglie</span>
                </div>
                <div class="builder-participants-counter">
                    <button type="button" class="btn btn-outline-primary btn-counter" @click="if (participants > 1) participants--">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <span class="builder-participants-num" x-text="participants"></span>
                    <button type="button" class="btn btn-primary btn-counter" @click="participants++">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="builder-nav-actions">
                <button type="button" class="btn btn-primary btn-next" @click="goToStep(3)">
                    Continua (Livello & Bici) <i class="fa-solid fa-arrow-right"></i>
                </button>
                <button type="button" class="btn btn-outline-primary btn-prev" @click="goToStep(1)">
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
            <!-- Livello Ciclistico -->
            <div class="form-group" style="margin-bottom: 1.8rem;">
                <label class="form-label" style="font-weight: 700; color: var(--color-primary-dark); font-size: 1rem; margin-bottom: 0.5rem;">
                    Livello Ciclistico del Gruppo:
                </label>
                <select class="form-control" x-model="difficultyLevel">
                    <?php foreach ($cfgDifficulties as $d): ?>
                        <option value="<?= htmlspecialchars($d['name_it']) ?>"><?= htmlspecialchars($d['name_it']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tipologia Bici -->
            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label" style="font-weight: 700; color: var(--color-primary-dark); font-size: 1rem; margin-bottom: 0.5rem;">
                    Tipologia di E-Bike Preferita:
                </label>
                <select class="form-control" x-model="ebikeType">
                    <?php foreach ($cfgBikes as $b): ?>
                        <option value="<?= htmlspecialchars($b['name_it']) ?>"><?= htmlspecialchars($b['name_it']) ?></option>
                    <?php endforeach; ?>
                    <option value="Bici Propria (Partecipiamo con le nostre bici)">🔧 Utilizziamo le nostre bici personali</option>
                </select>
            </div>

            <div class="builder-nav-actions">
                <button type="button" class="btn btn-primary btn-next" @click="goToStep(4)">
                    Continua (Esperienze Extra) <i class="fa-solid fa-arrow-right"></i>
                </button>
                <button type="button" class="btn btn-outline-primary btn-prev" @click="goToStep(2)">
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
            <div class="builder-extra-card" :class="{ 'selected': selectedExtras.includes('<?= addslashes($extraName) ?>') }" @click="toggleExtra('<?= addslashes($extraName) ?>')">
                <div class="extra-card-header">
                    <div class="extra-card-title-wrap">
                        <div class="extra-card-icon-box">
                            <i class="fa-solid fa-<?= htmlspecialchars($extraIcon) ?>"></i>
                        </div>
                        <h4 class="extra-card-title"><?= htmlspecialchars($extraName) ?></h4>
                    </div>
                    <div class="extra-card-checkbox-wrap">
                        <input type="checkbox" :checked="selectedExtras.includes('<?= addslashes($extraName) ?>')" class="extra-card-checkbox" @click.stop="toggleExtra('<?= addslashes($extraName) ?>')">
                    </div>
                </div>
                <p class="extra-card-desc"><?= htmlspecialchars($extraDesc) ?></p>
                <div class="extra-card-meta">
                    <?php if ($showPrices && $extraPrice > 0): ?>
                        <span class="extra-price-tag">+€<?= $extraPrice ?> <small style="font-weight: 500; font-size: 0.75rem; color: var(--color-gray-600);">/ persona</small></span>
                    <?php else: ?>
                        <span class="extra-included-tag">
                            <i class="fa-solid fa-circle-check"></i> <?= t('custom_extra_included') ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="max-width: 650px; margin: 0 auto;">
            <div class="builder-nav-actions">
                <button type="button" class="btn btn-primary btn-next" @click="goToStep(5)">
                    Vedi Riepilogo & Invia <i class="fa-solid fa-arrow-right"></i>
                </button>
                <button type="button" class="btn btn-outline-primary btn-prev" @click="goToStep(3)">
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
                        <button type="button" class="btn btn-outline-primary btn-prev" @click="goToStep(4)">
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
