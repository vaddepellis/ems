<?php

namespace App\Enum;

enum LeaveType:string
{
    case FULL_DAY = 'FULL_DAY';
    case HALF_DAY = 'HALF_DAY';
    case FIRST_HALF = 'FIRST_HALF';
    case SECOND_HALF = 'SECOND_HALF';

    public static function values():array{
        return array_column(self::cases(), 'value');
    }
}
