<?php

namespace App\Translate\fr;

$error_messages = [
    'form' => [
        'required' => 'Ce champ est obligatoire',
        'email' => 'Veuillez saisir une adresse email valide',
        'min_length' => 'Ce champ doit contenir au moins %d caractères',
        'max_length' => 'Ce champ ne doit pas dépasser %d caractères',
        'invalid_image' => 'Le fichier doit être une image valide (JPG ou PNG) de moins de 2MB'
    ],
    'auth' => [
        'invalid_credentials' => 'Email ou mot de passe incorrect',
        'not_logged_in' => 'Veuillez vous connecter pour accéder à cette page'
    ]
];

return $error_messages;