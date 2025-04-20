<?php

namespace App\Enums;

enum Route: string
{
    // Routes pour l'authentification
    case LOGIN = 'login';
    case LOGIN_PROCESS = 'login-process';
    case LOGOUT = 'logout';
    case CHANGE_PASSWORD = 'change-password';
    case CHANGE_PASSWORD_PROCESS = 'change-password-process';
    case FORGOT_PASSWORD = 'forgot-password';
    case FORGOT_PASSWORD_PROCESS = 'forgot-password-process';
    case RESET_PASSWORD = 'reset-password';
    case RESET_PASSWORD_PROCESS = 'reset-password-process';
    
    // Routes pour les promotions
    case PROMOTIONS = 'promotions';
    case ADD_PROMOTION = 'add-promotion';
    case ADD_PROMOTION_PROCESS = 'add-promotion-process';
    case TOGGLE_PROMOTION_STATUS = 'toggle-promotion-status';
    case PROMOTION = 'promotion';
    
    // Routes pour les référentiels
    case REFERENTIELS = 'referentiels';
    case ALL_REFERENTIELS = 'all-referentiels';
    case ADD_REFERENTIEL = 'add-referentiel';
    case ADD_REFERENTIEL_PROCESS = 'add-referentiel-process';  // Correction ici
    case ASSIGN_REFERENTIELS = 'assign-referentiels';
    case ASSIGN_REFERENTIELS_PROCESS = 'assign-referentiels-process';
    
    // Route par défaut pour le tableau de bord
    case DASHBOARD = 'dashboard';
    
    // Routes pour les erreurs
    case FORBIDDEN = 'forbidden';
    case NOT_FOUND = '404';
}