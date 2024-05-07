<?php

namespace App\Http\Requests\Manage\Voting\VotingSessions;

use Carbon\Carbon;
use Src\People\User;
use Src\Voting\Association;
use Src\Voting\VotingSession;
use Diver\Database\Eloquent\Builder;
use Diver\Http\Requests\QueryRequest as Request;

class QueryRequest extends Request
{
    /**
     * Eloquent model class that to be filtered
     *
     * @var string
     */
    protected $model = VotingSession::class;

    /**
     * Filterable
     *
     * @var array
     */
    protected $filterable = [
        'search',
        'status',
        'association',
        'user'
    ];

    /**
     * Search param
     *
     * @param $value
     *
     * @return array
     */
    protected function paramSearch($value)
    {
        return [
            'title' => 'Search',
            'formattedValue' => $value,
        ];
    }

    /**
     * Filter search
     *
     * @param \Diver\Database\Eloquent\Builder $query
     * @param $value
     */
    protected function filterSearch(Builder $query, $value)
    {
        $query->where(function (Builder $query) use ($value){
            $query->orWhere("name", 'LIKE', "%{$value}%");
        });
    }

    /**
     * Status param
     *
     * @param $value
     *
     * @return array
     */
    protected function paramStatus($value)
    {
        return [
            'title' => 'Status',
            'formattedValue' => $value,
        ];
    }

    /**
     * Filter status
     *
     * @param \Diver\Database\Eloquent\Builder $query
     * @param $value
     */
    protected function filterStatus(Builder $query, $value)
    {
        $query->whereIn('status', $value);
    }

    /**
     * Association param
     *
     * @param $value
     *
     * @return array
     */
    protected function paramAssociation($value)
    {
        $association = Association::findOrFail($value);
        return [
            'title' => 'Association',
            'formattedValue' => $association->name,
        ];
    }

    /**
     * Filter association
     *
     * @param \Diver\Database\Eloquent\Builder $query
     * @param $value
     */
    protected function filterAssociation(Builder $query, $value)
    {
        $query->where('association_id', $value);
    }

    /**
     * User param
     *
     * @param $value
     *
     * @return array
     */
    protected function paramUser($value)
    {
        $user = User::find($value);
        return [
            'title' => 'User',
            'formattedValue' => optional($user->profile)->full_name ?? $user->email,
        ];
    }

    /**
     * Filter user
     *
     * @param \Diver\Database\Eloquent\Builder $query
     * @param $value
     */
    protected function filterUser(Builder $query, $value)
    {
        $query->whereHas('votingSessionMembers', function (Builder $query) use ($value) {
            $query->where('user_id', $value);
        });
    }
}
