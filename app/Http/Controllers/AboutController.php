<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{

    /**
     * Retourne la vue associée aux abonnements
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function InformationServicesSubscription()
    {
        return view("docs.information-services-subscription");
    }
}
