<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctopetSimulatorController extends Controller
{
    public function index()
    {
        return view("doctopet.simulator");
    }
}
