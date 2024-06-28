<?php

namespace Src\Voting\Facades;

use Illuminate\Support\Facades\Facade;

class InvitationRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Src\Voting\Repositories\InvitationRepository::class;
    }
}


