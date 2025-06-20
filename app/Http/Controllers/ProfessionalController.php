<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfessionalController extends Controller
{

    public function register()
    {

    }

    public function Overview()
    {
        return view('professional.overview_services');
    }

    public function view(int $id)
    {
        return view('professional.view_services',
        [
            'id' => $id
        ]);
    }
}
