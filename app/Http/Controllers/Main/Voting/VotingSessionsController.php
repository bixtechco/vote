<?php

namespace App\Http\Controllers\Main\Voting;

use App\Http\Controllers\AuthedController;
use App\Http\Requests\Main\Voting\VotingSession\QueryRequest;
use App\Http\Requests\Main\Voting\VotingSession\StoreRequest;
use App\Http\Requests\Main\Voting\VotingSession\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mail;
use Src\People\User;
use Src\Voting\Association;
use Src\Voting\Facades\VotingSessionMemberRepository;
use Src\Voting\Facades\VotingSessionRepository;
use Src\Voting\VotingSession;
use Src\Voting\VotingSessionMember;

class VotingSessionsController extends AuthedController
{
    public function index(QueryRequest $queried, $id)
    {
        $association = Association::findOrFail($id);
        $votingSessions = VotingSession::where('association_id', $association->id)->get();

        return view('main.voting.voting-sessions.list', compact('votingSessions', 'association'))->with([
            'filters' => $queried->filters(),
        ]);
    }

    public function create($id)
    {
        $association = Association::findOrFail($id);
        $users = $association->associationMembers()->get();

        return view('main.voting.voting-sessions.create', compact('association', 'users'));
    }

    public function store(StoreRequest $request, $id)
    {
        $roleCandidateIds = $request->input('role_candidate_ids');

        $formattedRoleCandidateIds = [];
        foreach ($roleCandidateIds as $roleCandidateId) {
            $formattedRoleCandidateIds[$roleCandidateId['position_name']] = $roleCandidateId['candidate_ids'];
        }

        $input['voting_session']['association_id'] = $id;
        $input['voting_session']['name'] = $request->input('name');
        $input['voting_session']['description'] = $request->input('description');
        $input['voting_session']['year'] = $request->input('year');
        $input['voting_session']['role_candidate_ids'] = json_encode($formattedRoleCandidateIds);
        $input['voting_session']['status'] = VotingSession::STATUS_DRAFT;
        $input['voting_session']['start_date'] = $request->input('start_date');
        $input['voting_session']['end_date'] = $request->input('end_date');
        $input['voting_session']['created_by'] = auth()->id();

        $votingSession = VotingSessionRepository::create($input);

        flash()->success("Voting session <strong>{$votingSession->name}</strong> is created.");

        return redirect()->route('main.voting.voting-sessions.list', $id);
    }

    public function show($id, $votingSessionId)
    {
        $votingSession = VotingSession::findOrFail($votingSessionId);
        $association = Association::findOrFail($id);
        $votingSessionMembers = $votingSession->votingSessionMembers()->get();
        $usersNotVoted = $association->associationMembers()->whereNotIn('user_id', $votingSessionMembers->pluck('user_id'))->get();
        $votes = $votingSession->votingSessionMembers()->pluck('votes');

        $voteCounts = [];

        foreach ($votes as $vote) {
            $voteArray = json_decode($vote, true);

            foreach ($voteArray as $position => $candidate) {
                if (!isset($voteCounts[$position][$candidate])) {
                    $voteCounts[$position][$candidate] = 0;
                }
                $voteCounts[$position][$candidate]++;
            }
        }

        $candidates = [];
        foreach ($voteCounts as $position => $candidatesInPosition) {
            foreach ($candidatesInPosition as $candidateId => $voteCount) {
                $candidates[$position][$candidateId] = [
                    'user' => User::findOrFail($candidateId),
                    'votes' => $voteCount
                ];
            }
        }

        return view('main.voting.voting-sessions.show', compact('association', 'votingSession', 'votingSessionMembers', 'usersNotVoted', 'candidates'));
    }

    public function edit($id, $votingSessionId)
    {
        $association = Association::findOrFail($id);
        $users = $association->associationMembers()->get();
        $votingSession = VotingSession::findOrFail($votingSessionId);

        return view('main.voting.voting-sessions.edit', compact('association', 'votingSession', 'users'));
    }

