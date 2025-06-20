<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PresentationController extends Controller
{
    public function index()
    {
        return view('contact.index', [
            'company' => [
                'name' => 'Doctopet',
                'address' => 'Adresse inconnue',
                'representative' => 'Sasha BIRD',
                'linkedin' => 'https://www.linkedin.com/in/sasha-bird-1b3b4b258/',
                'phone' => '07 83 74 38 08',
                'email' => 'contact@doctopet.fr',
                'maintenance' => 'hugo.jacquel@atomixia.fr',
                'maintenance_company' => 'Atomixia',
                'maintenance_representative' => 'Hugo JACQUEL',
            ]
        ]);
    }
}
