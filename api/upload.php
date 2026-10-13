<?php
/**
 * SICILY BIKE TOURS - Image Upload API Handler
 * Supporta upload singolo o multiplo di immagini (per copertine e gallerie).
 */

require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json; charset=utf-8');

// Verifica autenticazione (se chiamato da admin)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['custom_admin_user'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Non autorizzato']);
    exit;
}

$uploadDir = BASE_PATH . '/assets/img/uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];
$uploadedFiles = [];
$errors = [];

// Funzione helper per processare singolo file
function processSingleUpload($file, $uploadDir, $allowedExtensions) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Errore nel caricamento del file (codice ' . $file['error'] . ')'];
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions)) {
        return ['error' => 'Estensione file non consentita (.' . $ext . '). Ammesse: ' . implode(', ', $allowedExtensions)];
    }

    $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
    $baseName = substr($baseName, 0, 40);
    $uniqueName = $baseName . '_' . time() . '_' . substr(md5(uniqid()), 0, 5) . '.' . $ext;
    $targetPath = $uploadDir . '/' . $uniqueName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return [
            'success' => true,
            'url' => 'assets/img/uploads/' . $uniqueName,
            'filename' => $uniqueName,
            'original_name' => $file['name'],
            'size' => $file['size']
        ];
    }

    return ['error' => 'Impossibile salvare il file nella cartella di destinazione.'];
}

// Gestione upload multiplo o singolo
if (isset($_FILES['images'])) {
    $files = $_FILES['images'];
    if (is_array($files['name'])) {
        $count = count($files['name']);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($files['name'][$i])) {
                $fileItem = [
                    'name' => $files['name'][$i],
                    'type' => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error' => $files['error'][$i],
                    'size' => $files['size'][$i],
                ];
                $res = processSingleUpload($fileItem, $uploadDir, $allowedExtensions);
                if (isset($res['success'])) {
                    $uploadedFiles[] = $res;
                } else {
                    $errors[] = $fileItem['name'] . ': ' . $res['error'];
                }
            }
        }
    } else {
        $res = processSingleUpload($files, $uploadDir, $allowedExtensions);
        if (isset($res['success'])) {
            $uploadedFiles[] = $res;
        } else {
            $errors[] = $res['error'];
        }
    }
} elseif (isset($_FILES['image'])) {
    $res = processSingleUpload($_FILES['image'], $uploadDir, $allowedExtensions);
    if (isset($res['success'])) {
        $uploadedFiles[] = $res;
    } else {
        $errors[] = $res['error'];
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Nessun file ricevuto.']);
    exit;
}

if (!empty($uploadedFiles)) {
    echo json_encode([
        'success' => true,
        'files' => $uploadedFiles,
        'first_url' => $uploadedFiles[0]['url'] ?? '',
        'errors' => $errors
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => implode(' | ', $errors) ?: 'Nessun file caricato correttamente.'
    ]);
}
