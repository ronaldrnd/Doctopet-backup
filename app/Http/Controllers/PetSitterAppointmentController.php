<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetSitterAppointmentController extends Controller
{
    public function index($animalId, $specialiteId, $serviceTypeId, $serviceTemplateId){
        return view('formulaire.petsitter.index',
        [

            'animalId' => $animalId,
            'specialiteId' => $specialiteId,
            'serviceTypeId' => $serviceTypeId,
            'serviceTemplateId' => $serviceTemplateId
        ]);
    }
}
