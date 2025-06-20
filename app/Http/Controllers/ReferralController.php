<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AmbassadorService;
use Illuminate\Http\Request;

class ReferralController extends Controller
{




    public static function applyReferral($code)
    {

        $ref = User::where('referral_code', $code)->first();

        if (!$ref) {
            return false;
        }

        $user = auth()->user();

        if ($user->vouch_receiver_id) {
            return back()->with('error', 'Vous avez déjà utilisé un code de parrainage.');
        }

        if (AmbassadorService::applyReferralCode($code, $user)) {
            return back()->with('success', 'Votre code de parrainage a été appliqué avec succès.');
        }

        return back()->with('error', 'Code invalide.');
    }
}
