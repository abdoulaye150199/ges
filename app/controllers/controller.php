<?php

namespace App\Controllers;

require_once __DIR__ . '/../enums/path.enum.php';
require_once __DIR__ . '/../services/session.service.php';

use App\Enums;
use App\Services;

// Fonctions communes à tous les contrôleurs
function render($layout, $view, $data = []) {
    global $session_services;
    
    // Extraction des données pour les rendre disponibles dans la vue
    extract($data);
    
    // Récupération du message flash s'il existe
    $flash = $session_services['get_flash_message']();
    
    // Démarrage de la mise en tampon pour stocker la vue
    ob_start();
    require_once render_view($view);
    $content = ob_get_clean();
    
    // Chargement du layout avec le contenu de la vue
    require_once render_view($layout, true);
}

// Nouvelle fonction pour gérer le rendu des vues
function render_view($file, $is_layout = false) {
    if ($is_layout) {
        $path = __DIR__ . '/../views/layout/' . $file;
    } else {
        $path = __DIR__ . '/../views/' . $file;
    }
    
    if (!file_exists($path)) {
        throw new \RuntimeException("Vue non trouvée : $path");
    }
    
    return $path;
}

// Redirection vers une autre page
function redirect($url) {
    header("Location: $url");
    exit();
}

// Vérification si l'utilisateur est connecté
function check_auth() {
    global $session_services;
    
    $user = $session_services['get_session']('user');
    
    if (!$user) {
        redirect('?page=login');
    }
    
    return $user;
}

// Vérification du profil de l'utilisateur
function check_profile($required_profile) {
    $user = check_auth();
    
    if ($user['profile'] !== $required_profile) {
        redirect('?page=forbidden');
    }
    
    return $user;
}

// Téléchargement d'un fichier image
function upload_image($file, $directory = 'uploads') {
    // Vérifier si le répertoire existe, sinon le créer
    $upload_dir = Enums\UPLOAD_PATH . $directory . '/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Générer un nom de fichier unique
    $filename = uniqid() . '_' . basename($file['name']);
    $target_path = $upload_dir . $filename;
    
    // Déplacer le fichier téléchargé vers le répertoire cible
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return $directory . '/' . $filename;
    }
    
    return false;
}