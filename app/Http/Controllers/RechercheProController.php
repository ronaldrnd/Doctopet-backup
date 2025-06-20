<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RechercheProController extends Controller
{
    public function index()
    {
        return view ("search.pro_names");
    }
}
