<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Clinic;
use Illuminate\Support\Facades\Auth;

class ClinicProfile extends Component
{
    public  $clinic;
    public bool $isOwner;

    public $name;
    public $address;
    public $phone;
    public $opening_time;
    public $closing_time;
    public $isMemberClinic;

    protected $rules = [
        'name' => 'required|string|max:255',
        'address' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'opening_time' => 'nullable|string|max:10',
        'closing_time' => 'nullable|string|max:10',
    ];

    public function mount(Clinic $clinic)
    {
        $this->clinic = $clinic;
        $this->isOwner = Auth::id() === $clinic->owner_id;
        $this->name = $clinic->name;
        $this->address = $clinic->address;
        $this->phone = $clinic->phone ?? User::find($clinic->owner_id)->professional_phone;
        $this->opening_time = $clinic->opening_time;
        $this->closing_time = $clinic->closing_time;
        if($this->isOwner){
            $this->isMemberClinic = true;
        }
        else{
            $this->isMemberClinic = $this->clinic->users->contains('id', Auth::id());
        }
    }

    public function updateClinic()
    {
        $this->validate();

        $this->clinic->update([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time,
        ]);

        session()->flash('success', 'Clinique mise à jour avec succès 🎉');
        $this->dispatch('closeEditMode');
    }

    public function render()
    {
        return view('livewire.clinic-profile', [
            'clinic' => $this->clinic->load('users', 'owner'),
        ]);
    }
}
