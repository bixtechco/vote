<?php

namespace Src\Voting\Repositories;

use Throwable;
use Src\People\User;
use Src\Voting\VotingSession;
use Illuminate\Support\Facades\DB;
use Src\Voting\VotingSessionMember;

class VotingSessionRepository
{
    /**
     * Create voting_session
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
            'voting_session.association_id',
            'voting_session.name',
            'voting_session.description',
            'voting_session.year',
            'voting_session.role_candidate_ids',
            'voting_session.start_date',
            'voting_session.end_date',
            'voting_session.winner_ids',
            'voting_session.created_by',
            'voting_session.status',
        ]);

        return DB::transaction(function () use ($data) {
            $votingSession = VotingSession::create($data['voting_session']);

            return $votingSession;
        });
    }

    /**
     * Update voting_session
     *
     * @param VotingSession $votingSession
     *
     * @return VotingSession
     * @throws \Exception
     * @throws Throwable
     */
    public function update(VotingSession $votingSession, $input)
    {
        $data = data_only($input, [
            'voting_session.association_id',
            'voting_session.name',
            'voting_session.description',
            'voting_session.year',
            'voting_session.role_candidate_ids',
            'voting_session.start_date',
            'voting_session.end_date',
            'voting_session.winner_ids',
            'voting_session.created_by',
            'voting_session.status',
        ]);

        return DB::transaction(function () use ($votingSession, $data) {
            if ( ! empty($data['voting_session'])) {
                $votingSession->update($data['voting_session']);
            }

            return $votingSession->fresh();
        });
    }

    /**
     * Delete voting_session
     *
     * @param VotingSession $votingSession
     *
     * @return VotingSession $votingSession
     * @throws \Exception
     * @throws Throwable
     */
    public function delete(VotingSession $votingSession)
    {
        return DB::transaction(function () use ($votingSession) {
            $votingSession->delete();

            return $votingSession;
        });
    }

    public function active(VotingSession $votingSession)
    {
        return DB::transaction(function () use ($votingSession) {
            $votingSession->status = VotingSession::STATUS_ACTIVE;
            $votingSession->save();

            return $votingSession;
        });
    }

    public function inactive(VotingSession $votingSession)
    {
        return DB::transaction(function () use ($votingSession) {
            $votingSession->status = VotingSession::STATUS_INACTIVE;
            $votingSession->save();

            return $votingSession;
        });
    }

}
