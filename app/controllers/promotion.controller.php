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

// Affichage de la liste des promotions
function list_promotions() {
    global $session_services;

    // Vérification si l'utilisateur est connecté
    $user = check_auth();

    // Rendu de la vue
    render('admin.layout.php', 'promotion/list.html.php', [
        'user' => $user,
        'promotions' => [] // Exemple de données
    ]);
}

// Affichage du formulaire d'ajout d'une promotion
function add_promotion_form() {
    global $model;
    
    // Vérification des droits d'accès (Admin uniquement)
    $user = check_profile(Enums\ADMIN);
    
    // Affichage de la vue
    render('admin.layout.php', 'promotion/add.html.php', [
        'user' => $user
    ]);
}

// Traitement de l'ajout d'une promotion
function add_promotion_process() {
    global $model, $validator_services, $session_services, $error_messages, $success_messages;
    
    // Vérification des droits d'accès (Admin uniquement)
    $user = check_profile(Enums\ADMIN);
    
    // Récupération des données du formulaire
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin = $_POST['date_fin'] ?? '';
    $image = $_FILES['image'] ?? null;
    
    // Validation des données
    $errors = [];
    
    if ($validator_services['is_empty']($name)) {
        $errors['name'] = $error_messages['form']['required'];
    } elseif ($model['promotion_name_exists']($name)) {
        $errors['name'] = $error_messages['promotion']['name_exists'];
    }
    
    if ($validator_services['is_empty']($description)) {
        $errors['description'] = $error_messages['form']['required'];
    }
    
    if ($validator_services['is_empty']($date_debut)) {
        $errors['date_debut'] = $error_messages['form']['required'];
    }
    
    if ($validator_services['is_empty']($date_fin)) {
        $errors['date_fin'] = $error_messages['form']['required'];
    } elseif (strtotime($date_fin) <= strtotime($date_debut)) {
        $errors['date_fin'] = 'La date de fin doit être postérieure à la date de début';
    }
    
    if (empty($image) || empty($image['tmp_name'])) {
        $errors['image'] = $error_messages['form']['required'];
    } elseif (!$validator_services['is_valid_image']($image)) {
        $errors['image'] = $error_messages['form']['invalid_image'];
    }
    
    // S'il y a des erreurs, affichage du formulaire avec les erreurs
    if (!empty($errors)) {
        render('admin.layout.php', 'promotion/add.html.php', [
            'user' => $user,
            'errors' => $errors,
            'name' => $name,
            'description' => $description,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin
        ]);
        return;
    }
    
    // Téléchargement de l'image
    $image_path = upload_image($image, 'promotions');
    
    if ($image_path === false) {
        $session_services['set_flash_message']('danger', 'Erreur lors du téléchargement de l\'image');
        render('admin.layout.php', 'promotion/add.html.php', [
            'user' => $user,
            'name' => $name,
            'description' => $description,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin
        ]);
        return;
    }
    
    // Création de la promotion
    $promotion_data = [
        'name' => $name,
        'description' => $description,
        'date_debut' => $date_debut,
        'date_fin' => $date_fin,
        'image' => $image_path
    ];
    
    $result = $model['create_promotion']($promotion_data);
    
    if (!$result) {
        $session_services['set_flash_message']('danger', $error_messages['promotion']['create_failed']);
        render('admin.layout.php', 'promotion/add.html.php', [
            'user' => $user,
            'name' => $name,
            'description' => $description,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin
        ]);
        return;
    }
    
    // Redirection vers la liste des promotions avec un message de succès
    $session_services['set_flash_message']('success', $success_messages['promotion']['created']);
    redirect('?page=promotions');
}

// Modification du statut d'une promotion (activation/désactivation)
function toggle_promotion_status() {
    global $model, $session_services, $error_messages, $success_messages;
    
    // Vérification des droits d'accès (Admin uniquement)
    check_profile(Enums\ADMIN);
    
    // Récupération de l'ID de la promotion
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        $session_services['set_flash_message']('danger', $error_messages['promotion']['not_found']);
        redirect('?page=promotions');
        return;
    }
    
    // Modification du statut
    $result = $model['toggle_promotion_status']($id);
    
    if (!$result) {
        $session_services['set_flash_message']('danger', $error_messages['promotion']['update_failed']);
        redirect('?page=promotions');
        return;
    }
    
    // Redirection vers la liste des promotions avec un message de succès
    $session_services['set_flash_message']('success', $success_messages['promotion']['status_changed']);
    redirect('?page=promotions');
}

// Affichage de la page de promotion
