<?php

namespace App\Http\Controllers\Main\Account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Src\People\User;

class LoginController extends Controller
{
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
