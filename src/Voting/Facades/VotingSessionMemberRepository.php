<?php

namespace Src\Voting\Facades;

use Illuminate\Support\Facades\Facade;

class VotingSessionMemberRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Src\Voting\Repositories\VotingSessionMemberRepository::class;
    }
}