    public function update($id, $votingSessionId, UpdateRequest $request)
    {
        $association = Association::findOrFail($id);
        $votingSession = VotingSession::findOrFail($votingSessionId);

        $roleCandidateIds = $request->input('role_candidate_ids');

        $formattedRoleCandidateIds = [];
        foreach ($roleCandidateIds as $roleCandidateId) {
            $formattedRoleCandidateIds[$roleCandidateId['position_name']] = $roleCandidateId['candidate_ids'];
        }

        $input['voting_sessions']['name'] = $request->input('name');
        $input['voting_sessions']['description'] = $request->input('description');
        $input['voting_sessions']['year'] = $request->input('year');
        $input['voting_session']['role_candidate_ids'] = json_encode($formattedRoleCandidateIds);
        $input['voting_sessions']['start_date'] = $request->input('start_date');
        $input['voting_sessions']['end_date'] = $request->input('end_date');
        $input['voting_sessions']['status'] = $request->input('status');

        $votingSession = VotingSessionRepository::update($votingSession, $input);

        flash()->success("Voting session <strong>{$votingSession->name}</strong> is updated.");

        return back();
    }

    public function active($id, $votingSessionId)
    {
        $votingSession = VotingSession::findOrFail($votingSessionId);

        VotingSessionRepository::active($votingSession);

        flash()->success("Voting Session <strong>{$votingSession->name}</strong> is activated.");

        return back();
    }

    public function inactive($id, $votingSessionId)
    {
        $votingSession = VotingSession::findOrFail($votingSessionId);

        VotingSessionRepository::inactive($votingSession);

        flash()->success("Voting Session <strong>{$votingSession->name}</strong> is deactivated.");

        return back();
    }

    public function destroy($id, $votingSessionId)
    {
        $votingSession = VotingSession::findOrFail($votingSessionId);

        VotingSessionRepository::delete($votingSession);

        flash()->success("Voting Session <strong>{$votingSession->name}</strong> is deleted.");

        return back();
    }

    public function vote(Request $request, $id, $votingSessionId)
    {
        Log::info('Request data:', $request->all());

        $votingSession = VotingSession::findOrFail($votingSessionId);

        $votes = $request->input('votes');
        $blockIndex = $request->input('block_index');
        Log::info('Block index:', ['blockIndex' => $blockIndex]);
        $input['voting_session_member']['association_id'] = $id;
        $input['voting_session_member']['voting_session_id'] = $votingSessionId;
        $input['voting_session_member']['user_id'] = auth()->id();
        $input['voting_session_member']['votes'] = json_encode($votes);
        $input['voting_session_member']['block_index'] = $blockIndex;

        Log::info('Voting session member input:', $input);
        $votingSessionMember = VotingSessionMemberRepository::create($input);
        Log::info('Created voting session member:', $votingSessionMember->toArray());

        flash()->success("You have voted for <strong>{$votingSession->name}</strong>.");

        return response()->json([
            'success' => true,
            'votingSessionMember' => $votingSessionMember,
        ]);
    }

    public function closeVote(Request $request, $id, $votingSessionId)
    {
        $votingSession = VotingSession::findOrFail($votingSessionId);

        $votes = $votingSession->votingSessionMembers()->pluck('votes');

        $voteCounts = [];

        foreach ($votes as $vote) {
            $voteArray = json_decode($vote, true);

            foreach ($voteArray as $position => $candidate) {
                if (!isset($voteCounts[$position][$candidate])) {
                    $voteCounts[$position][$candidate] = 0;
                }
                $voteCounts[$position][$candidate]++;
            }
        }

        $winners = [];
        foreach ($voteCounts as $position => $candidates) {
            $winners[$position] = array_search(max($candidates), $candidates);
        }

        $input['voting_session']['winner_ids'] = json_encode($winners);

        VotingSessionRepository::update($votingSession, $input);

        $association = $votingSession->association;
        $users = $association->associationMembers()->get();

        foreach ($users as $user) {
            Log::info('Processing user: ' . $user->member->id);
            if ($user->member->email) {
                Mail::to($user->member->email)->send(new \App\Mail\VotingClosed($votingSession));
                Log::info('Voting closed email sent to: ' . $user->member->email);
            } else {
                Log::warning('No email address for user: ' . $user->member->id);
            }
        }
        flash()->success("You have closed the vote for <strong>{$votingSession->name}</strong> and the winners have been announced.");

        return back();
    }


    public function history()
    {
        $votingSessionMembers = VotingSessionMember::where('user_id', auth()->id())->get();

        return view('main.voting.voting-sessions.history', compact('votingSessionMembers'));
    }

}
