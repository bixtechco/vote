<?php

namespace Src\Voting\Facades;

use Illuminate\Support\Facades\Facade;

class VotingSessionRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Src\Voting\Repositories\VotingSessionRepository::class;
    }
}


