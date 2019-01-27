<?php

namespace Superadmin\Backend\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App;
use Illuminate\View\ViewServiceProvider;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {	
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('admin/login');
            }
        }
        $access=App::make('access');
        if($access->role()!=1 && !$access->allow($request)){
        	 return redirect()->guest('admin/nopermissions');
        }
        return $next($request);
    }
}
