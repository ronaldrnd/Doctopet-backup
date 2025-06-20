<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CooperationController extends Controller
{
    public function Overview()
    {
        return view("cooperation.overview");
    }
}
