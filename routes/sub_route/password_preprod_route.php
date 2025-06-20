<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('password-protect', function () {
    return view('password-protect');
});

Route::post('password-protect', function (Request $request) {
    if ($request->password === env('ACCESS_PASSWORD', 'default_password')) {
        $request->session()->put('site_access_granted', true);
        return redirect('/');
    }

    return back()->withErrors(['password' => 'Mot de passe incorrect.']);
});
