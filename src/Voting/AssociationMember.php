<?php

namespace Src\Voting;

use Src\People\User;
use Diver\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssociationMember extends Model
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

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
