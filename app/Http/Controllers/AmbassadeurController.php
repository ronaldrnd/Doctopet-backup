<?php

namespace App\Http\Controllers;

use App\Models\AmbassadorAccessCode;
use Illuminate\Http\Request;

class AmbassadeurController extends Controller
{
    public function verifyAccessCode(Request $request)
    {
        $request->validate(['access_code' => 'required|string']);

        $code = $request->input('access_code');
        $accessCode = AmbassadorAccessCode::where('code', $code)->where('used', false)->first();

        if (!$accessCode) {
            return redirect()->back()->with('error', 'Code invalide ou déjà utilisé.');
        }

        // Stocker dans la session
        session(['ambassador_access_code' => $code]);

        return redirect()->route('register.pro');
    }
}
