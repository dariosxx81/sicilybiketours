<?php
/**
 * SICILY BIKE TOURS - Local PHP Development Server Router
 * Utilizzo: php -S localhost:8000 router.php
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$targetPath = __DIR__ . $uri;

// Gestione directory (es. /admin o /admin/)
if (is_dir($targetPath)) {
    $indexFile = rtrim($targetPath, '/') . '/index.php';
    if (file_exists($indexFile)) {
        require $indexFile;
        return true;
    }
}

// Se il file richiesto è uno script .php esistente, eseguilo
if (substr($uri, -4) === '.php' && is_file($targetPath)) {
    require $targetPath;
    return true;
}

// Serve file statici esistenti (css, js, immagini, font, svg)
if ($uri !== '/' && is_file($targetPath)) {
    return false;
}

// Rewriting per tour ed escursioni dinamiche
if (preg_match('#^/(tour|escursione)/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[2];
    require __DIR__ . '/tour-dettaglio.php';
    return true;
}

// Rewriting per file PHP senza estensione (es. /chi-siamo -> /chi-siamo.php)
$phpFile = __DIR__ . $uri . '.php';
if (file_exists($phpFile)) {
    require $phpFile;
    return true;
}

// Fallback all'index principale
require __DIR__ . '/index.php';
