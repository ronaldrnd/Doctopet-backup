<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PasswordProtected
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si le mot de passe a été saisi
        if ($request->session()->has('site_access_granted')) {
            return $next($request);
        }

        // Rediriger vers une page protégée
        return redirect('password-protect');
    }
}
