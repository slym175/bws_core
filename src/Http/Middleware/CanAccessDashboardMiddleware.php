<?php

namespace Bws\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanAccessDashboardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->can('access-dashboard')) {
            return abort(401);
        }
        return $next($request);
    }
}
