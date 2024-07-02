<?php

namespace App\Http\Controllers\Main\Voting;

use App\Http\Controllers\AuthedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Main\Voting\Association\StoreRequest;
use App\Http\Requests\Main\Voting\Association\UpdateRequest;
use App\Http\Requests\Main\Voting\Association\QueryRequest;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Mail;
use Src\Auth\Role;
use Src\People\User;
use Src\Voting\Association;
use Src\Voting\Facades\AssociationRepository;
use Src\Voting\Facades\InvitationRepository;
use Src\Voting\Invitation;

class AssociationsController extends AuthedController
{
    public function index(QueryRequest $queried)
    {
        $userId = auth()->id();

        $associations = $queried->query()
            ->whereHas('associationMembers', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();

        return view('main.voting.associations.list', compact('associations'))->with([
            'filters' => $queried->filters(),
        ]);
    }


    public function create()
    {
        return view('main.voting.associations.create');
    }

    public function store(StoreRequest $request)
    {
        $input['association']['name'] = $request->input('name');
        $input['association']['description'] = $request->input('description');
        $input['association']['status'] = Association::STATUS_ACTIVE;
        $input['association']['created_by'] = auth()->id();

        $association = AssociationRepository::create($input);

        flash()->success("Association <strong>{$association->name}</strong> is created.");


        return redirect()->route('main.voting.associations.list');
    }

    public function show($id)
    {
        $association = Association::findOrFail($id);
        return view('main.voting.associations.show', compact('association'));
    }

    public function edit($id)
    {
        $association = Association::findOrFail($id);
        return view('main.voting.associations.edit', compact('association'));
    }

    public function update($id, UpdateRequest $request)
    {
        $association = Association::findOrFail($id);

        $input['association']['name'] = $request->input('name');
        $input['association']['description'] = $request->input('description');
        $input['association']['status'] = $request->input('status');
        $input['association']['updated_by'] = auth()->id();

        $association = AssociationRepository::update($association, $input);

        flash()->success("Associate <strong>{$association->name}</strong> is updated.");

        return redirect()->route('main.voting.associations.list');
    }

    public function destroy($id)
    {
        $association = Association::findOrFail($id);

        AssociationRepository::delete($association);

        flash()->success("Association <strong>{$association->name}</strong> is deleted.");

        return redirect()->route('main.voting.associations.list');
    }

    public function active($id)
    {
        $association = Association::findOrFail($id);

        $association->status = Association::STATUS_ACTIVE;
        $association->save();

        flash()->success("Association <strong>{$association->name}</strong> is activated.");

        return redirect()->route('main.voting.associations.list');
    }

    public function inactive($id)
    {
        $association = Association::findOrFail($id);

        $association->status = Association::STATUS_INACTIVE;
        $association->save();

        flash()->success("Association <strong>{$association->name}</strong> is inactivated.");

        return redirect()->route('main.voting.associations.list');
    }

    public function viewMembers($id)
    {
        $association = Association::findOrFail($id);
        $members = $association->associationMembers()->get();
        $member = $members->first();
        $invitations = Invitation::where('association_id', $association->id)->get();


        return view('main.voting.associations.members', compact('association', 'members', 'member', 'invitations'));
    }

    public function showAddMember($id)
    {
        $association = Association::findOrFail($id);

        return view('main.voting.associations.add-member', compact('association'));
    }

    public function addMember(Request $request, $id)
    {
        $association = Association::findOrFail($id);
        $user = Auth::user();
        $member = $association->associationMembers()->where('user_id', $user->id)->first();

        if ($member && $member->is_admin) {
            $email = $request->input('email');
            $principalId = $request->input('principal_id');

            Log::info('Email and Principal ID', ['email' => $email, 'principal_id' => $principalId]);

            $newMember = null;
            if ($email) {
                $newMember = User::where('email', $email)->first();
            } elseif ($principalId) {
                $newMember = User::where('principal_id', $principalId)->first();
            }

            Log::info('New Member', ['newMember' => $newMember]);

            if ($newMember) {
                $existingMember = $association->associationMembers()->where('user_id', $newMember->id)->first();

                if ($existingMember) {
                    flash()->error('Member already exists in the association.');
                    return redirect()->back()->with('error', 'Member already exists in the association.');
                }

                $input = [
                    'user_id' => $newMember->id,
                    'is_admin' => false,
                ];
                AssociationRepository::addMember($association, $input);

                return redirect()->route('main.voting.associations.view-members', $association->id);
            } else {
                $this->sendInvitationEmail($email, $association);

                return redirect()->back()->with('success', 'Invitation sent to the email provided.');
            }
        } else {
            return redirect()->back()->with('error', 'You are not allowed to add members.');
        }
    }

    protected function sendInvitationEmail($email, $association)
    {
        $token = Str::random(60);

        $input['invitation']['email'] = $email;
        $input['invitation']['association_id'] = $association->id;
        $input['invitation']['token'] = $token;

        InvitationRepository::create($input);

        Mail::to($email)->send(new InvitationMail($association, $token));

    }


    public function setAdmin($id, $memberId)
    {
        Log::info("SetAdmin called with association ID: $id and member ID: $memberId");

        $association = Association::findOrFail($id);
        $member = $association->associationMembers()->where('user_id', $memberId)->first();

        if (!$member) {
            Log::error("Member not found with ID: $memberId");
            return back()->with('error', 'Member not found');
        }

        AssociationRepository::setAdmin($association, $member);

        Log::info("Member with ID: $memberId set as admin for association ID: $id");
        return back()->with('success', 'Member set as admin');
    }

    public function removeAdmin($id, $memberId)
    {
        Log::info("SetAdmin called with association ID: $id and member ID: $memberId");

        $association = Association::findOrFail($id);
        $member = $association->associationMembers()->where('user_id', $memberId)->first();

        if (!$member) {
            Log::error("Member not found with ID: $memberId");
            return back()->with('error', 'Member not found');
        }

        AssociationRepository::removeAdmin($association, $member);

        Log::info("Member with ID: $memberId set as admin for association ID: $id");
        return back()->with('success', 'Member set as admin');
    }



    public function removeMember($id, $memberId)
    {
        $association = Association::findOrFail($id);
        $member = $association->associationMembers()->where('id', $memberId)->first();

        AssociationRepository::removeMember($association, $member);
        return back();

    }

}
