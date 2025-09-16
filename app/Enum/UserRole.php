<?php

namespace App\Enum;

enum UserRole :string
{
    case USER = 'USER';
    case ADMIN = 'ADMIN';
    case SUPER_ADMIN = 'SUPER_ADMIN';

    public static function values():array{
        return array_column(self::cases(), 'value');
    }
    
}
