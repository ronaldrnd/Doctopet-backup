<?php


namespace App\Livewire;

use Illuminate\Support\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\AskRdvShift;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;

class TransferRdv extends Component
{
    public $appointments;
    public $search = '';
    public $filteredProfessionals = [];
    public $selectedProfessional = null;
    public $selectedAppointment;
    public $requests;

    public function mount()
    {
        // Récupérer les rendez-vous dont le service appartient à l'utilisateur connecté
        $this->appointments = Appointment::whereHas('service', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->whereDate('date', '>=', Carbon::now()) // Filtre pour les rendez-vous futurs
            ->with(['service', 'user', 'animal'])
            ->get();

        // Préparer les professionnels à transférer (autres que l'utilisateur connecté)
        $this->professionals = User::where('type', 'S')->where('id', '!=', Auth::id())->get();

        // Récupérer les demandes de transfert reçues
        $this->requests = AskRdvShift::where('receiver_id', Auth::id())->where('status', 'pending')->get();
    }

    public function updatedSearch()
    {
        // Mise à jour dynamique des résultats de recherche
        if (!empty($this->search)) {
            $this->filteredProfessionals = User::where('type', 'S')
                ->where('id', '!=', Auth::id())
                ->where('name', 'like', '%' . $this->search . '%')
                ->get();
        } else {
            $this->filteredProfessionals = [];
        }
    }

    public function selectUser($userId)
    {
        $this->selectedProfessional = User::find($userId);
        $this->search = ''; // Réinitialisation de la recherche après sélection
        $this->filteredProfessionals = [];
    }

    public function sendTransferRequest()
    {
        // Vérification des données

        // Vérifier si selectedProfessional est un objet User, et récupérer son ID
        if ($this->selectedProfessional instanceof User) {
            $this->selectedProfessional = $this->selectedProfessional->id;
        }

        // Valider les données avec l'ID du professionnel
        $this->validate([
            'selectedAppointment' => 'required|exists:appointments,id',
            'selectedProfessional' => 'required|exists:users,id',
        ]);


        // Créer la demande de transfert avec l'ID correct
        AskRdvShift::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedProfessional, // Utilisation de l'ID du User
            'appointment_id' => $this->selectedAppointment,
            'status' => 'pending',
        ]);
        $this->dispatch('notification', '✅ Demande de transfert envoyée !', 'success');
        session()->flash('message', '✅ Demande de transfert envoyée.');
        $this->reset(['selectedAppointment', 'selectedProfessional', 'search', 'filteredProfessionals']);
        $this->mount();
    }


    public function acceptTransfer($requestId)
    {
        $request = AskRdvShift::findOrFail($requestId);
        $request->update([
            'status' => 'accepted',
            'decision_at' => now(),
        ]);

        $appointment = $request->appointment;
        $appointment->update(['assign_specialist_id' => Auth::id()]);

        session()->flash('message', '✅ Rendez-vous transféré avec succès.');
        $this->mount();
    }

    public function refuseTransfer($requestId)
    {
        $request = AskRdvShift::findOrFail($requestId);
        $request->update([
            'status' => 'refused',
            'decision_at' => now(),
        ]);

        session()->flash('message', '❌ Demande de transfert refusée.');
        $this->mount();
    }

    public function render()
    {
        return view('livewire.transfer-rdv', [
            'appointments' => $this->appointments,
            'requests' => $this->requests,
        ]);
    }
}
