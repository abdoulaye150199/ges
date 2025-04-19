<?php

namespace App\Controllers;

require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../models/model.php';
require_once __DIR__ . '/../services/validator.service.php';
require_once __DIR__ . '/../services/session.service.php';
require_once __DIR__ . '/../translate/fr/error.fr.php';
require_once __DIR__ . '/../translate/fr/message.fr.php';
require_once __DIR__ . '/../enums/profile.enum.php';

use App\Models;
use App\Services;
use App\Translate\fr;
use App\Enums;

// Affichage de la liste des référentiels de la promotion en cours
function list_referentiels() {
    global $model, $session_services;
    
    // Vérification des droits d'accès (Admin uniquement)
    $user = check_profile(Enums\ADMIN);
    
    // Récupération de la promotion courante
    $current_promotion = $model['get_current_promotion']();
    
    if (!$current_promotion) {
        $session_services['set_flash_message']('info', 'Aucune promotion active. Veuillez d\'abord activer une promotion.');
        redirect('?page=promotions');
        return;
    }
    
    // Récupération des référentiels de la promotion courante
    $referentiels = $model['get_referentiels_by_promotion']($current_promotion['id']);
    
    // Filtrage des référentiels selon le critère de recherche
    $search = $_GET['search'] ?? '';
    if (!empty($search)) {
        $referentiels = array_filter($referentiels, function ($referentiel) use ($search) {
            return stripos($referentiel['name'], $search) !== false;
        });
    }
    
    // Affichage de la vue
    render('admin.layout.php', 'referentiel/list.html.php', [
        'user' => $user,
        'current_promotion' => $current_promotion,
        'referentiels' => $referentiels,
        'search' => $search
    ]);
}

// Affichage de la liste de tous les référentiels
function list_all_referentiels() {
    global $model, $session_services;
    
    // Vérification des droits d'accès (Admin uniquement)
    $user = check_profile(Enums\ADMIN);
    
    // Récupération de tous les référentiels
    $referentiels = $model['get_all_referentiels']();
    
    // Filtrage des référentiels selon le critère de recherche
    $search = $_GET['search'] ?? '';
    if (!empty($search)) {
        $referentiels = array_filter($referentiels, function ($referentiel) use ($search) {
            return stripos($referentiel['name'], $search) !== false;
        });
    }
    
    // Pagination
    $page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
    $limit = 10;
    $total = count($referentiels);
    $pages = ceil($total / $limit);
    $offset = ($page - 1) * $limit;
    
    // Limiter les résultats pour la page courante
    $referentiels = array_slice($referentiels, $offset, $limit);
    
    // Affichage de la vue
    render('admin.layout.php', 'referentiel/list-all.html.php', [
        'user' => $user,
        'referentiels' => $referentiels,
        'search' => $search,
        'page' => $page,
        'pages' => $pages,
        'total' => $total
    ]);
}

// Affichage du formulaire d'ajout d'un référentiel
function add_referentiel_form() {
    global $model;
    
    // Vérification des droits d'accès (Admin uniquement)
    $user = check_profile(Enums\ADMIN);
    
    // Affichage de la vue
    render('admin.layout.php', 'referentiel/add.html.php', [
        'user' => $user
    ]);
}

