<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentStatusUpdated;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{

    public function create($id)
    {
        return view('appointment.create', compact('id'));
    }


    public function overview()
    {
        return view("appointment.overview");
    }



    public function ManageClient()
    {
        return view("appointment.manage_client");
    }

    public function ManageSpecialist(int $idSpecialist){

    }


    public function confirm(Request $request)
    {
        return view("appointment.confirm", compact("request"));
    }


    public function show($id)
    {
        //$appointment = Appointment::with('animal', 'service', 'user')->findOrFail($id);

        return view('appointment.show',[
            "id" => $id,
        ]);
    }


    public function showPatient($id)
    {
        //$appointment = Appointment::with('animal', 'service', 'user')->findOrFail($id);

        return view('appointment.showPatient',[
            "id" => $id,
        ]);
    }


    public function calendar(){

        return view('appointment.calendar');
    }


    public function accept(Appointment $appointment, Request $request)
    {

        if ($request->token !== $appointment->confirmation_token || $appointment->token_used) {
            abort(403, 'Lien invalide');
        }

        if ($appointment->status !== 'pending') {
            return redirect()->route('appointments.overview')->with('error', 'Ce rendez-vous a déjà été traité.');
        }

        $appointment->token_used = true;
        $appointment->update(['status' => 'confirmed']);

        Mail::to($appointment->user->email)->send(new AppointmentStatusUpdated($appointment));

        return redirect()->route('appointments.calendar')->with('success', 'Rendez-vous confirmé avec succès.');
    }


    public function decline(Appointment $appointment, Request $request)
    {

        if ($request->token !== $appointment->confirmation_token || $appointment->token_used) {
            abort(403, 'Lien invalide');
        }

        if ($appointment->status !== 'pending') {
            return redirect()->route('appointments.overview')->with('error', 'Ce rendez-vous a déjà été traité.');
        }

        $appointment->token_used = true;


        // Mettre à jour le statut du rendez-vous
        $appointment->update(['status' => 'canceled']);

        // Envoyer un email au client pour l'informer
        Mail::to($appointment->user->email)->send(new AppointmentStatusUpdated($appointment));

        return redirect()->route('appointments.overview')->with('success', 'Rendez-vous refusé avec succès.');
    }




    public function SingleRDVRequest($serviceId)
    {
        return view('appointment.singleRDVRequest',[
            "serviceId" => $serviceId,
        ]);
    }



}
