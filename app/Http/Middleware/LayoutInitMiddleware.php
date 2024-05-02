<?php

namespace App\Http\Middleware;

use App\Core\Bootstrap\BootstrapMain;
use Closure;
use App\Core\Bootstrap\BootstrapDefault;
use Illuminate\Support\Facades\Log;

class LayoutInitMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('LayoutInitMiddleware is being applied');

        (new BootstrapDefault())->init();
        (new BootstrapMain())->init();


        return $next($request);
    }
}
