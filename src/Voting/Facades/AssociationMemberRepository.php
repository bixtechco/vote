<?php

namespace Src\Voting\Facades;

use Illuminate\Support\Facades\Facade;

class AssociationMemberRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Src\Voting\Repositories\AssociationMemberRepository::class;
    }
}


