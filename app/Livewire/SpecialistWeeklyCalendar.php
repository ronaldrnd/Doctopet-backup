<?php

namespace App\Livewire;

use App\Mail\AppointmentCancelled;
use App\Mail\WelcomeActivation;
use App\Models\Animal;
use App\Models\Espece;
use App\Models\ExternalAppointment;
use App\Models\Race;
use App\Models\Service;
use App\Models\User;
use App\Services\SMSService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class SpecialistWeeklyCalendar extends Component
{
    public $currentWeekStart;
    public $appointments;
    public $externalClientName;
    public $externalAnimalName;
    public $externalSpecies;
    public $externalBreed;
    public $externalDate;
    public $externalStartTime;
    public $externalEndTime;

    public $speciesList = [];
    public $breedList = [];

    public $externalSpeciesId;
    public $externalBreedId;
    public $services;
    public $externalEmail;
    public $externalPhone;
    public $externalServiceId;





    public function mount()
    {
        // On démarre sur la semaine actuelle (lundi)
        $this->currentWeekStart = Carbon::now()->startOfWeek();
        $this->speciesList = Espece::with('races')->get();
        $this->loadAppointments();
        $this->services = Service::where("user_id",Auth::id())->get();

    }


    public function loadAppointments()
    {
        $userId = Auth::id();

        $this->appointments = Appointment::with(['animal', 'service'])
            ->whereBetween('date', [
                $this->currentWeekStart->format('Y-m-d'),
                $this->currentWeekStart->copy()->endOfWeek()->format('Y-m-d')
            ])
            ->where('assign_specialist_id', $userId)
            ->get();

        $externalAppointments = ExternalAppointment::where('user_id', $userId)
            ->whereBetween('date', [
                $this->currentWeekStart->format('Y-m-d'),
                $this->currentWeekStart->copy()->endOfWeek()->format('Y-m-d')
            ])
            ->get();

        $this->appointments = $this->appointments->merge($externalAppointments)->sortBy([
            ['date'],
            ['start_time']
        ])->groupBy('date')
            ->map(fn ($group) => $group->map(fn ($appt) => $appt->toArray()))
            ->toArray();


        //dd($this->appointments);

    }


    public function previousWeek()
    {
        $this->currentWeekStart->subWeek();
        $this->loadAppointments();
    }

    public function nextWeek()
    {
        $this->currentWeekStart->addWeek();
        $this->loadAppointments();
       // dd($this->appointments);

    }


    public function deleteExternalAppointment($appointmentId)
    {
        $appointment = ExternalAppointment::find($appointmentId);

        if ($appointment) {
            $appointment->delete();

            session()->flash('message', '🚀 Rendez-vous externe supprimé avec succès.');
            $this->loadAppointments();
        }
    }



    public function updatedExternalSpeciesId($value)
    {
        $this->breedList = $this->speciesList
            ->firstWhere('id', $value)
            ?->races ?? collect();
        $this->externalBreedId = null;
    }


    public function updateRaces($especeId)
    {
        $this->breedList = Race::where('espece_id', $especeId)->get();
    }


    public function addExternalAppointment()
    {
        $this->validate([
            'externalClientName' => 'required|string|max:255',
            'externalDate' => 'required|date',
            'externalStartTime' => 'required|date_format:H:i',
            'externalEndTime' => 'required|date_format:H:i|after:externalStartTime',
            'externalEmail' => 'nullable|email',
            'externalPhone' => 'nullable|string|max:20',
            'externalServiceId' => 'nullable|exists:services,id',
        ]);


        // Recherche ou création du User
        $user = User::firstOrCreate(
            ['name' => $this->externalClientName],
            [
                'email' => $this->externalEmail ?? 'temp_' . uniqid() . '@doctopet.local',
                'phone_number' => $this->externalPhone,
                'type' => 'C',
                'is_active' => 0,
                'password' => bcrypt(\Illuminate\Support\Str::random(12))
            ]
        );


        $animal = null;
        if ($this->externalAnimalName) {
            $animal = Animal::firstOrCreate([
                'nom' => $this->externalAnimalName,
                'espece_id' => $this->externalSpeciesId,
                'race_id' => $this->externalBreedId,
                'date_naissance' => Carbon::now(),
                'historique_medical' => '',
                'poids' => 0,
                'taille' => 0,
                'proprietaire_id' => $user->id,
            ]);
        }


        $selectedBreed = Race::find($this->externalBreedId);





        $ext = ExternalAppointment::create([
            'user_id' => Auth::id(),
            'client_name' => $this->externalClientName,
            'animal_name' => $this->externalAnimalName,
            'animal_species' => $selectedBreed?->espece?->libelle,
            'animal_breed' => $selectedBreed?->libelle,
            'date' => $this->externalDate,
            'service_id' => $this->externalServiceId,
            'start_time' => $this->externalStartTime,
            'end_time' => $this->externalEndTime,
        ]);


        $user->activation_token = \Illuminate\Support\Str::random(64);
        $user->save();



        Mail::to($user->email)->send(new WelcomeActivation($user->activation_token, $user->name));

        $this->reset([
            'externalClientName',
            'externalAnimalName',
            'externalSpecies',
            'externalBreed',
            'externalDate',
            'externalStartTime',
            'externalEndTime'
        ]);

        session()->flash('message', '✅ Rendez-vous professionnel ajouté avec succès.');
        $this->loadAppointments();
    }


    public function cancelAppointment($appointmentId, $reason)
    {
        $appointment = Appointment::with(['animal', 'service', 'user', 'assignedSpecialist'])->find($appointmentId);

        if ($appointment) {
            $owner = $appointment['user'];
            $specialist = $appointment['assignedSpecialist'];
            $animal = $appointment['animal'];
            $service = $appointment['service'];

            // ✅ Formater la date et l’heure
            $formattedDate = Carbon::parse($appointment['date'])->translatedFormat('l d/m/Y');
            $formattedStart = Carbon::parse($appointment['start_time'])->format('H:i');

            // ✅ Message SMS
            $message = "📢 Bonjour {$owner['name']}, votre rendez-vous avec {$specialist['name']} prévu le {$formattedDate} à {$formattedStart} pour {$animal['nom']} a été annulé.";
            if ($reason) {
                $message .= " Motif : {$reason}";
            }

            // ✅ Envoi d’un SMS via SMSService
            $smsService = new SMSService();
            $smsService->sendMessage($owner['phone_number'], $message);

            // ✅ Envoi de l’email d’annulation
            Mail::to($owner['email'])->send(new AppointmentCancelled($appointment, $reason));

            // ✅ Suppression du rendez-vous
            $appointment->delete();

            session()->flash('message', '🚀 Rendez-vous annulé et notification envoyée.');
            $this->loadAppointments();
        }
    }




    public function render()
    {
        return view('livewire.specialist-weekly-calendar');
    }
}
