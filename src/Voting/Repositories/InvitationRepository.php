<?php

namespace Src\Voting\Repositories;

use Src\Voting\Invitation;
use Throwable;
use Src\Voting\VotingSessionMember;
use Illuminate\Support\Facades\DB;

class InvitationRepository
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
            'invitation.email',
            'invitation.association_id',
            'invitation.token',
        ]);

        return DB::transaction(function () use ($data) {
            $invitation = Invitation::create($data['invitation']);

            return $invitation;
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
