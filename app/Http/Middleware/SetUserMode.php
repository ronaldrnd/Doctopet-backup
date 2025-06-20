<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SetUserMode
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Par défaut, le mode sera "pro" pour un professionnel
            if (Auth::user()->estSpecialiste()) {
                session()->put('user_mode', session('user_mode', 'pro'));
            } else {
                session()->forget('user_mode'); // Pas de mode pour les clients classiques
            }
        }

        return $next($request);
    }
}
