<?php

namespace App\Enums;

use Ingenia\Avid\Contracts\Optionable;
use Ingenia\Avid\Traits\AsOptions;

enum UserRole: string implements Optionable
{
    use AsOptions;

    case ADMIN = 'admin';
    case USER = 'user';
}