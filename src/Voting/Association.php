<?php

namespace Src\Voting;

use Src\People\User;
use Diver\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Association extends Model
{
    use SoftDeletes;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [

    ];

    CONST STATUS_ACTIVE = 0;
    CONST STATUS_INACTIVE = 1;

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function associationMembers()
    {
        return $this->hasMany(AssociationMember::class, 'association_id');
    }

    public function votingSessions()
    {
        return $this->hasMany(VotingSession::class, 'association_id');
    }
}
