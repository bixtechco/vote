<?php

namespace Src\Voting\Repositories;

use Throwable;
use Src\Voting\VotingSessionMember;
use Illuminate\Support\Facades\DB;

class VotingSessionMemberRepository
{
    /**
     * Create voting_session_member
     *
     * @param array $input
     *
     * @return mixed
     * @throws \Exception
     * @throws Throwable
     */
    public function create(array $input)
    {
        $data = data_all($input, [
            'voting_session_member.association_id',
            'voting_session_member.voting_session_member_id',
            'voting_session_member.user_id',
            'voting_session_member.votes',
        ]);

        return DB::transaction(function () use ($data) {
            $votingSessionMember = VotingSessionMember::create($data['voting_session_member']);

            return $votingSessionMember;
        });
    }

    /**
     * Update voting_session_member
     *
     * @param VotingSessionMember $votingSessionMember
     *
     * @return VotingSessionMember
     * @throws \Exception
     * @throws Throwable
     */
    public function update(VotingSessionMember $votingSessionMember, $input)
    {
        $data = data_only($input, [
            'voting_session_member.association_id',
            'voting_session_member.voting_session_member_id',
            'voting_session_member.user_id',
            'voting_session_member.votes',
        ]);

        return DB::transaction(function () use ($votingSessionMember, $data) {
            if ( ! empty($data['voting_session_member'])) {
                $votingSessionMember->update($data['voting_session_member']);
            }

            return $votingSessionMember->fresh();
        });
    }

    /**
     * Delete voting_session_member
     *
     * @param VotingSessionMember $votingSessionMember
     *
     * @return VotingSessionMember $votingSessionMember
     * @throws \Exception
     * @throws Throwable
     */
    public function delete(VotingSessionMember $votingSessionMember)
    {
        return DB::transaction(function () use ($votingSessionMember) {
            $votingSessionMember->delete();
            
            return $votingSessionMember;
        });
    }
}
