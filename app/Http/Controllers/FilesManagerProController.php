<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesManagerProController extends Controller
{
    public function index(){
        return view('filemanager.index');
    }
}
