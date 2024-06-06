<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($request->route()->named('main.account.profile.edit') || $request->route()->named('main.account.profile.update')) {
            return $next($request);
        }

        $user = $user->fresh();

        if (empty($user->profile->full_name) || empty($user->email)) {
            return redirect()->route('main.account.profile.edit');
        }

        return $next($request);
    }

}
