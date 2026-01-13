<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * SessionStatus middleware checks if the user has multiple active sessions.
 * If the current session is not the most recent, it deletes the session and redirects to the login page.
 */
class SessionStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            $sessions = DB::table('sessions')
                ->where('user_id', $user->id)
                ->orderBy('last_activity', 'desc')
                ->get();

            if ($sessions->count() > 1) {
                $otherSessions = $sessions->skip(1); 

                if ($otherSessions->contains('id', $request->session()->getId())) {
                    DB::table('sessions')->where('id', $request->session()->getId())->delete();
                    return redirect()->route('login.create', ['expired' => 1]);
                }
            }
        }
        return $next($request);
    }
}