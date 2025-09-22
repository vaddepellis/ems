<?php

namespace App\Enum;

enum Status:string
{
    case APPROVED = 'APPROVED';
    case PENDING = 'PENDING';
    case REJECTED = 'REJECTED';
    public static function values():array{
        return array_column(self::cases(), 'value');
    }
}
