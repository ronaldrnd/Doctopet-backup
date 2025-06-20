<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class UrgenceController extends Controller
{
    public function overview()
    {


        $currentTime = Carbon::now('Europe/Paris');
        $status = $currentTime->hour > 18 ? "nuit" : "jour";
        return view("urgence.overview",
        [
            "status" => $status,
        ]);
    }

    public function journee()
    {
        return view("urgence.journee");
    }
}
