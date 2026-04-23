<?php

namespace App\Enums;

use Ingenia\Avid\Contracts\Optionable;
use Ingenia\Avid\Traits\AsOptions;

enum TaskStatus: string implements Optionable
{
    use AsOptions;

    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
}