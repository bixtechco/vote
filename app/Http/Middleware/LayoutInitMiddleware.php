<?php

namespace App\Http\Middleware;

use Closure;
use App\Core\Bootstrap\BootstrapDefault;

class LayoutInitMiddleware
{
    public function handle($request, Closure $next)
    {
        (new BootstrapDefault())->init();

        return $next($request);
    }
}
