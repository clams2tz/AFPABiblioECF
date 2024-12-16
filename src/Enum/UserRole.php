<?php

namespace App\Enum;

enum UserRole: string
{
    case USER = 'ROLE_USER';
    case BANNED = 'banned';
    case ADMIN = 'ROLE_ADMIN';
}