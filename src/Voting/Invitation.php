<?php

namespace Src\Voting;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    public function association()
    {
        return $this->belongsTo(Association::class);

    }
}
