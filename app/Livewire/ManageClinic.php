<?php

namespace App\Livewire;

use App\Mail\ClinicInvitation;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Clinic;
use App\Models\User;
use App\Models\ClinicUser;
use App\Models\ClinicSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\ClinicJoinRequest;


class ManageClinic extends Component
{
    public $clinic;
    public $members;
    public $allUsers;
    public $selectedUserId;
    public $schedules = [];
    public $pendingRequests;
    public $isOwner;
    public $isMember;
    public $availableUsers;




    public function mount($clinicId)
    {
        $this->clinic = Clinic::with('users')->findOrFail($clinicId);
        $this->members = $this->clinic->users;
        $this->allUsers = User::where('id', '!=', Auth::id())->get();
        $this->loadSchedules();

        $this->isOwner = $this->clinic->owner_id === Auth::id();
        $this->isMember = $this->clinic->users->contains('id', Auth::id());

        $this->availableUsers = User::where("type","S")
            ->whereDoesntHave('clinics')
            ->where('id', '!=', Auth::id())
            ->get();
        $this->pendingRequests = ClinicJoinRequest::where('clinic_id', $this->clinic->id)->where('status', 'pending')->with('user')->get();
    }

    public function loadSchedules()
    {
        $userId = Auth::id();
        $schedules = ClinicSchedule::where('clinic_id', $this->clinic->id)
            ->where('user_id', $userId)
            ->get();

        foreach ($schedules as $schedule) {
            $this->schedules[$schedule->day_of_week][] = [
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
            ];
        }
    }

    public function isOwner()
    {
        return $this->clinic->owner_id === Auth::id();
    }


    public function inviteMember()
    {
        $userId = $this->selectedUserId;
        $user = User::findOrFail($userId);

        // Génération d’un token d’invitation
        $token = Str::uuid();

        $request = ClinicJoinRequest::create([
            'user_id' => $userId,
            'clinic_id' => $this->clinic->id,
            'status' => 'pending',
            'token' => $token,
        ]);

        Mail::to($user->email)->send(new ClinicInvitation($this->clinic, $request));

        session()->flash('message', 'Invitation envoyée à ' . $user->name);
    }


    public function acceptJoinRequest($requestId)
    {
        $request = ClinicJoinRequest::findOrFail($requestId);
        $request->update(['status' => 'accepted']);

        ClinicUser::create([
            'user_id' => $request->user_id,
            'clinic_id' => $request->clinic_id,
        ]);

        session()->flash('message', 'Utilisateur ajouté à la clinique.');
        $this->render(); // Refresh
    }

    public function refuseJoinRequest($requestId)
    {
        $request = ClinicJoinRequest::findOrFail($requestId);
        $request->update(['status' => 'refused']);

        session()->flash('message', 'Invitation refusée.');
        $this->render(); // Refresh
    }
    public function removeMember($userId)
    {
        if (!$this->isOwner()) {
            abort(403, 'Action non autorisée.');
        }

        $this->clinic->members()->detach($userId);
        $this->members = $this->clinic->fresh()->members;

        session()->flash('message', 'Membre retiré avec succès.');
    }

    public function leaveClinic()
    {
        $userId = Auth::id();
        $this->clinic->members()->detach($userId);

        session()->flash('message', 'Vous avez quitté la clinique.');
        return redirect()->route('dashboard');
    }

    public function toggleSlot($day, $startTime)
    {
        $userId = Auth::id();
        $existingSchedule = ClinicSchedule::where('clinic_id', $this->clinic->id)
            ->where('user_id', $userId)
            ->where('day_of_week', $day)
            ->where('start_time', $startTime)
            ->first();

        if ($existingSchedule) {
            $existingSchedule->delete();
        } else {
            $endTime = date('H:i:s', strtotime($startTime) + 1800); // Ajoute 30 minutes
            ClinicSchedule::create([
                'clinic_id' => $this->clinic->id,
                'user_id' => $userId,
                'day_of_week' => $day,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);
        }

        $this->loadSchedules();
    }

    public function render()
    {
        return view('livewire.manage-clinic');
    }
}
