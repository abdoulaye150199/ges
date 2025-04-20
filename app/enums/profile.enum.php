<?php

namespace App\Enums;

enum Profile: string
{
    case ADMIN = 'Admin';
    case VIGILE = 'Vigile';
    case APPRENANT = 'Apprenant';
}