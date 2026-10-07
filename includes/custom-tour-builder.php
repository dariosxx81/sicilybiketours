<!-- Tailor Made Custom Tour Builder Component (Alpine.js) -->
<div class="builder-box" x-data="{
    step: 1,
    selectedRegions: ['Etna', 'Nebrodi'],
    durationDays: 3,
    participants: 2,
    difficultyLevel: 'Medio (Percorsi panoramici e sterrati facili)',
    ebikeType: 'E-MTB Biammortizzata (Comfort e tenuta massima)',
    selectedExtras: ['Pranzo tipico / Home Restaurant', 'Degustazione Vini DOC Etna'],
    customerName: '',
    customerEmail: '',
    customerPhone: '',
    customerNotes: '',
    builderSubmitted: false,
    
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
        let basePerDay = 90; // €/day/person base with e-bike and guide
        let total = basePerDay * this.durationDays * this.participants;
        if (this.selectedExtras.includes('Notte in Dimora / Agriturismo')) total += (70 * (this.durationDays - 1) * this.participants);
        if (this.selectedExtras.includes('Barca privata Isole Eolie')) total += (120 * this.participants);
        if (this.selectedExtras.includes('Degustazione Vini DOC Etna')) total += (30 * this.participants);
        if (this.selectedExtras.includes('Pranzo tipico / Home Restaurant')) total += (28 * this.participants);
        return total;
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
            <!-- Etna -->
            <div class="region-checkbox-card" :class="{ 'selected': selectedRegions.includes('Etna') }" @click="toggleRegion('Etna')">
                <img src="<?= BASE_URL ?>/assets/img/gallery/Etna-home-page.jpg" alt="Etna" class="region-card-img">
                <div class="region-card-content">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.3rem;">
                        <h4 style="font-size: 1.15rem;">Vulcano Etna</h4>
                        <i class="fa-solid fa-circle-check" style="font-size: 1.25rem;" :style="selectedRegions.includes('Etna') ? 'color: var(--color-primary)' : 'color: var(--color-gray-300)'"></i>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--color-gray-600);">Crateri, colate laviche, grotte e pinete d'alta quota.</p>
                </div>
            </div>

            <!-- Parco dei Nebrodi -->
            <div class="region-checkbox-card" :class="{ 'selected': selectedRegions.includes('Nebrodi') }" @click="toggleRegion('Nebrodi')">
                <img src="<?= BASE_URL ?>/assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-68.jpg" alt="Nebrodi" class="region-card-img">
                <div class="region-card-content">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.3rem;">
                        <h4 style="font-size: 1.15rem;">Parco dei Nebrodi</h4>
                        <i class="fa-solid fa-circle-check" style="font-size: 1.25rem;" :style="selectedRegions.includes('Nebrodi') ? 'color: var(--color-primary)' : 'color: var(--color-gray-300)'"></i>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--color-gray-600);">La Sicilia verde: laghi montani, faggete e borghi come Floresta.</p>
                </div>
            </div>

            <!-- Megaliti Argimusco & Alcantara -->
            <div class="region-checkbox-card" :class="{ 'selected': selectedRegions.includes('Argimusco & Alcantara') }" @click="toggleRegion('Argimusco & Alcantara')">
                <img src="<?= BASE_URL ?>/assets/img/gallery/IMG-20251008-WA0031-scaled.jpg" alt="Argimusco" class="region-card-img">
                <div class="region-card-content">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.3rem;">
                        <h4 style="font-size: 1.15rem;">Megaliti & Gole Alcantara</h4>
                        <i class="fa-solid fa-circle-check" style="font-size: 1.25rem;" :style="selectedRegions.includes('Argimusco & Alcantara') ? 'color: var(--color-primary)' : 'color: var(--color-gray-300)'"></i>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--color-gray-600);">Rocce sacre misteriose, Montalbano Elicona e canyon basaltici.</p>
                </div>
            </div>

            <!-- Isole Eolie -->
            <div class="region-checkbox-card" :class="{ 'selected': selectedRegions.includes('Isole Eolie') }" @click="toggleRegion('Isole Eolie')">
                <img src="<?= BASE_URL ?>/assets/img/gallery/Immagine-WhatsApp-2025-04-06-ore-09.21.16_3d0a628f.jpg" alt="Isole Eolie" class="region-card-img">
                <div class="region-card-content">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.3rem;">
                        <h4 style="font-size: 1.15rem;">Isole Eolie in Barca</h4>
                        <i class="fa-solid fa-circle-check" style="font-size: 1.25rem;" :style="selectedRegions.includes('Isole Eolie') ? 'color: var(--color-primary)' : 'color: var(--color-gray-300)'"></i>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--color-gray-600);">Lipari, Salina, Vulcano: combinazione indimenticabile e-bike & mare.</p>
                </div>
            </div>

            <!-- Val di Noto & Barocco -->
            <div class="region-checkbox-card" :class="{ 'selected': selectedRegions.includes('Val di Noto & Barocco') }" @click="toggleRegion('Val di Noto & Barocco')">
                <img src="<?= BASE_URL ?>/assets/img/gallery/PXL_20250704_081536971.MP_-scaled.jpg" alt="Val di Noto" class="region-card-img">
                <div class="region-card-content">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.3rem;">
                        <h4 style="font-size: 1.15rem;">Val di Noto & Barocco</h4>
                        <i class="fa-solid fa-circle-check" style="font-size: 1.25rem;" :style="selectedRegions.includes('Val di Noto & Barocco') ? 'color: var(--color-primary)' : 'color: var(--color-gray-300)'"></i>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--color-gray-600);">Noto, Modica, Scicli, riserva di Vendicari e mare cristallino.</p>
                </div>
            </div>

            <!-- Borghi & Tradizioni -->
            <div class="region-checkbox-card" :class="{ 'selected': selectedRegions.includes('Borghi Storici & Cantine') }" @click="toggleRegion('Borghi Storici & Cantine')">
                <img src="<?= BASE_URL ?>/assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-113.jpg" alt="Borghi" class="region-card-img">
                <div class="region-card-content">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.3rem;">
                        <h4 style="font-size: 1.15rem;">Borghi Medievali & Sapori</h4>
                        <i class="fa-solid fa-circle-check" style="font-size: 1.25rem;" :style="selectedRegions.includes('Borghi Storici & Cantine') ? 'color: var(--color-primary)' : 'color: var(--color-gray-300)'"></i>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--color-gray-600);">Randazzo, Bronte, Castiglione di Sicilia e antiche cantine DOC.</p>
                </div>
            </div>
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
                <input type="range" min="1" max="10" x-model="durationDays" style="width: 100%; accent-color: var(--color-primary); cursor: pointer; height: 8px;">
                <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--color-gray-500); margin-top: 0.5rem;">
                    <span>1 giorno (Escursione)</span>
                    <span>3-4 giorni (Weekend lungo)</span>
                    <span>7-10 giorni (Grand Tour)</span>
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
                    <option value="Facile / Relax (Percorsi pianeggianti e asfalto/strade bianche)">🟢 Facile / Relax (Asfalto panoramico, pause frequenti, adatto a famiglie)</option>
                    <option value="Medio (Percorsi panoramici e sterrati facili)">🟡 Medio (Sterrati forestali, altimetrie moderate, ritmo piacevole)</option>
                    <option value="Sportivo / Esperto (Single track, pietraie laviche, dislivelli importanti)">🔴 Sportivo / Esperto (Single-track lavici, tratti tecnici ed esplorativi)</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label">Tipologia di E-Bike Preferita:</label>
                <select class="form-control" x-model="ebikeType">
                    <option value="E-MTB Biammortizzata (Comfort e tenuta massima)">🚲 E-MTB Full Suspension (Massimo comfort su sentieri e pietraie)</option>
                    <option value="E-MTB Front (Ammortizzata anteriore, leggera e agile)">🚲 E-MTB Front (Agile e scattante per sterrati e strade bianche)</option>
                    <option value="E-Gravel / Touring (Per strade panoramiche e borghi)">🚲 E-Gravel / Trekking (Ideale per asfalto e viaggi misti)</option>
                    <option value="Bici Propria (Partecipiamo con le nostre e-bike/bici)">🔧 Utilizziamo le nostre bici personali</option>
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
            <h3 style="font-size: 1.6rem; color: var(--color-primary-dark); margin-bottom: 0.4rem;">Arricchisci la tua Esperienza</h3>
            <p style="color: var(--color-gray-600); font-size: 0.98rem;">Seleziona i servizi extra ed enogastronomici che vorresti includere.</p>
        </div>

        <div style="max-width: 650px; margin: 0 auto; display: flex; flex-direction: column; gap: 0.85rem; margin-bottom: 2rem;">
            <div class="slot-tour-item" style="cursor: pointer; display: flex; align-items: center; justify-content: space-between;" @click="toggleExtra('Pranzo tipico / Home Restaurant')">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fa-solid fa-utensils" style="color: var(--color-primary); font-size: 1.2rem;"></i>
                    <div>
                        <strong style="display: block; font-size: 0.98rem;">Pranzo Tipico in Home Restaurant</strong>
                        <span style="font-size: 0.82rem; color: var(--color-gray-500);">Cucina genuina siciliana a km 0</span>
                    </div>
                </div>
                <input type="checkbox" :checked="selectedExtras.includes('Pranzo tipico / Home Restaurant')" style="accent-color: var(--color-primary); transform: scale(1.3);">
            </div>

            <div class="slot-tour-item" style="cursor: pointer; display: flex; align-items: center; justify-content: space-between;" @click="toggleExtra('Degustazione Vini DOC Etna')">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fa-solid fa-wine-glass" style="color: var(--color-primary); font-size: 1.2rem;"></i>
                    <div>
                        <strong style="display: block; font-size: 0.98rem;">Degustazione Vini DOC Etna & Cantina</strong>
                        <span style="font-size: 0.82rem; color: var(--color-gray-500);">Visita palmento storico e assaggi guidati</span>
                    </div>
                </div>
                <input type="checkbox" :checked="selectedExtras.includes('Degustazione Vini DOC Etna')" style="accent-color: var(--color-primary); transform: scale(1.3);">
            </div>

            <div class="slot-tour-item" style="cursor: pointer; display: flex; align-items: center; justify-content: space-between;" @click="toggleExtra('Notte in Dimora / Agriturismo')">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fa-solid fa-bed" style="color: var(--color-primary); font-size: 1.2rem;"></i>
                    <div>
                        <strong style="display: block; font-size: 0.98rem;">Pernottamenti in Dimore Storiche / Agriturismi</strong>
                        <span style="font-size: 0.82rem; color: var(--color-gray-500);">Alloggi selezionati di charme con colazione inclusa</span>
                    </div>
                </div>
                <input type="checkbox" :checked="selectedExtras.includes('Notte in Dimora / Agriturismo')" style="accent-color: var(--color-primary); transform: scale(1.3);">
            </div>

            <div class="slot-tour-item" style="cursor: pointer; display: flex; align-items: center; justify-content: space-between;" @click="toggleExtra('Furgone di Supporto & Bagagli')">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fa-solid fa-van-shuttle" style="color: var(--color-primary); font-size: 1.2rem;"></i>
                    <div>
                        <strong style="display: block; font-size: 0.98rem;">Furgone di Supporto al Seguito & Trasporto Bagagli</strong>
                        <span style="font-size: 0.82rem; color: var(--color-gray-500);">Zero pensieri: valigie trasferite da tappa a tappa</span>
                    </div>
                </div>
                <input type="checkbox" :checked="selectedExtras.includes('Furgone di Supporto & Bagagli')" style="accent-color: var(--color-primary); transform: scale(1.3);">
            </div>
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

        <div style="display: grid; grid-template-columns: 1fr 1.1fr; gap: 2rem; align-items: start;">
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
                <form @submit.prevent="builderSubmitted = true">
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
                        <button type="submit" class="btn btn-primary" style="flex: 1;">
                            <i class="fa-solid fa-paper-plane"></i> Invia Richiesta Tour
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
