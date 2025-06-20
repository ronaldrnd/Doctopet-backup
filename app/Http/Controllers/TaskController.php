<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function Overview()
    {
        return view('tasks.overview');
    }


    public function View($id){

        return view('tasks.view',compact('id'));
    }
}
