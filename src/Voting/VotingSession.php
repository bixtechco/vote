<?php

namespace Src\Voting;

use Diver\Database\Eloquent\Model;
use Diver\Dataset\Bank;
use Illuminate\Database\Eloquent\SoftDeletes;

class VotingSession extends Model
{
    use SoftDeletes;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [

    ];

    CONST STATUS_DRAFT = 0;
    CONST STATUS_ACTIVE = 1;
    CONST STATUS_COMPLETED = 2;
    CONST STATUS_INACTIVE = 3;

    public function association()
    {
        return $this->belongsTo(Association::class, 'association_id');
    }

    public function votingSessionMembers()
    {
        return $this->hasMany(VotingSessionMember::class, 'voting_session_id');
    }
}
