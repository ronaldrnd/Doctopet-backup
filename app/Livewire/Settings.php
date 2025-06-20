<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Clinic;
use App\Models\ClinicJoinRequest;

class Settings extends Component
{
    public $acceptAutoRDV;
    public $userReferralCode;
    public $enteredReferralCode;
    public $referrerName;
    public $vouchAmount;

    public $acceptOnlineRDV;
    public $isAmbassador;


    // ➕ Champs pour création clinique
    public $newClinicName;
    public $newClinicOpeningHour = '08:00';
    public $newClinicClosingHour = '18:00';

    // 🔍 Champs pour recherche clinique
    public $searchClinic = '';
    public $searchResults = [];


    public $associatedClinics = [];


    public function mount()
    {
        $user = Auth::user();
        $this->isAmbassador = $user->is_ambassador;
        $this->acceptAutoRDV = $user->accept_auto_rdv;
        $this->userReferralCode = $user->referral_code;
        $this->acceptOnlineRDV = $user->accept_online_rdv;

        if ($user->vouch_receiver_id) {
            $referrer = User::find($user->vouch_receiver_id);
            if ($referrer) {
                $this->referrerName = $referrer->name;
                $this->vouchAmount = $user->vouch_amount;
            }
        }

        $this->associatedClinics = \App\Models\Clinic::where('owner_id', $user->id)
            ->orWhereHas('users', fn ($query) => $query->where('users.id', $user->id))
            ->get();

    }

    public function toggleAutoRDV()
    {
        Auth::user()->update([
            'accept_auto_rdv' => $this->acceptAutoRDV,
        ]);

        session()->flash('success', 'Préférences mises à jour avec succès.');
    }


    public function toggleOnlineRDV() {
        Auth::user()->update([
            'accept_online_rdv' => $this->acceptOnlineRDV,
        ]);

        session()->flash('success', 'Préférences mises à jour avec succès.');
    }

    public function applyReferralCode()
    {
        $user = Auth::user();

        if ($user->vouch_receiver_id) {
            session()->flash('error', 'Vous avez déjà utilisé un code de parrainage.');
            return;
        }

        // Vérifier si le code existe
        $referrer = User::where('referral_code', $this->enteredReferralCode)->first();

        if (!$referrer) {
            session()->flash('error', 'Code de parrainage invalide.');
            return;
        }

        // Vérifier si c'est un ambassadeur
        $isAmbassador = $referrer->type === 'AMBASSADEUR';
        // Appliquer la réduction
        $discount = $isAmbassador ? 20 : 10;
        $user->update([
            'vouch_receiver_id' => $referrer->id,
            'vouch_amount' => $discount
        ]);

        // Ajouter la récompense de 10€ au parrain si ce n'est pas un ambassadeur
        if (!$isAmbassador) {
            $referrer->update([
                'vouch_amount' => $referrer->vouch_amount + 10
            ]);
        }

        // Mettre à jour les informations affichées
        $this->referrerName = $referrer->name;
        $this->vouchAmount = $discount;

        session()->flash('success', "Code appliqué avec succès ! Réduction de {$discount}€ activée.");
    }


    public function createClinic()
    {
        $user = Auth::user();

        $clinic = Clinic::create([
            'name' => $this->newClinicName,
            'address' => $user->professional_address ?? "",
            'opening_time' => $this->newClinicOpeningHour,
            'closing_time' => $this->newClinicClosingHour,
            'owner_id' => $user->id,
        ]);

        session()->flash('success', "Clinique '{$clinic->name}' créée avec succès !");
        $this->reset(['newClinicName', 'newClinicOpeningHour', 'newClinicClosingHour']);
    }


    public function updatedSearchClinic()
    {
        $this->searchResults = Clinic::where('name', 'like', "%{$this->searchClinic}%")
            ->limit(20)
            ->get();
    }

    public function requestJoinClinic($clinicId)
    {
        $user = Auth::user();

        ClinicJoinRequest::firstOrCreate([
            'clinic_id' => $clinicId,
            'user_id' => $user->id,
        ], [
            'status' => 'pending'
        ]);

        session()->flash('success', 'Demande envoyée avec succès.');
    }

    public function render()
    {
        return view('livewire.settings');
    }
}
