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
