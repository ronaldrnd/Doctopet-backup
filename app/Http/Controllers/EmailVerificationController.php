<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    public function verify($token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return redirect('/profil/' . Auth::user()->id)->with('error', 'Le lien de vérification est invalide ou a expiré.');
        }

        $user->update([
            'email' => $user->temporary_email,
            'temporary_email' => null,
            'email_verification_token' => null,
        ]);


        return redirect('/profil/' . Auth::user()->id)->with('success', 'Votre adresse email a été mise à jour avec succès !');
    }
}


