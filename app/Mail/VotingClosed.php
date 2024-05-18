<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Src\Voting\VotingSession;

class VotingClosed extends Mailable
{
    use Queueable, SerializesModels;

    public $votingSession;
    public $association;

    public function __construct(VotingSession $votingSession)
    {
        $this->votingSession = $votingSession;
        $this->association = $votingSession->association;
    }

    public function build()
    {
        return $this->view('emails.voting-closed')
            ->with([
                'votingSession' => $this->votingSession,
                'association' => $this->association
            ]);
    }
}
