<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index($id)
    {

        // Si la page est visité par un spécialiste de santé et non un client
        // TODO : Faire en sorte que les admins puissent voir la page
        $user = User::find($id);
        if(!$user)
            return redirect("dashboard")->with("error","Cette utilisateur n'existe pas");

        if(Auth::user()->type == "S" || Auth::user()->id == $id || User::find($id)->type == "S"){
            $user = User::find($id);
        }
        else{
            return redirect("/")->with("failure","Vous n'avez pas assez d'autorisation pour voir cette page");
        }

        return view('profil.index',
            ["user" => $user]
        );
    }
}
