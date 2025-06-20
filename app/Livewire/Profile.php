<?php

namespace App\Livewire;

use App\Models\Animal;
use App\Models\Review;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Specialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\VerifyNewEmail;
use Illuminate\Support\Facades\Mail;


class Profile extends Component
{
    use WithFileUploads;

    public $user; // L'utilisateur affiché
    public $isOwnProfile = false; // Si l'utilisateur consulte son propre profil
    public $name;
    public $email;
    public $phone_number;
    public $birthdate;
    public $address;
    public $professional_address;
    public $professional_phone;
    public $gender;
    public $profile_picture;
    public $newProfilePicture;

    public $specialities = []; // Pour les spécialités
    public $allSpecialities; // Liste complète des spécialités
    public $services = [];
    public $animaux;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'phone_number' => 'nullable|string|max:20',
        'birthdate' => 'nullable|date',
        'address' => 'nullable|string|max:255',
        'gender' => 'required|in:M,F',
        'newProfilePicture' => 'nullable|image|max:2048', // Max 2MB
        'specialities' => 'array', // Validation pour les spécialités
    ];

    public function mount(User $user)
    {


        $this->user = $user;
        $this->isOwnProfile = $user->id == Auth::user()->id;
        $this->profile_picture = $user->profile_picture;

        // Préremplir les champs si c'est le profil de l'utilisateur connecté
        if ($this->isOwnProfile) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone_number = $user->phone_number;
            $this->birthdate = $user->birthdate;
            $this->address = $user->address;
            $this->gender = $user->gender;
            $this->specialities = $user->specialites->pluck('id')->toArray();
            $this->professional_address = $user->professional_address;
            $this->professional_phone = $user->professional_phone;
        }

        // Charger toutes les spécialités
        $this->allSpecialities = Specialite::all();
        $this->services = Service::where('user_id', $user->id)->get()->toArray();
        $this->animaux = Animal::where("proprietaire_id",$user->id)->get();

    }



    public function sendEmailVerification()
    {
        $token = Str::random(60);
        $this->user->update([
            'temporary_email' => $this->email,
            'email_verification_token' => $token,
        ]);


        // Envoi de l'email de vérification
        Mail::to($this->email)->send(new VerifyNewEmail($this->user, $token));

        session()->flash('success', 'Un email de vérification a été envoyé à votre nouvelle adresse.');
    }

    public function updateProfile()
    {
        // Si l'email a été modifié, ajouter la règle de validation pour vérifier l'unicité
        $rules = $this->rules;
        if ($this->email !== $this->user->email) {
            $rules['email'] = 'required|email|max:255|unique:users,email';
        } else {
            // Si l'email est identique, ne pas appliquer la validation d'unicité
            unset($rules['email']);
        }

        $this->validate($rules);


        if ($this->email !== $this->user->email) {
            $this->sendEmailVerification();
            return;
        }

        // détecter si l'adresse est différente
        $user = Auth::user();
        $addr = Auth::user()->address;
        if($addr != $this->address){
            $user->updateAddress($this->address);
        }
        // Mise à jour des informations utilisateur
        $this->user->update([
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'birthdate' => $this->birthdate,
            'address' => $this->address,
            'gender' => $this->gender,
            'professional_phone' => $this->professional_phone,
            'professional_address' => $this->professional_address,
        ]);

        // Mise à jour de l'image de profil
        if ($this->newProfilePicture) {
            $path = $this->newProfilePicture->store('profile_pictures', 'public');
            $this->user->update(['profile_picture' => $path]);
            $this->profile_picture = $path;
        }

        // Mise à jour des spécialités (uniquement pour les spécialistes de santé)
        if ($this->user->type === 'S') {
            $this->user->specialites()->sync($this->specialities);
        }


        $this->dispatch('closeEditMode');


        session()->flash('success', 'Profil mis à jour avec succès !');
    }


    public function formatDate($date) {
        return \Carbon\Carbon::parse($date)->format('d/m/Y');
    }


    public function render()
    {



        $reviews = Review::where('specialist_id', $this->user->id)
            ->where('status', 'accepted')
            ->paginate(8);


        return view('livewire.profile', [
            'user' => $this->user,
            'allSpecialities' => $this->allSpecialities,
            'reviews' => $reviews
        ]);
    }
}
