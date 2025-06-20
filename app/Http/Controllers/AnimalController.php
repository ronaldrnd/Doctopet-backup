<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index()
    {
        return view('animals.index');
    }

    public function view($id)
    {
        return view('animals.view',[
            'animal' => Animal::findOrFail($id)
        ]);
    }

    public function create()
    {
        return view('animals.create');
    }

    public function store(Request $request)
    {
        // Handle saving the animal
    }

    public function edit($id)
    {
        return view('animals.edit');
    }

    public function update(Request $request, $id)
    {
        // Handle updating the animal
    }

    public function destroy($id)
    {
        // Handle deleting the animal
    }
}
