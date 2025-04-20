<?php

namespace App\Enums;

enum Path: string
{
    case VIEW_PATH = 'app/views/';
    case LAYOUT_PATH = 'app/views/layout/';
    case AUTH_VIEW_PATH = 'app/views/auth/';
    case PROMOTION_VIEW_PATH = 'app/views/promotion/';
    case REFERENTIEL_VIEW_PATH = 'app/views/referentiel/';
    case ERROR_PATH = 'app/views/error/';
    case DATA_PATH = __DIR__ . '/../../app/data/data.json';
    case ASSETS_PATH = 'public/assets/';
    case UPLOAD_PATH = 'public/assets/images/uploads/';
    case UPLOAD_DIR = __DIR__ . '/../../public/assets/images/uploads';
    // Suppression de DATA_FILE car il a la même valeur que DATA_PATH
}