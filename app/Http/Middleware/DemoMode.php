<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DemoMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $env = env("DEMO_MODE");

        $route = Route::current()->getName();

        if ($route == 'user.login' || $route == 'user.logout' || $route == 'admin.login' || $route == 'admin.logout') {
            return $next($request);
        }

        if ($env == true) {
            $method = $request->method();
            if ($method == 'POST' || $method == 'PUT'  || $method == 'DELETE' || $method == 'PATCH') {
                $notification = ['message' => 'This action is blocked in demo mode!', 'alert-type' => 'error'];
                return redirect()->back()->with($notification);
            }
        }

        return $next($request);
    }
}
