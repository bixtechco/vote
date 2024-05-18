<?php

namespace App\Http\Requests\Main\Voting\VotingSession;

use Diver\Database\Eloquent\Builder;
use Diver\Http\Requests\QueryRequest as Request;
use Src\Voting\Association;
use Src\Voting\VotingSession;

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
        $profile = $query->link('profile');

        $query->where(function (Builder $query) use ($profile, $value){
            $query->orWhere("email", 'LIKE', "%{$value}%");
            $query->orWhere("{$profile}.full_name", 'LIKE', "%{$value}%");
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
}
