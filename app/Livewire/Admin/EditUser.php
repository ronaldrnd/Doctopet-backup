<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Specialite;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Session;

class EditUser extends Component
{
    use WithFileUploads;

    public $userId;
    public $name;
    public $email;
    public $phone_number;
    public $gender = 'M';
    public $birthdate;
    public $type = 'C'; // Par défaut patient
    public $address;
    public $latitude;
    public $longitude;
    public $profile_picture;
    public $description;
    public $is_blocked = 0;
    public $is_verified = 0;
    public $is_subscribed = 0;
    public $password;

    // Infos PRO uniquement
    public $professional_address;
    public $professional_phone;
    public $siren;
    public $stripe_subscription_id;
    public $next_billing_date;

    // Gestion des spécialités
    public $specialities = [];
    public $selectedSpecialities = [];

    public $modeEdit = false;

    public function mount($userId = null)
    {
        $this->specialities = Specialite::all(); // Charger toutes les spécialités

        if ($userId) {
            $this->userId = $userId;
            $user = User::findOrFail($userId);

            // Charger les valeurs existantes
            $this->fill($user->only([
                'name', 'email', 'phone_number', 'gender', 'birthdate', 'type',
                'address', 'latitude', 'longitude', 'description', 'is_blocked',
                'is_verified', 'is_subscribed', 'professional_address',
                'professional_phone', 'siren', 'stripe_subscription_id', 'next_billing_date'
            ]));

            // Charger ses spécialités si c'est un pro
            if ($user->type === 'S') {
                $this->selectedSpecialities = $user->specialites()->pluck('specialites.id')->toArray();
            }

            $this->modeEdit = true;
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'required|in:M,F',
            'birthdate' => 'nullable|date',
            'type' => 'required|in:C,S',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
            'is_blocked' => 'boolean',
            'is_verified' => 'boolean',
            'is_subscribed' => 'boolean',
            'professional_address' => 'nullable|string|max:255',
            'professional_phone' => 'nullable|string|max:20',
            'siren' => 'nullable|string|max:255',
            'stripe_subscription_id' => 'nullable|string|max:255',
            'next_billing_date' => 'nullable|date',
        ]);

        // Gestion du mot de passe
        if (!empty($this->password)) {
            $validatedData['password'] = Hash::make($this->password);
        }

        // Gestion de l'image de profil
        if ($this->profile_picture) {
            $validatedData['profile_picture'] = $this->profile_picture->store('profile_pictures', 'public');
        }

        if ($this->modeEdit) {
            $user = User::findOrFail($this->userId);
            $user->update($validatedData);

            // Mise à jour des spécialités si c'est un pro
            if ($this->type === 'S') {
                $user->specialites()->sync($this->selectedSpecialities);
            }

            Session::flash('message', 'Utilisateur mis à jour avec succès.');
        } else {
            $user = User::create($validatedData);
            if ($this->type === 'S') {
                $user->specialites()->sync($this->selectedSpecialities);
            }
            Session::flash('message', 'Utilisateur créé avec succès.');
        }

    }

    public function delete($userId)
    {
        if ($userId && !User::find($userId)->hasRole == 'Administrateur') {
            User::findOrFail($userId)->delete();
            Session::flash('message', 'Utilisateur supprimé avec succès.');
            return redirect()->route('admin.users');
        }
    }

    public function render()
    {
        return view('livewire.admin.edit-user');
    }
}
