<?php
/**
 * SICILY BIKE TOURS - WordPress Remote Synchronizer
 * Sincronizza i contenuti remoti da https://www.sicilybiketours.it nel filesystem locale.
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/wordpress.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? ($_SERVER['argv'][1] ?? 'check');

if ($action === 'check') {
    $res = wp_check_connection();
    echo json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($action === 'sync') {
    $status = ['success' => true, 'synced' => []];
    
    // 1. Fetch Posts
    $posts = wp_fetch_remote_data('posts', ['per_page' => 100]);
    if ($posts !== null) {
        file_put_contents(BASE_PATH . '/wp_posts.json', json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $status['synced']['posts'] = count($posts);
    } else {
        $status['success'] = false;
        $status['errors'][] = 'Impossibile scaricare gli articoli.';
    }
    
    // 2. Fetch Pages
    $pages = wp_fetch_remote_data('pages', ['per_page' => 100]);
    if ($pages !== null) {
        file_put_contents(BASE_PATH . '/wp_pages.json', json_encode($pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $status['synced']['pages'] = count($pages);
    } else {
        $status['success'] = false;
        $status['errors'][] = 'Impossibile scaricare le pagine.';
    }

    $status['timestamp'] = date('Y-m-d H:i:s');
    $status['message'] = $status['success'] ? 'Sincronizzazione completata con successo!' : 'Sincronizzazione parziale o fallita.';
    
    echo json_encode($status, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode(['error' => 'Azione non riconosciuta'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
