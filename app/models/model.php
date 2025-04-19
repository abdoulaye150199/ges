<?php

namespace App\Models;

require_once __DIR__ . '/../enums/path.enum.php';
require_once __DIR__ . '/../enums/status.enum.php';
require_once __DIR__ . '/../enums/profile.enum.php';

use App\Enums;

// Collection de toutes les fonctions modèles pour l'application
$model = [
    // Fonctions de base pour manipuler les données
    'read_data' => function () {
        if (!file_exists(Enums\DATA_PATH)) {
            // Si le fichier n'existe pas, on renvoie une structure par défaut
            return [
                'users' => [],
                'promotions' => [],
                'referentiels' => [],
                'apprenants' => []
            ];
        }
        
        $json_data = file_get_contents(Enums\DATA_PATH);
        $data = json_decode($json_data, true);
        
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            // En cas d'erreur de décodage JSON
            return [
                'users' => [],
                'promotions' => [],
                'referentiels' => [],
                'apprenants' => []
            ];
        }
        
        return $data;
    },
    
    'write_data' => function ($data) {
        // Vérifier si le dossier data existe, sinon le créer
        $data_dir = dirname(Enums\DATA_PATH);
        if (!is_dir($data_dir)) {
            mkdir($data_dir, 0777, true);
        }
        
        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        return file_put_contents(Enums\DATA_PATH, $json_data) !== false;
    },
    
    'generate_id' => function () {
        return uniqid();
    },
    
    // Fonctions d'authentification
    'authenticate' => function ($email, $password) use (&$model) {
        $data = $model['read_data']();
        
        // Utiliser array_filter au lieu de foreach
        $filtered_users = array_filter($data['users'], function ($user) use ($email, $password) {
            return $user['email'] === $email && $user['password'] === $password;
        });
        
        // Si aucun utilisateur ne correspond
        if (empty($filtered_users)) {
            return null;
        }
        
        // Récupérer le premier utilisateur qui correspond
        return reset($filtered_users);
    },
    
    'get_user_by_email' => function ($email) use (&$model) {
        $data = $model['read_data']();
        
        // Utiliser array_filter au lieu de foreach
        $filtered_users = array_filter($data['users'], function ($user) use ($email) {
            return $user['email'] === $email;
        });
        
        // Si aucun utilisateur ne correspond
        if (empty($filtered_users)) {
            return null;
        }
        
        // Récupérer le premier utilisateur qui correspond
        return reset($filtered_users);
    },
    
    'get_user_by_id' => function ($user_id) use (&$model) {
        $data = $model['read_data']();
        
        // Utiliser array_filter au lieu de foreach
        $filtered_users = array_filter($data['users'], function ($user) use ($user_id) {
            return $user['id'] === $user_id;
        });
        
        // Si aucun utilisateur ne correspond
        if (empty($filtered_users)) {
            return null;
        }
        
        // Récupérer le premier utilisateur qui correspond
        return reset($filtered_users);
    },
    
    'change_password' => function ($user_id, $new_password) use (&$model) {
        $data = $model['read_data']();
        
        $user_indices = array_keys(array_filter($data['users'], function($user) use ($user_id) {
            return $user['id'] === $user_id;
        }));
        
        if (empty($user_indices)) {
            return false;
        }
        
        $user_index = reset($user_indices);
        
        // Mettre à jour le mot de passe (sans cryptage)
        $data['users'][$user_index]['password'] = $new_password;
        
        // Sauvegarder les modifications
        return $model['write_data']($data);
    },
    
    // Fonctions pour les promotions
    'get_all_promotions' => function () use (&$model) {
        $data = $model['read_data']();
        return $data['promotions'] ?? [];
    },
    
    'get_promotion_by_id' => function ($id) use (&$model) {
        $data = $model['read_data']();
        
        // Utiliser array_filter au lieu de foreach
        $filtered_promotions = array_filter($data['promotions'] ?? [], function ($promotion) use ($id) {
            return $promotion['id'] === $id;
        });
        
        return !empty($filtered_promotions) ? reset($filtered_promotions) : null;
    },
    
    'promotion_name_exists' => function ($name, $exclude_id = null) use (&$model) {
        $data = $model['read_data']();
        
        // Utiliser array_filter au lieu de foreach
        $filtered_promotions = array_filter($data['promotions'] ?? [], function ($promotion) use ($name, $exclude_id) {
            return strtolower($promotion['name']) === strtolower($name) && ($exclude_id === null || $promotion['id'] !== $exclude_id);
        });
        
        return !empty($filtered_promotions);
    },
    
    'create_promotion' => function ($promotion_data) use (&$model) {
        $data = $model['read_data']();
        
        $new_promotion = [
            'id' => $model['generate_id'](),
            'name' => $promotion_data['name'],
            'description' => $promotion_data['description'],
            'date_debut' => $promotion_data['date_debut'],
            'date_fin' => $promotion_data['date_fin'],
            'image' => $promotion_data['image'],
            'referentiels' => [],
            'status' => Enums\INACTIVE  // Statut inactif par défaut
        ];
        
        $data['promotions'][] = $new_promotion;
        
        if ($model['write_data']($data)) {
            return $new_promotion;
        }
        
        return null;
    },
    
    'update_promotion' => function ($id, $promotion_data) use (&$model) {
        $data = $model['read_data']();
        
        // Trouver l'index de la promotion
        $promotion_indices = array_keys(array_filter($data['promotions'], function($promotion) use ($id) {
            return $promotion['id'] === $id;
        }));
        
        if (empty($promotion_indices)) {
            return false;
        }
        
        $promotion_index = reset($promotion_indices);
        
        // Mettre à jour les données de la promotion
        $data['promotions'][$promotion_index] = array_merge(
            $data['promotions'][$promotion_index],
            $promotion_data
        );
        
        if ($model['write_data']($data)) {
            return $data['promotions'][$promotion_index];
        }
        
        return null;
    },
    
    'toggle_promotion_status' => function ($id) use (&$model) {
        $data = $model['read_data']();
        
        // Trouver l'index de la promotion
        $promotion_indices = array_keys(array_filter($data['promotions'], function($promotion) use ($id) {
            return $promotion['id'] === $id;
        }));
        
        if (empty($promotion_indices)) {
            return false;
        }
        
        $promotion_index = reset($promotion_indices);
        
        // Inverser le statut
        $current_status = $data['promotions'][$promotion_index]['status'];
        $new_status = ($current_status === Enums\ACTIVE) ? Enums\INACTIVE : Enums\ACTIVE;
        
        $data['promotions'][$promotion_index]['status'] = $new_status;
        
        if ($model['write_data']($data)) {
            return $data['promotions'][$promotion_index];
        }
        
        return null;
    },
    
    // Fonctions pour les référentiels
    'get_all_referentiels' => function () use (&$model) {
        $data = $model['read_data']();
        return $data['referentiels'] ?? [];
    },
    
    'get_referentiel_by_id' => function ($id) use (&$model) {
        $data = $model['read_data']();
        
        // Utiliser array_filter au lieu de foreach
        $filtered_referentiels = array_filter($data['referentiels'] ?? [], function ($referentiel) use ($id) {
            return $referentiel['id'] === $id;
        });
        
        return !empty($filtered_referentiels) ? reset($filtered_referentiels) : null;
    },
    
    'referentiel_name_exists' => function ($name, $exclude_id = null) use (&$model) {
        $data = $model['read_data']();
        
        // Utiliser array_filter au lieu de foreach
        $filtered_referentiels = array_filter($data['referentiels'] ?? [], function ($referentiel) use ($name, $exclude_id) {
            return strtolower($referentiel['name']) === strtolower($name) && ($exclude_id === null || $referentiel['id'] !== $exclude_id);
        });
        
        return !empty($filtered_referentiels);
    },
    
    'create_referentiel' => function ($referentiel_data) use (&$model) {
        $data = $model['read_data']();
        
        $new_referentiel = [
            'id' => $model['generate_id'](),
            'name' => $referentiel_data['name'],
            'description' => $referentiel_data['description'],
            'image' => $referentiel_data['image'],
            'capacite' => $referentiel_data['capacite'],
            'sessions' => $referentiel_data['sessions'],
            'modules' => []
        ];
        
        $data['referentiels'][] = $new_referentiel;
        
        if ($model['write_data']($data)) {
            return $new_referentiel;
        }
        
        return null;
    },
    
    'get_referentiels_by_promotion' => function ($promotion_id) use (&$model) {
        $data = $model['read_data']();
        
        // Récupérer la promotion
        $filtered_promotions = array_filter($data['promotions'] ?? [], function ($promotion) use ($promotion_id) {
            return $promotion['id'] === $promotion_id;
        });
        
        if (empty($filtered_promotions)) {
            return [];
        }
        
        $promotion = reset($filtered_promotions);
        $referentiel_ids = $promotion['referentiels'] ?? [];
        
        if (empty($referentiel_ids)) {
            return [];
        }
        
        // Récupérer les référentiels correspondants
        $referentiels = array_filter($data['referentiels'] ?? [], function ($referentiel) use ($referentiel_ids) {
            return in_array($referentiel['id'], $referentiel_ids);
        });
        
        return array_values($referentiels);
    },
    
    'assign_referentiels_to_promotion' => function ($promotion_id, $referentiel_ids) use (&$model) {
        $data = $model['read_data']();
        
        // Trouver l'index de la promotion
        $promotion_indices = array_keys(array_filter($data['promotions'], function($promotion) use ($promotion_id) {
            return $promotion['id'] === $promotion_id;
        }));
        
        if (empty($promotion_indices)) {
            return false;
        }
        
        $promotion_index = reset($promotion_indices);
        
        // Ajouter les référentiels à la promotion
        if (!isset($data['promotions'][$promotion_index]['referentiels'])) {
            $data['promotions'][$promotion_index]['referentiels'] = [];
        }
        
        $data['promotions'][$promotion_index]['referentiels'] = array_unique(
            array_merge($data['promotions'][$promotion_index]['referentiels'], $referentiel_ids)
        );
        
        return $model['write_data']($data);
    },
    
    // Fonction pour récupérer la promotion active courante
    'get_current_promotion' => function () use (&$model) {
        $data = $model['read_data']();
        
        // Utiliser array_filter au lieu de foreach
        $active_promotions = array_filter($data['promotions'] ?? [], function ($promotion) {
            return $promotion['status'] === Enums\ACTIVE;
        });
        
        if (empty($active_promotions)) {
            return null;
        }
        
        // Trier par date de début (la plus récente d'abord)
        usort($active_promotions, function ($a, $b) {
            return strtotime($b['date_debut']) - strtotime($a['date_debut']);
        });
        
        return reset($active_promotions);
    },
    
    // Statistiques diverses pour le tableau de bord
    'get_promotions_stats' => function () use (&$model) {
        $data = $model['read_data']();
        
        // Nombre total de promotions
        $total_promotions = count($data['promotions'] ?? []);
        
        // Nombre de promotions actives
        $active_promotions = count(array_filter($data['promotions'] ?? [], function ($promotion) {
            return $promotion['status'] === Enums\ACTIVE;
        }));
        
        // Récupérer la promotion courante
        $current_promotion = $model['get_current_promotion']();
        
        // Nombre d'apprenants dans la promotion courante
        $current_promotion_apprenants = 0;
        if ($current_promotion) {
            $current_promotion_apprenants = count(array_filter($data['apprenants'] ?? [], function ($apprenant) use ($current_promotion) {
                return $apprenant['promotion_id'] === $current_promotion['id'];
            }));
        }
        
        // Nombre de référentiels dans la promotion courante
        $current_promotion_referentiels = 0;
        if ($current_promotion) {
            $current_promotion_referentiels = count($current_promotion['referentiels'] ?? []);
        }
        
        return [
            'total_promotions' => $total_promotions,
            'active_promotions' => $active_promotions,
            'current_promotion_apprenants' => $current_promotion_apprenants,
            'current_promotion_referentiels' => $current_promotion_referentiels
        ];
    },
    
    // Fonctions pour les apprenants
    'get_all_apprenants' => function () use (&$model) {
        $data = $model['read_data']();
        return $data['apprenants'] ?? [];
    },
    
    'get_apprenants_by_promotion' => function ($promotion_id) use (&$model) {
        $data = $model['read_data']();
        
        // Filtrer les apprenants par promotion
        $apprenants = array_filter($data['apprenants'] ?? [], function ($apprenant) use ($promotion_id) {
            return $apprenant['promotion_id'] === $promotion_id;
        });
        
        return array_values($apprenants);
    },
    
    'get_apprenant_by_id' => function ($id) use (&$model) {
        $data = $model['read_data']();
        
        // Filtrer les apprenants par ID
        $filtered_apprenants = array_filter($data['apprenants'] ?? [], function ($apprenant) use ($id) {
            return $apprenant['id'] === $id;
        });
        
        return !empty($filtered_apprenants) ? reset($filtered_apprenants) : null;
    },
    
    'get_apprenant_by_matricule' => function ($matricule) use (&$model) {
        $data = $model['read_data']();
        
        // Filtrer les apprenants par matricule
        $filtered_apprenants = array_filter($data['apprenants'] ?? [], function ($apprenant) use ($matricule) {
            return $apprenant['matricule'] === $matricule;
        });
        
        return !empty($filtered_apprenants) ? reset($filtered_apprenants) : null;
    },
    
    'generate_matricule' => function () use (&$model) {
        $data = $model['read_data']();
        $year = date('Y');
        $count = count($data['apprenants'] ?? []) + 1;
        
        return 'ODC-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
];