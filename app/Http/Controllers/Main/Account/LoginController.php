<?php

namespace App\Http\Controllers\Main\Account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Src\People\User;
use Src\Voting\Association;
use Src\Voting\Facades\AssociationRepository;
use Src\Voting\Invitation;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->redirectTo = route('main.main.home');

        $this->middleware("guest:,{$this->redirectTo}")
            ->except('logout');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * Show login page
     */
    public function showLogin(Request $request)
    {
        $token = $request->query('token');

        return view('main.account.login', ['token' => $token]);
    }

    public function login(Request $request)
    {
        $principalId = $request->input('principalId');
        $principalId = trim($principalId, '"');

        Log::info('Login attempt', ['principalId' => $principalId]);

        $user = User::firstOrCreate(['principal_id' => $principalId]);
        $user->status = User::STATUS_ACTIVE;
        $user->save();

        Auth::login($user);

        $token = $request->input('token');

        // Log the retrieved token
        Log::info('Token in request', ['token' => $token]);

        if ($token) {
            $invitation = Invitation::where('token', $token)->first();

            // Log the found invitation
            Log::info('Invitation query result', ['invitation' => $invitation]);

            if ($invitation) {
                $user->email = $invitation->email;
                $user->save();

                $input = [
                    'user_id' => $user->id,
                    'is_admin' => false,
                ];

                Log::info('Token received', ['token' => $token]);
                Log::info('Invitation found', ['invitation' => $invitation]);

                AssociationRepository::addMember(Association::find($invitation->association_id), $input);

                Invitation::where('token', $token)->delete();
            }
        }

        return redirect()->route('main.main.home');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('main.show-login');
    }
}
