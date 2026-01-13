<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    if (Auth::check()) {
        $user = Auth::user();

        // Recupera tutte le sessioni dell'utente ordinate per attività
        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->get();

        // Se ci sono più di una sessione, verifica se quella corrente è "vecchia"
        if ($sessions->count() > 1) {
            $otherSessions = $sessions->skip(1); // salta la sessione più recente

            // Se la sessione corrente è una delle vecchie, rimuovila e blocca l'accesso
            if ($otherSessions->contains('id', $request->session()->getId())) {
                DB::table('sessions')->where('id', $request->session()->getId())->delete();
                return redirect()->route('login.create', ['expired' => 1]);
            }
        }
    }

    return $next($request);
}

}
