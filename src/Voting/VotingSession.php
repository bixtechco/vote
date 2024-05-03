<?php

namespace Src\Voting;

use Src\People\User;
use Diver\Dataset\Bank;
use Diver\Database\Eloquent\Model;
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

    CONST STATUSES = [
        self::STATUS_DRAFT => [
            'name' => 'Draft',
            'color' => 'info'
        ],
        self::STATUS_ACTIVE => [
            'name' => 'Active',
            'color' => 'primary'
        ],
        self::STATUS_COMPLETED => [
            'name' => 'Completed',
            'color' => 'success'
        ],
        self::STATUS_INACTIVE => [
            'name' => 'Inactive',
            'color' => 'danger'
        ],
    ];

    public function association()
    {
        return $this->belongsTo(Association::class, 'association_id');
    }

    public function votingSessionMembers()
    {
        return $this->hasMany(VotingSessionMember::class, 'voting_session_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'voting_session_members', 'voting_session_id', 'user_id')->withPivot('votes');
    }

    public function calculateVotes()
    {
        $roleCandidates = $this->role_candidate_ids ? json_decode($this->role_candidate_ids) : [];
        $totalMembersVoted = $this->votingSessionMembers()->whereNotNull('votes')->count();
        $membersNotVoted = $this->members()->whereHas('votingSessionMembers', function($query){
            return $query->whereNull('voting_session_members.votes');
        })->get();

        $roleCandidates = collect($roleCandidates)->map(function($candidate, $key){
            return User::whereIn('id', $candidate)->get();
        });

        $voteCounts = [];

        foreach ($roleCandidates as $role => $candidates) {
            $roleVoteCounts = [];
            foreach ($candidates as $candidate) {
                $votes = $this->votingSessionMembers()->whereNotNull('votes')->get();
                $voteCount = $votes->where('votes->'.$role, $candidate->id)->count();
                
                $roleVoteCounts[$candidate->id] = $voteCount;
            }
            $voteCounts[$role] = $roleVoteCounts;
        }

        return [
            'vote_counts' => $voteCounts,
            'candidates' => $roleCandidates,
            'total_members_voted' => $totalMembersVoted,
            'members_not_voted' => $membersNotVoted,
        ];
    }

    public function getWinners()
    {
        $winners = $this->winner_ids ? json_decode($this->winner_ids) : null;
        $winners = collect($winners)->map(function($candidate, $key){
            return User::whereIn('id', $candidate)->get();
        });

        return $winners;
    }
}
