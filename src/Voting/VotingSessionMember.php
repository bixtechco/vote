<?php

namespace Src\Voting;

use Src\People\User;
use Src\Voting\Association;
use Src\Voting\VotingSession;
use Diver\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VotingSessionMember extends Model
{
    use SoftDeletes;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [

    ];

    public function association()
    {
        return $this->belongsTo(Association::class, 'association_id');
    }

    public function votingSession()
    {
        return $this->belongsTo(VotingSession::class, 'voting_session_id');
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

