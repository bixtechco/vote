<?php

namespace App\Http\Controllers\Main\Account;

use App\Http\Controllers\AuthedController;
use App\Http\Requests\Profile\UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Src\People\Facades\SystemUserRepository;

class ProfileController extends AuthedController
{
    public function edit()
    {
        Log::info('ProfileController@edit');
        $user = Auth::user();

        return view('main.account.profile.edit', compact('user'));
    }

    public function update(UpdateRequest $request)
    {
        Log::info('ProfileController@update');
        $user = Auth::user();

        $input['user']['email']             = $request->input('email');
        $input['user_profile']['full_name'] = $request->input('full_name');
        $input['user_portrait']['file']     = $request->file('portrait');

        SystemUserRepository::update($user, $input);
        Log::info('ProfileController@update - after update');

        flash()->success('Your account has been successfully updated');

        return redirect(route('main.main.home'));
    }

}
