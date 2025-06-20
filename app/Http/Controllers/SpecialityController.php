<?php

namespace App\Http\Controllers;

use App\Models\Specialite;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    public function index($id)
    {

        return view('specialities.show', compact('id'));
    }


    public function list()
    {
        // Récupérer toutes les spécialités
        $specialities = Specialite::all();

        // Retourner la vue avec les spécialités
        return view('specialities.list', compact('specialities'));
    }
}
