<?php

namespace App\Services;

// Regroupement des fonctions de validation
$validator_services = [
    'is_empty' => function ($value) {
        return empty(trim($value));
    },
    
    'min_length' => function ($value, $min) {
        return strlen(trim($value)) >= $min;
    },
    
    'max_length' => function ($value, $max) {
        return strlen(trim($value)) <= $max;
    },
    
    'is_email' => function ($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    },
    
    'is_valid_image' => function ($file) {
        // Vérifier si le fichier est une image valide (JPG ou PNG) et sa taille
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return false;
        }
        
        $allowed_types = ['image/jpeg', 'image/png'];
        $max_size = 2 * 1024 * 1024; // 2MB en octets
        
        $file_info = getimagesize($file['tmp_name']);
        $file_type = $file_info ? $file_info['mime'] : '';
        
        return in_array($file_type, $allowed_types) && $file['size'] <= $max_size;
    },
    
    'validate_form' => function ($data, $rules) {
        $errors = [];
        
        $validate_rule = function($field, $rule, $rule_value, $data, &$errors) {
            $result = match($rule) {
                'required' => $rule_value && empty(trim($data[$field])) 
                    ? ["Le champ est obligatoire"] : [],
                'min_length' => !empty($data[$field]) && strlen(trim($data[$field])) < $rule_value 
                    ? ["Le champ doit contenir au moins $rule_value caractères"] : [],
                'max_length' => !empty($data[$field]) && strlen(trim($data[$field])) > $rule_value 
                    ? ["Le champ ne doit pas dépasser $rule_value caractères"] : [],
                'email' => $rule_value && !empty($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_EMAIL) 
                    ? ["Email invalide"] : [],
                default => []
            };
            
            if (!empty($result)) {
                if (!isset($errors[$field])) {
                    $errors[$field] = [];
                }
                $errors[$field] = array_merge($errors[$field], $result);
            }
        };
        
        $process_field = function($field, $field_rules) use ($data, &$errors, $validate_rule) {
            $rule_keys = array_keys($field_rules);
            array_map(function($rule) use ($field, $field_rules, $data, &$errors, $validate_rule) {
                $validate_rule($field, $rule, $field_rules[$rule], $data, $errors);
            }, $rule_keys);
        };
        
        $fields = array_keys($rules);
        array_map(function($field) use ($rules, $process_field) {
            $process_field($field, $rules[$field]);
        }, $fields);
        
        return $errors;
    }
];