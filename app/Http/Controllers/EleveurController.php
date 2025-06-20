<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EleveurController extends Controller
{
    public function Formulaire()
    {
        return view("eleveur.formulaire");
    }

    public function DashboardEleveur()
    {
        return view("eleveur.dashboard");
    }

    public function ContactEleveur($id){

        return view("eleveur.contact",
        ["id"=>$id]
        );
    }
}
