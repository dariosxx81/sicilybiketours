<?php
/**
 * SICILY BIKE TOURS - Lead & Booking Submission API Handler
 * Riceve richieste di prenotazione, tour personalizzati o contatti.
 * Salva in data/leads.json e notifica via email l'amministrazione.
 */

require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Metodo non consentito']);
    exit;
}

// Supporta sia JSON payload che form post
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

$name = trim($input['name'] ?? $input['customer_name'] ?? $input['clientName'] ?? '');
$email = trim($input['email'] ?? $input['customer_email'] ?? $input['clientEmail'] ?? '');
$phone = trim($input['phone'] ?? $input['customer_phone'] ?? $input['clientPhone'] ?? '');
$type = trim($input['type'] ?? 'contatti'); // 'prenotazione_tour', 'configuratore', 'contatti'
$tourTitle = trim($input['tour_title'] ?? $input['tourTitle'] ?? $input['selectedTourName'] ?? '');
$date = trim($input['date'] ?? '');
$participants = intval($input['participants'] ?? $input['riders'] ?? 2);
$notes = trim($input['notes'] ?? $input['customerNotes'] ?? $input['specialNotes'] ?? '');
$details = $input['details'] ?? [];

if (empty($name) || (empty($email) && empty($phone))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nome e almeno un recapito (Email o Telefono) sono obbligatori.']);
    exit;
}

// Carica archivio richieste
$leadsFile = BASE_PATH . '/data/leads.json';
$leads = file_exists($leadsFile) ? json_decode(file_get_contents($leadsFile), true) ?: [] : [];

// Genera ID unico progressivo
$idNum = count($leads) + 1001;
$leadId = 'LEAD-' . $idNum;

$sourceLabels = [
    'configuratore' => 'Tour su Misura (Configuratore)',
    'prenotazione_tour' => 'Richiesta Prenotazione Tour',
    'contatti' => 'Modulo Contatti Generale'
];

// Gestione Partner Referral / Affiliazione (B&B, Hotel, Palestre, Tour Operator)
$refCodeInput = trim($input['referral_code'] ?? $input['ref'] ?? ACTIVE_REFERRAL_CODE);
$partner = find_partner_by_code($refCodeInput);

$referralInfo = null;
if ($partner) {
    $commissionRate = floatval($partner['commission_rate'] ?? 10);
    $tourTotal = floatval($details['calculated_estimate'] ?? $details['estimate'] ?? $details['total_estimate'] ?? 0);
    if ($tourTotal <= 0 && !empty($input['price'])) {
        $tourTotal = floatval($input['price']) * $participants;
    }
    $commissionAmount = $tourTotal > 0 ? round(($tourTotal * $commissionRate) / 100, 2) : 0;

    $referralInfo = [
        'partner_id' => $partner['id'],
        'partner_name' => $partner['name'],
        'partner_category' => $partner['category'] ?? 'Struttura Partner',
        'referral_code' => $partner['referral_code'],
        'commission_rate' => $commissionRate,
        'tour_total_estimate' => $tourTotal,
        'estimated_commission' => $commissionAmount,
        'commission_status' => 'maturata'
    ];

    // Aggiornamento statistiche del partner in data/partners.json
    $allPartners = get_all_partners();
    $pUpdated = false;
    foreach ($allPartners as &$p) {
        if ($p['id'] === $partner['id']) {
            $p['leads_count'] = intval($p['leads_count'] ?? 0) + 1;
            if ($tourTotal > 0) {
                $p['total_revenue'] = round(floatval($p['total_revenue'] ?? 0) + $tourTotal, 2);
                $p['commission_accrued'] = round(floatval($p['commission_accrued'] ?? 0) + $commissionAmount, 2);
            }
            $pUpdated = true;
            break;
        }
    }
    if ($pUpdated) {
        save_all_partners($allPartners);
    }
}

$newLead = [
    'id' => $leadId,
    'created_at' => date('Y-m-d H:i:s'),
    'type' => $type,
    'source_label' => $sourceLabels[$type] ?? 'Richiesta Web',
    'status' => 'nuovo',
    'customer_name' => $name,
    'customer_email' => $email,
    'customer_phone' => $phone,
    'tour_title' => $tourTitle ?: ($type === 'configuratore' ? 'Tour su Misura' : 'Informazioni Generali'),
    'date' => $date,
    'participants' => $participants,
    'details' => $details,
    'referral' => $referralInfo,
    'notes' => $notes
];

