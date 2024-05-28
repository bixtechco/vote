<?php


namespace App\Http\Controllers\Main;


use App\Http\Controllers\AuthedController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
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

        return view('main.home',compact('ogTitle','ogDescription'));
    }

}
