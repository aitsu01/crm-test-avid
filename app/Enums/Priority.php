<?php

namespace App\Enums;

use Ingenia\Avid\Contracts\Optionable;
use Ingenia\Avid\Traits\AsOptions;

enum Priority: string implements Optionable
{
    use AsOptions;

    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
}
