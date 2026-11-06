<?php
/**
 * SICILY BIKE TOURS - Configuration File
 * Gestione percorsi, parametri del sito, contatti e multilingua.
 */

if (!ob_get_level()) {
    ob_start();
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', str_replace('\\', '/', realpath(__DIR__ . '/..') ?: (__DIR__ . '/..')));

// Calcolo dinamico di BASE_URL (evita che sottocartelle come /admin sporchino la root)
$scriptDir = isset($_SERVER['SCRIPT_NAME']) ? str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])) : '';
$cleanDir = preg_replace('#/(admin|includes|config|data)(/.*)?$#i', '', $scriptDir);
$baseUrl = ($cleanDir === '/' || $cleanDir === '.' || empty($cleanDir)) ? '' : $cleanDir;
define('BASE_URL', rtrim($baseUrl, '/'));

// Caricamento impostazioni dinamiche
$settingsFile = BASE_PATH . '/data/settings.json';
$settings = file_exists($settingsFile) ? json_decode(file_get_contents($settingsFile), true) : [];

define('SITE_NAME', $settings['site_name'] ?? 'Sicily Bike Tours');
define('SITE_TAGLINE', $settings['site_tagline'] ?? 'Escursioni & Tour in E-Bike in Sicilia');
define('SITE_DESCRIPTION', $settings['site_description'] ?? 'Scopri la Sicilia autentica in E-Bike: tour guidati e su misura sull\'Etna, Nebrodi, Isole Eolie e Val di Noto per principianti ed esperti.');

define('CONTACT_PHONE', $settings['contact_phone'] ?? '+39 329 756 8883');
define('WA_NUMBER', $settings['wa_number'] ?? '393297568883');
define('CONTACT_EMAIL', $settings['contact_email'] ?? 'info@sicilybiketours.it');
define('CONTACT_ADDRESS', $settings['contact_address'] ?? 'Via Bonaventura, 66 - 95036 Randazzo (CT), Sicilia');
define('INSTAGRAM_URL', $settings['instagram_url'] ?? 'https://www.instagram.com/sicilybiketours');
define('FACEBOOK_URL', $settings['facebook_url'] ?? 'https://www.facebook.com/groups/768589132144246');

// Gestione Lingua (IT di default, EN supportato)
if (isset($_GET['lang']) && in_array($_GET['lang'], ['it', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
define('CURRENT_LANG', $_SESSION['lang'] ?? 'it');

require_once BASE_PATH . '/config/lang.php';
require_once BASE_PATH . '/data/tours.php';
require_once BASE_PATH . '/data/articles.php';

function t($key, $default = '') {
    global $translations;
    return $translations[CURRENT_LANG][$key] ?? $default ?: $key;
}

function get_tour_by_slug($slug) {
    global $tours;
    foreach ($tours as $t) {
        if ($t['slug'] === $slug) {
            return $t;
        }
    }
    return null;
}

// Polyfills per PHP 7.x
if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}
if (!function_exists('str_ends_with')) {
    function str_ends_with($haystack, $needle) {
        return $needle === '' || $needle === substr($haystack, -strlen($needle));
    }
}
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

// ===================================================================
// GESTIONE REFERRAL & AFFILIAZIONI PARTNER (B&B, Hotel, Tour Operator)
// ===================================================================
$partnersFile = BASE_PATH . '/data/partners.json';

function get_all_partners() {
    global $partnersFile;
    if (!file_exists($partnersFile)) return [];
    $data = json_decode(file_get_contents($partnersFile), true);
    return is_array($data) ? $data : [];
}

function save_all_partners($partners) {
    global $partnersFile;
    file_put_contents($partnersFile, json_encode(array_values($partners), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function find_partner_by_code($code) {
    if (empty($code)) return null;
    $norm = strtoupper(trim($code));
    $partners = get_all_partners();
    foreach ($partners as $p) {
        if (!empty($p['active']) && strtoupper(trim($p['referral_code'] ?? '')) === $norm) {
            return $p;
        }
    }
    return null;
}

// Rilevamento Referral da URL (?ref=... / ?aff=... / ?partner=...)
$incomingRef = $_GET['ref'] ?? $_GET['aff'] ?? $_GET['partner'] ?? null;
if (!empty($incomingRef)) {
    $cleanRef = preg_replace('/[^a-zA-Z0-9_-]/', '', strtoupper(trim($incomingRef)));
    if (!empty($cleanRef)) {
        $_SESSION['sbt_referral_code'] = $cleanRef;
        if (!headers_sent()) {
            setcookie('sbt_referral_code', $cleanRef, time() + (86400 * 60), '/');
        }
        
        // Tracciamento visita per partner (una volta per sessione)
        if (empty($_SESSION['sbt_ref_counted_' . $cleanRef])) {
            $partners = get_all_partners();
            $updated = false;
            foreach ($partners as &$p) {
                if (strtoupper(trim($p['referral_code'] ?? '')) === $cleanRef) {
                    $p['visits_count'] = intval($p['visits_count'] ?? 0) + 1;
                    $updated = true;
                    break;
                }
            }
            if ($updated) {
                save_all_partners($partners);
            }
            $_SESSION['sbt_ref_counted_' . $cleanRef] = true;
        }
    }
}

// Codice referral attivo memorizzato nella sessione o nel cookie
$activeRef = $_SESSION['sbt_referral_code'] ?? $_COOKIE['sbt_referral_code'] ?? null;
define('ACTIVE_REFERRAL_CODE', !empty($activeRef) ? preg_replace('/[^a-zA-Z0-9_-]/', '', strtoupper(trim($activeRef))) : '');

function get_active_partner() {
    if (!ACTIVE_REFERRAL_CODE) return null;
    return find_partner_by_code(ACTIVE_REFERRAL_CODE);
}

