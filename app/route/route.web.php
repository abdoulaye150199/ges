<?php

namespace App\Route;

require_once __DIR__ . '/../enums/route.enum.php';
require_once __DIR__ . '/../controllers/auth.controller.php';
require_once __DIR__ . '/../controllers/promotion.controller.php';
require_once __DIR__ . '/../controllers/referentiel.controller.php';
require_once __DIR__ . '/../controllers/dashboard.controller.php';

use App\Controllers;
use App\Enums\Route as RouteEnum;

// Définition de toutes les routes disponibles avec leur fonction controller associée
$routes = [
    RouteEnum::LOGIN->value => 'App\Controllers\login_page',
    RouteEnum::LOGIN_PROCESS->value => 'App\Controllers\login_process',
    RouteEnum::LOGOUT->value => 'App\Controllers\logout',
    RouteEnum::CHANGE_PASSWORD->value => 'App\Controllers\change_password_page',
    RouteEnum::CHANGE_PASSWORD_PROCESS->value => 'App\Controllers\change_password_process',
    RouteEnum::FORGOT_PASSWORD->value => 'App\Controllers\forgot_password_page',
    RouteEnum::FORGOT_PASSWORD_PROCESS->value => 'App\Controllers\forgot_password_process',
    RouteEnum::RESET_PASSWORD->value => 'App\Controllers\reset_password_page',
    RouteEnum::RESET_PASSWORD_PROCESS->value => 'App\Controllers\reset_password_process',
    
    RouteEnum::PROMOTIONS->value => 'App\Controllers\list_promotions',
    RouteEnum::ADD_PROMOTION->value => 'App\Controllers\add_promotion_form',
    RouteEnum::ADD_PROMOTION_PROCESS->value => 'App\Controllers\add_promotion_process',
    RouteEnum::TOGGLE_PROMOTION_STATUS->value => 'App\Controllers\toggle_promotion_status',
    RouteEnum::PROMOTION->value => 'App\Controllers\promotion_page',
    
    RouteEnum::REFERENTIELS->value => 'App\Controllers\list_referentiels',
    RouteEnum::ALL_REFERENTIELS->value => 'App\Controllers\list_all_referentiels',
    RouteEnum::ADD_REFERENTIEL->value => 'App\Controllers\add_referentiel_form',
    RouteEnum::ADD_REFERENTIEL_PROCESS->value => 'App\Controllers\add_referentiel_process',
    RouteEnum::ASSIGN_REFERENTIELS->value => 'App\Controllers\assign_referentiels_form',
    RouteEnum::ASSIGN_REFERENTIELS_PROCESS->value => 'App\Controllers\assign_referentiels_process',
    
    RouteEnum::DASHBOARD->value => 'App\Controllers\dashboard',
    RouteEnum::FORBIDDEN->value => 'App\Controllers\forbidden',
    RouteEnum::NOT_FOUND->value => 'App\Controllers\not_found'
];

/**
 * Fonction de routage qui exécute le contrôleur correspondant à la page demandée
 *
 * @param string $page La page demandée
 * @return mixed Le résultat de la fonction contrôleur
 */
function route($page) {
    global $routes;
     
    // Vérifie si la route demandée existe
    $route_exists = array_key_exists($page, $routes);
    
    // Obtient la fonction à exécuter (route demandée ou 404 si non trouvée)
    $controller_function = $route_exists ? $routes[$page] : $routes['404'];
    
    // Exécute la fonction contrôleur
    return call_user_func($controller_function);
}