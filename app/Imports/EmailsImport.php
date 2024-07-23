<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Mail;
use App\Mail\InvitationMail;
use Src\People\User;
use Src\Voting\Association;
use Src\Voting\Facades\InvitationRepository;
use Src\Voting\Facades\AssociationRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Src\Voting\Invitation;

class EmailsImport implements ToCollection, WithHeadingRow
{
    protected $association;

    public function __construct($associationId)
    {
        $this->association = Association::findOrFail($associationId);
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $email = $row['email'];

            if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $newMember = User::where('email', $email)->first();

                if ($newMember) {
                    $existingMember = $this->association->associationMembers()->where('user_id', $newMember->id)->first();

                    if (!$existingMember) {
                        $input = [
                            'user_id' => $newMember->id,
                            'is_admin' => false,
                        ];
                        AssociationRepository::addMember($this->association, $input);
                        Log::info('Added existing member', ['email' => $email]);
                    } else {
                        Log::info('Member already exists', ['email' => $email]);
                    }
                } else {
                    $existingInvitation = Invitation::where('email', $email)
                        ->where('association_id', $this->association->id)
                        ->first();
                    if (!$existingInvitation) {
                        $this->sendInvitationEmail($email);
                        Log::info('Invitation sent', ['email' => $email]);
                    } else {
                        Log::info('Invitation already sent', ['email' => $email]);
                    }
                }
            } else {
                Log::warning('Invalid email address', ['email' => $email]);
            }
        }
    }


    protected function sendInvitationEmail($email)
    {
        $token = Str::random(60);

        $input['invitation']['email'] = $email;
        $input['invitation']['association_id'] = $this->association->id;
        $input['invitation']['token'] = $token;

        InvitationRepository::create($input);

        Mail::to($email)->send(new InvitationMail($this->association, $token));
    }
}
