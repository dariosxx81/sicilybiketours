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
    'notes' => $notes
];

// Inserisci in cima alla lista
array_unshift($leads, $newLead);
file_put_contents($leadsFile, json_encode($leads, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Invio notifica email (con gestione silenziosa se in locale senza server SMTP)
$to = CONTACT_EMAIL;
$subject = "Nuova Richiesta da $name [" . ($sourceLabels[$type] ?? 'Sito Web') . "]";
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
             . "Note / Richieste speciali:\n$notes\n\n"
             . "Visualizza e gestisci questa richiesta dal pannello di amministrazione:\n"
             . (isset($_SERVER['HTTP_HOST']) ? 'http://' . $_SERVER['HTTP_HOST'] . (BASE_URL ?: '') . '/admin/' : '');

$headers = "From: Sicily Bike Tours <no-reply@sicilybiketours.it>\r\n"
         . "Reply-To: $name <$email>\r\n"
         . "X-Mailer: PHP/" . phpversion();

@mail($to, $subject, $messageBody, $headers);

echo json_encode([
    'success' => true,
    'message' => 'Richiesta ricevuta con successo! Ti risponderemo a breve.',
    'lead_id' => $leadId
]);
