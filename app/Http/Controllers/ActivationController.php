<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivationController extends Controller
{
    /**
     * le jeton string qui est associé à l'utilisateur qui va activer son compte qui était inactif
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function index($token)
    {
        return view("activation.index",["token"=>$token]);
    }
}
