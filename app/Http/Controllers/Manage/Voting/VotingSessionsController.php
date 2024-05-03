<?php

namespace App\Http\Controllers\Manage\Voting;

use Src\People\User;
use Src\Auth\Ability;
use Src\Voting\VotingSession;
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

    public function show($id){
        $votingSession = VotingSession::findOrFail($id);
        $data = $votingSession->calculateVotes();  
        $totalMembers = $votingSession->members()->count();      
        $data['winner_ids'] = $votingSession->winner_ids ? json_decode($votingSession->winner_ids) : null;     
        $winners = $votingSession->getWinners();
        
        return view('manage.voting.voting-sessions.show', compact('votingSession', 'data', 'totalMembers', 'winners'));
    }
}
