<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * AdminMiddleware checks if the authenticated user is an admin.
 * If the user is not authenticated or not an admin, it redirects them with an error message.
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): \Illuminate\Http\Response  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
                $user = Auth::user();

                if ($user->admin) {
                    return $next($request);
                } else {
                    return redirect()->to(url()->previous())->with('error', __('error.admin_required'));
                }
        } else {
            return redirect()->route('login.create')->with('error', __('error.login_required'));
        }
    }
}