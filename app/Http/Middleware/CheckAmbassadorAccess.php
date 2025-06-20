<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AmbassadorAccessCode;

class CheckAmbassadorAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si un code ambassadeur est stocké dans la session
        if (!session()->has('ambassador_access_code')) {
            return redirect()->route('waiting')->with('error', 'Vous devez entrer un code ambassadeur pour accéder à cette page.');
        }

        $code = session('ambassador_access_code');

        // Vérifie si le code est valide dans la base de données
        $accessCode = AmbassadorAccessCode::where('code', $code)->where('used', false)->first();

        if (!$accessCode) {
            session()->forget('ambassador_access_code'); // Supprimer le code invalide de la session
            return redirect()->route('waiting')->with('error', 'Le code ambassadeur est invalide ou déjà utilisé.');
        }

        return $next($request);
    }
}
