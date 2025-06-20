<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;

class CliniqueController extends Controller
{

    // Gérer sa clinique
    public function index($id)
    {
        $clinic = Clinic::find($id);
        if($clinic == null)
            return back()->with("error","Clinique introuvable");
        return view("clinique.manageClinique", [
            "clinic" => $clinic
        ]);
    }

    public function params($id)
    {
        $clinic = Clinic::find($id);
        if($clinic == null)
            return back()->with("error","Clinique introuvable");
        return view("clinique.params", [
            "clinic" => $clinic
        ]);
    }


}
