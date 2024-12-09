<?php

namespace App\Enum;

enum UserRole: string
{
    case USER = 'user';
    case BANNED = 'banned';
    case ADMIN = 'admin';

}