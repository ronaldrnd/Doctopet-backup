<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function GuideSpecialite(){
        return view('docs.guide_specialite');
    }
}
