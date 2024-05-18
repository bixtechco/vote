<?php

namespace App\Http\Controllers\Main\Account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Src\People\User;

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
    public function showLogin()
    {
        return view('main.account.login');
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

        return redirect()->route('main.main.home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('main.show-login');
    }





}
