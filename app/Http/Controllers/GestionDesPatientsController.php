<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GestionDesPatientsController extends Controller
{
    public function overview()
    {
        return view("gestion_des_patients.overview");
    }
}
