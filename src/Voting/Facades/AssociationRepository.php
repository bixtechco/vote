<?php

namespace Src\Voting\Facades;

use Illuminate\Support\Facades\Facade;

class AssociationRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Src\Voting\Repositories\AssociationRepository::class;
    }
}


