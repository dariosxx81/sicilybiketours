<?php
/**
 * SICILY BIKE TOURS - Local PHP Development Server Router
 * Utilizzo: php -S localhost:8000 router.php
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false; // serve directly static files (css, js, images)
}

if (preg_match('#^/(tour|escursione)/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[2];
    require __DIR__ . '/tour-dettaglio.php';
    return true;
}

$phpFile = __DIR__ . $uri . '.php';
if (file_exists($phpFile)) {
    require $phpFile;
    return true;
}

require __DIR__ . '/index.php';