// Inserisci in cima alla lista
array_unshift($leads, $newLead);
file_put_contents($leadsFile, json_encode($leads, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Prepara dettagli configuratore se presenti
$configDetailsText = "";
if (!empty($details) && is_array($details)) {
    $configDetailsText .= "--- DETTAGLI TOUR SU MISURA CONFIGURATO ---\n";
    if (!empty($details['destinations']) && is_array($details['destinations'])) {
        $configDetailsText .= "• Destinazioni: " . implode(', ', $details['destinations']) . "\n";
    }
    if (!empty($details['duration_days'])) {
        $configDetailsText .= "• Durata: " . $details['duration_days'] . " Giorni\n";
    }
    if (!empty($details['participants'])) {
        $configDetailsText .= "• Partecipanti: " . $details['participants'] . " persone\n";
    }
    if (!empty($details['difficulty'])) {
        $configDetailsText .= "• Livello / Ritmo: " . $details['difficulty'] . "\n";
    }
    if (!empty($details['ebike'])) {
        $configDetailsText .= "• Tipologia E-Bike: " . $details['ebike'] . "\n";
    }
    if (!empty($details['extras']) && is_array($details['extras'])) {
        $configDetailsText .= "• Esperienze Extra: " . implode(', ', $details['extras']) . "\n";
    }
    if (!empty($details['estimate'])) {
        $configDetailsText .= "• Stima Interna Calcolata: € " . $details['estimate'] . "\n";
    }
    $configDetailsText .= "--------------------------------------------\n\n";
}

$partnerNoticeText = "";
if ($referralInfo) {
    $partnerNoticeText = "--------------------------------------------\n"
                       . "🤝 PROVENIENZA REFERRAL / STRUTTURA PARTNER:\n"
                       . "• Nome Partner: " . $referralInfo['partner_name'] . " (" . $referralInfo['partner_category'] . ")\n"
                       . "• Codice Utilizzato: " . $referralInfo['referral_code'] . "\n"
                       . "• Commissione Riconosciuta: " . $referralInfo['commission_rate'] . "%"
                       . ($referralInfo['estimated_commission'] > 0 ? " (stima provvigione: € " . number_format($referralInfo['estimated_commission'], 2, ',', '.') . ")" : "") . "\n"
                       . "--------------------------------------------\n\n";
}

// Invio notifica email (con gestione silenziosa se in locale senza server SMTP)
$to = CONTACT_EMAIL;
$subject = "Nuova Richiesta da $name [" . ($sourceLabels[$type] ?? 'Sito Web') . "]" . ($referralInfo ? " [Ref: " . $referralInfo['referral_code'] . "]" : "");
$messageBody = "Hai ricevuto una nuova richiesta su Sicily Bike Tours!\n\n"
             . "ID Richiesta: $leadId\n"
             . "Data ricezione: " . date('d/m/Y H:i') . "\n"
             . "Tipo: " . ($sourceLabels[$type] ?? $type) . "\n"
             . "Cliente: $name\n"
             . "Email: $email\n"
             . "Telefono: $phone\n"
             . "Tour: " . ($tourTitle ?: 'Non specificato') . "\n"
             . "Data desiderata: " . ($date ?: 'Flessibile') . "\n"
             . "Partecipanti: $participants persone\n\n"
             . $partnerNoticeText
             . $configDetailsText
             . "Note / Richieste speciali del cliente:\n" . ($notes ?: 'Nessuna nota') . "\n\n"
             . "Visualizza e gestisci questa richiesta dal pannello di amministrazione:\n"
             . (isset($_SERVER['HTTP_HOST']) ? 'http://' . $_SERVER['HTTP_HOST'] . (BASE_URL ?: '') . '/admin/' : '');

$headers = "From: Sicily Bike Tours <no-reply@sicilybiketours.it>\r\n"
         . "Reply-To: $name <$email>\r\n"
         . "X-Mailer: PHP/" . phpversion();

@mail($to, $subject, $messageBody, $headers);

// Email di cortesia automatica per il cliente (se fornita email valida)
if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $custSubject = ($type === 'configuratore') 
        ? "Ricevuta richiesta preventivo tour su misura - Sicily Bike Tours"
        : "Conferma ricezione richiesta - Sicily Bike Tours";
    $custBody = "Gentile $name,\n\n"
              . "Grazie per aver scelto Sicily Bike Tours!\n\n"
              . "Abbiamo ricevuto con successo la tua richiesta (Rif: $leadId).\n"
              . ($type === 'configuratore' 
                    ? "Mariella e le nostre guide esperte del territorio stanno elaborando l'itinerario e la proposta personalizzata con il miglior prezzo riservato per il tuo gruppo.\nTi risponderemo entro 24 ore via email o WhatsApp.\n\n" 
                    : "Il nostro staff ti ricontatterà al più presto per fornirti tutte le informazioni richieste.\n\n")
              . "Per qualsiasi necessità immediata puoi contattarci via WhatsApp o telefono al " . CONTACT_PHONE . ".\n\n"
              . "Cordiali saluti,\n"
              . "Team Sicily Bike Tours\n"
              . "Via Bonaventura, 66 - 95036 Randazzo (CT), Sicilia\n"
              . "https://sicilybiketours.it\n";
    $custHeaders = "From: Sicily Bike Tours <" . CONTACT_EMAIL . ">\r\n"
                 . "Reply-To: Sicily Bike Tours <" . CONTACT_EMAIL . ">\r\n"
                 . "X-Mailer: PHP/" . phpversion();
    @mail($email, $custSubject, $custBody, $custHeaders);
}

echo json_encode([
    'success' => true,
    'message' => 'Richiesta ricevuta con successo! Ti risponderemo a breve.',
    'lead_id' => $leadId
]);