// Traitement de l'ajout d'un référentiel
function add_referentiel_process() {
    global $model, $validator_services, $session_services, $error_messages, $success_messages;
    
    // Vérification des droits d'accès (Admin uniquement)
    $user = check_profile(Enums\ADMIN);
    
    // Récupération des données du formulaire
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $capacite = $_POST['capacite'] ?? '';
    $sessions = $_POST['sessions'] ?? '';
    $image = $_FILES['image'] ?? null;
    
    // Validation des données
    $errors = [];
    
    if ($validator_services['is_empty']($name)) {
        $errors['name'] = $error_messages['form']['required'];
    } elseif ($model['referentiel_name_exists']($name)) {
        $errors['name'] = $error_messages['referentiel']['name_exists'];
    }
    
    if ($validator_services['is_empty']($description)) {
        $errors['description'] = $error_messages['form']['required'];
    }
    
    if ($validator_services['is_empty']($capacite)) {
        $errors['capacite'] = $error_messages['form']['required'];
    } elseif (!is_numeric($capacite) || $capacite <= 0) {
        $errors['capacite'] = 'La capacité doit être un nombre positif';
    }
    
    if ($validator_services['is_empty']($sessions)) {
        $errors['sessions'] = $error_messages['form']['required'];
    } elseif (!is_numeric($sessions) || $sessions <= 0) {
        $errors['sessions'] = 'Le nombre de sessions doit être un nombre positif';
    }
    
    if (empty($image) || empty($image['tmp_name'])) {
        $errors['image'] = $error_messages['form']['required'];
    } elseif (!$validator_services['is_valid_image']($image)) {
        $errors['image'] = $error_messages['form']['invalid_image'];
    }
    
    // S'il y a des erreurs, affichage du formulaire avec les erreurs
    if (!empty($errors)) {
        render('admin.layout.php', 'referentiel/add.html.php', [
            'user' => $user,
            'errors' => $errors,
            'name' => $name,
            'description' => $description,
            'capacite' => $capacite,
            'sessions' => $sessions
        ]);
        return;
    }
    
    // Téléchargement de l'image
    $image_path = upload_image($image, 'referentiels');
    
    if ($image_path === false) {
        $session_services['set_flash_message']('danger', 'Erreur lors du téléchargement de l\'image');
        render('admin.layout.php', 'referentiel/add.html.php', [
            'user' => $user,
            'name' => $name,
            'description' => $description,
            'capacite' => $capacite,
            'sessions' => $sessions
        ]);
        return;
    }
    
    // Création du référentiel
    $referentiel_data = [
        'name' => $name,
        'description' => $description,
        'capacite' => (int)$capacite,
        'sessions' => (int)$sessions,
        'image' => $image_path
    ];
    
    $result = $model['create_referentiel']($referentiel_data);
    
    if (!$result) {
        $session_services['set_flash_message']('danger', $error_messages['referentiel']['create_failed']);
        render('admin.layout.php', 'referentiel/add.html.php', [
            'user' => $user,
            'name' => $name,
            'description' => $description,
            'capacite' => $capacite,
            'sessions' => $sessions
        ]);
        return;
    }
    
    // Redirection vers la liste des référentiels avec un message de succès
    $session_services['set_flash_message']('success', $success_messages['referentiel']['created']);
    redirect('?page=all-referentiels');
}

// Affichage du formulaire d'affectation de référentiels à une promotion
function assign_referentiels_form() {
    global $model, $session_services;
    
    // Vérification des droits d'accès (Admin uniquement)
    $user = check_profile(Enums\ADMIN);
    
    // Récupération de la promotion courante
    $current_promotion = $model['get_current_promotion']();
    
    if (!$current_promotion) {
        $session_services['set_flash_message']('info', 'Aucune promotion active. Veuillez d\'abord activer une promotion.');
        redirect('?page=promotions');
        return;
    }
    
    // Récupération de tous les référentiels
    $all_referentiels = $model['get_all_referentiels']();
    
    // Récupération des référentiels déjà affectés à la promotion
    $assigned_referentiels = $model['get_referentiels_by_promotion']($current_promotion['id']);
    $assigned_ids = array_map(function($ref) {
        return $ref['id'];
    }, $assigned_referentiels);
    
    // Filtrer les référentiels non affectés
    $unassigned_referentiels = array_filter($all_referentiels, function($ref) use ($assigned_ids) {
        return !in_array($ref['id'], $assigned_ids);
    });
    
    // Affichage de la vue
    render('admin.layout.php', 'referentiel/assign.html.php', [
        'user' => $user,
        'current_promotion' => $current_promotion,
        'unassigned_referentiels' => array_values($unassigned_referentiels)
    ]);
}

// Traitement de l'affectation de référentiels à une promotion
function assign_referentiels_process() {
    global $model, $session_services, $error_messages, $success_messages;
    
    // Vérification des droits d'accès (Admin uniquement)
    check_profile(Enums\ADMIN);
    
    // Récupération de la promotion courante
    $current_promotion = $model['get_current_promotion']();
    
    if (!$current_promotion) {
        $session_services['set_flash_message']('info', 'Aucune promotion active. Veuillez d\'abord activer une promotion.');
        redirect('?page=promotions');
        return;
    }
    
    // Récupération des référentiels sélectionnés
    $selected_referentiels = $_POST['referentiels'] ?? [];
    
    if (empty($selected_referentiels)) {
        $session_services['set_flash_message']('info', 'Aucun référentiel sélectionné.');
        redirect('?page=assign-referentiels');
        return;
    }
    
    // Affectation des référentiels à la promotion
    $result = $model['assign_referentiels_to_promotion']($current_promotion['id'], $selected_referentiels);
    
    if (!$result) {
        $session_services['set_flash_message']('danger', $error_messages['referentiel']['update_failed']);
        redirect('?page=assign-referentiels');
        return;
    }
    
    // Redirection vers la liste des référentiels de la promotion avec un message de succès
    $session_services['set_flash_message']('success', $success_messages['referentiel']['assigned']);
    redirect('?page=referentiels');
}