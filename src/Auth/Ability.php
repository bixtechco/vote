<?php

namespace Src\Auth;

use Diver\Database\Eloquent\Traits\Model;
use Silber\Bouncer\Database\Ability as BaseAbility;

class Ability extends BaseAbility
{
    use Model;

    CONST MANAGE_ROOTS = 'manage roots';
    CONST MANAGE_ADMINISTRATORS = 'manage administrators';
    CONST MANAGE_USERS = 'manage users';
    CONST MANAGE_ASSOCIATIONS = 'manage associations';
    CONST MANAGE_VOITNG_SESSIONS = 'manage voting sessions';

    public static function getAllAdminAbilities()
    {
        return [
            // self::MANAGE_ROOTS,
            // self::MANAGE_ADMINISTRATORS,
//            self::MANAGE_USERS,
            self::MANAGE_ASSOCIATIONS,
            self::MANAGE_VOITNG_SESSIONS,
        ];
    }
}
