<!-- Booking & Quick Quote Modal (Alpine.js) -->
<div class="modal-overlay" x-show="bookingModalOpen" style="display: none;" x-transition.opacity @click.self="bookingModalOpen = false" x-data="{
    date: '<?= date('Y-m-d', strtotime('+3 days')) ?>',
    participants: 2,
    hasRiddenEbike: 'yes',
    needTransfer: false,
    needGourmetLunch: false,
    specialNotes: '',
    clientName: '',
    clientEmail: '',
    clientPhone: '',
    formSubmitted: false,
    isSubmitting: false,
    
    calcTotal() {
        if (!this.selectedTour) return 0;
        let base = Number(this.selectedTour.price) * this.participants;
        if (this.needTransfer) base += (35 * this.participants);
        if (this.needGourmetLunch) base += (30 * this.participants);
        return base;
    },
    
    getWaLink() {
        if (!this.selectedTour) return 'https://wa.me/<?= WA_NUMBER ?>';
        let msg = `Ciao Sicily Bike Tours! Vorrei richiedere informazioni e disponibilità per: *${this.selectedTour.title}*\n📅 Data: ${this.date}\n👥 Partecipanti: ${this.participants}\nNome: ${this.clientName || 'Un viaggiatore'}\nNote: ${this.specialNotes || 'Nessuna'}`;
        return `https://wa.me/<?= WA_NUMBER ?>?text=` + encodeURIComponent(msg);
    },
    
    submitBooking() {
        this.isSubmitting = true;
        fetch('<?= BASE_URL ?>/api/submit-lead.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name: this.clientName,
                email: this.clientEmail,
                phone: this.clientPhone,
                type: 'prenotazione_tour',
                tour_title: this.selectedTour ? this.selectedTour.title : 'Tour Standard',
                date: this.date,
                participants: this.participants,
                notes: this.specialNotes,
                details: {
                    has_ridden_ebike: this.hasRiddenEbike,
                    need_transfer: this.needTransfer,
                    need_lunch: this.needGourmetLunch,
                    calculated_estimate: this.calcTotal()
                }
            })
        }).then(r => r.json()).then(res => {
            this.isSubmitting = false;
            this.formSubmitted = true;
        }).catch(e => {
            this.isSubmitting = false;
            this.formSubmitted = true;
        });
    }
}">
    <div class="modal-dialog" x-show="bookingModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <button class="modal-close-btn" @click="bookingModalOpen = false">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <template x-if="!formSubmitted">
            <div>
                <div style="margin-bottom: 1.5rem;">
                    <span class="badge badge-accent" style="margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-calendar-check"></i> Richiesta Disponibilità & Prenotazione
                    </span>
                    <h3 style="font-size: 1.5rem; color: var(--color-primary-dark);" x-text="selectedTour ? selectedTour.title : 'Prenota il tuo Tour in E-Bike'"></h3>
                    <p style="font-size: 0.92rem; color: var(--color-gray-600);" x-text="selectedTour ? ('Prezzo base: €' + selectedTour.price + ' a persona') : 'Seleziona data e partecipanti per verificare la disponibilità.'"></p>
                </div>

                <form @submit.prevent="submitBooking">
                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label"><?= t('form_date') ?></label>
                            <input type="date" class="form-control" x-model="date" min="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?= t('form_people') ?></label>
                            <input type="number" class="form-control" x-model="participants" min="1" max="30" required>
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label"><?= t('form_name') ?> *</label>
                            <input type="text" class="form-control" placeholder="Mario Rossi" x-model="clientName" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?= t('form_phone') ?> *</label>
                            <input type="tel" class="form-control" placeholder="+39 333 1234567" x-model="clientPhone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= t('form_email') ?> *</label>
                        <input type="email" class="form-control" placeholder="mario@email.com" x-model="clientEmail" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= t('form_experienced') ?></label>
                        <div style="display: flex; gap: 1.5rem; margin-top: 0.3rem;">
                            <label style="display: flex; align-items: center; gap: 0.4rem; cursor: pointer; font-size: 0.95rem;">
                                <input type="radio" name="ebike_exp" value="yes" x-model="hasRiddenEbike"> <?= t('form_yes') ?>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.4rem; cursor: pointer; font-size: 0.95rem;">
                                <input type="radio" name="ebike_exp" value="no" x-model="hasRiddenEbike"> <?= t('form_no') ?>
                            </label>
                        </div>
                    </div>

                    <!-- Extra Services -->
                    <div style="background: var(--color-gray-50); border: 1px solid var(--color-gray-200); border-radius: var(--radius-md); padding: 1rem; margin-bottom: 1.5rem;">
                        <span style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: var(--color-gray-600); display: block; margin-bottom: 0.6rem;">Servizi Aggiuntivi & Extra</span>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="display: flex; align-items: center; justify-content: space-between; font-size: 0.92rem; cursor: pointer;">
                                <span><input type="checkbox" x-model="needTransfer"> Transfer A/R dal vostro Hotel / Alloggio</span>
                                <span style="font-weight: 700; color: var(--color-primary);">+€35/persona</span>
                            </label>
                            <label style="display: flex; align-items: center; justify-content: space-between; font-size: 0.92rem; cursor: pointer;">
                                <span><input type="checkbox" x-model="needGourmetLunch"> Pranzo Gourmet tipico o Degustazione Vini</span>
                                <span style="font-weight: 700; color: var(--color-primary);">+€30/persona</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= t('form_notes') ?></label>
                        <textarea class="form-control" rows="2" placeholder="Altezza partecipanti per le taglie e-bike, intolleranze alimentari, orari preferiti..." x-model="specialNotes"></textarea>
                    </div>

                    <!-- Live Total Calculation Bar -->
                    <div style="display: flex; align-items: center; justify-content: space-between; background: var(--color-accent-light); border: 1px solid rgba(144, 201, 92, 0.4); border-radius: var(--radius-md); padding: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <span style="font-size: 0.82rem; font-weight: 700; text-transform: uppercase; color: var(--color-primary);">Preventivo Stimato:</span>
                            <div style="font-size: 1.45rem; font-weight: 800; color: var(--color-primary-dark);">
                                €<span x-text="calcTotal()"></span>
                            </div>
                        </div>
                        <span style="font-size: 0.82rem; color: var(--color-gray-600);">Pagamento e conferma in loco/accordo</span>
                    </div>

                    <div style="display: flex; gap: 0.8rem; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;" :disabled="isSubmitting">
                            <i class="fa-solid fa-paper-plane"></i> <span x-text="isSubmitting ? 'Invio in corso...' : '<?= t('form_submit') ?>'"></span>
                        </button>
                        <a :href="getWaLink()" target="_blank" class="btn btn-accent">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </form>
            </div>
        </template>

        <!-- Success Message -->
        <template x-if="formSubmitted">
            <div style="text-align: center; padding: 2.5rem 1rem;">
                <div style="width: 70px; height: 70px; border-radius: 50%; background: var(--color-accent-light); color: var(--color-primary); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem auto;">
                    <i class="fa-solid fa-check"></i>
                </div>
                <h3 style="font-size: 1.8rem; margin-bottom: 0.75rem; color: var(--color-primary-dark);">Richiesta Inviata con Successo!</h3>
                <p style="font-size: 1.05rem; color: var(--color-gray-600); max-width: 500px; margin: 0 auto 2rem auto;">
                    Grazie <strong x-text="clientName"></strong>! Abbiamo ricevuto la tua richiesta di disponibilità per il tour <strong><span x-text="selectedTour ? selectedTour.title : ''"></span></strong> in data <strong><span x-text="date"></span></strong>. Ti risponderemo entro pochissime ore.
                </p>
                <div style="display: flex; justify-content: center; gap: 1rem;">
                    <a :href="getWaLink()" target="_blank" class="btn btn-accent">
                        <i class="fa-brands fa-whatsapp"></i> Conferma Rapida su WhatsApp
                    </a>
                    <button class="btn btn-outline-primary" @click="bookingModalOpen = false; formSubmitted = false;">
                        Chiudi
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
