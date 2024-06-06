<?php


namespace App\Http\Controllers\Main;


use App\Http\Controllers\AuthedController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MainController extends AuthedController
{
    /**
     * Home page
     */
    public function home()
    {
        $ogTitle = '';
        $ogDescription = '';

        $user = Auth::user();

        if ($user && ($user->email == '' || $user->email == null)) {
            return redirect()->route('main.account.profile.edit');
        }

        $associations = $user->associations;

        $unvotedSessions = collect();

        foreach ($associations as $association) {
            $votingSessions = $association->votingSessions;

            $votedSessionIds = $user->votingSessionMembers()->pluck('voting_session_id');

            $unvotedSessionsForAssociation = $votingSessions->whereNotIn('id', $votedSessionIds);

            // Add the association id to each unvoted session
            foreach ($unvotedSessionsForAssociation as $session) {
                $session->association_id = $association->id;
            }

            $unvotedSessions = $unvotedSessions->concat($unvotedSessionsForAssociation);
        }

        return view('main.home', compact('ogTitle', 'ogDescription', 'unvotedSessions'));
    }

}
