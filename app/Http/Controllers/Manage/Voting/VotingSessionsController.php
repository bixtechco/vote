<?php

namespace App\Http\Controllers\Manage\Voting;

use Src\Auth\Ability;
use App\Http\Controllers\ManageAuthedController;
use App\Http\Requests\Manage\Voting\VotingSessions\QueryRequest;

class VotingSessionsController extends ManageAuthedController
{
    /**
     * Get the permissions that apply to the controller.
     *
     * @return array
     */
    protected function permissions()
    {
        return [
          Ability::MANAGE_ROOTS,
          Ability::MANAGE_VOITNG_SESSIONS,
        ];
    }

    /**
     * List action
     *
     * @param \App\Http\Requests\Manage\Voting\VotingSessions\QueryRequest $queried
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(QueryRequest $queried)
    {
        $votingSessions = $queried->query()->latest()->paginate(20);

        return view('manage.voting.voting-sessions.list', compact('votingSessions'))->with([
            'filters' => $queried->filters(),
        ]);
    }
}
