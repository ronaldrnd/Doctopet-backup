<?php

namespace App\Livewire;

use App\Mail\OTPMail;
use App\Models\Specialite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterForm extends Component
{
    public $currentStep = 1;
    public $userType = "client";
    public $gender;
    public $name;
    public $surname;
    public $birthdate;
    public $phone;
    public $email;
    public $password;
    public $password_confirmation;
    public $acceptTerms;
    public $otp;
    public $otpSent = false;
    public $generatedOtp;
    public $address_number;
    public $address_street;
    public $address_city;
    public $address_postal_code;


    // Spécialité et adresse pour professionnels
    public $specialities = []; // Tableau pour stocker plusieurs spécialités
    public $office_address;

    protected $rules = [
        'userType' => 'required',
        'gender' => 'required',
        'name' => 'required|string',
        'surname' => 'required|string',
        'birthdate' => 'required|date',
        'phone' => 'required|numeric',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:8',
        'acceptTerms' => 'accepted',
        'specialities' => 'required_if:userType,professional|array|min:1',
        'specialities.*' => 'exists:specialites,id',
        'office_address' => 'required_if:userType,professional|string|max:255',

        // Ajout validation adresse
        'address_number' => 'required|numeric',
        'address_street' => 'required|string|max:255',
        'address_city' => 'required|string|max:100',
        'address_postal_code' => 'required|numeric|digits:5',
    ];


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->specialitiesList = Specialite::all();
    }

    public function nextStep()
    {
        // Valider les champs pour l'étape actuelle
        $this->validate($this->stepRules());

        if ($this->currentStep === 2 && $this->userType === 'client') {
            // Passer directement à l'étape 5 pour les clients après coordonnées
            $this->currentStep = 5;
        } elseif ($this->currentStep < 5) {
            // Avancer à l'étape suivante
            $this->currentStep++;
        }

        if ($this->currentStep === 5 && !$this->otpSent) {
            $this->sendOtp();
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function stepRules()
    {
        switch ($this->currentStep) {
            case 0:
                return ['userType' => 'required'];
            case 1:
                return [
                    'gender' => 'required',
                    'name' => 'required|string',
                    'surname' => 'required|string',
                    'birthdate' => 'required|date',
                ];
            case 2:
                return [
                    'phone' => 'required|numeric',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|confirmed|min:8',
                ];
            case 3:
                return $this->userType === 'professional' ? [
                    'specialities' => 'required|array|min:1',
                    'specialities.*' => 'exists:specialites,id',
                    'office_address' => 'required|string|max:255',
                ] : [];
            case 4:
                return ['acceptTerms' => 'accepted'];
            case 5:
                return ['otp' => 'required|numeric|digits:6'];
            default:
                return [];
        }
    }

    public function verifyOtp()
    {
        if ($this->otp == $this->generatedOtp) {


            $fullAddress = "{$this->address_number} {$this->address_street}, {$this->address_city} {$this->address_postal_code}";
            $data = [
                'name' => "{$this->name} {$this->surname}",
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'phone_number' => $this->phone,
                'email_verified_at' => Carbon::now(),
                'gender' => $this->gender,
                'birthdate' => $this->birthdate,
                'type' => $this->userType == 'professional' ? 'S' : 'C',
                'address' => $fullAddress, // Stockage de l'adresse complète
                'profile_picture' => "profile_pictures/doctopet_logo_white_on_green.png"

            ];




            // Enregistrement des informations pour les professionnels
            if ($this->userType === 'professional') {
                $data['address'] = $this->office_address;
            }



            $user = User::create($data);

            // Attacher les spécialités
            if ($this->userType === 'professional') {
                $user->specialites()->attach($this->specialities);
            }

            Auth::login($user);

            session()->flash('success', 'Compte créé avec succès !');
            return redirect('/dashboard');
        } else {
            $this->addError('otp', 'Code OTP invalide.');
        }
    }

    public function sendOtp()
    {
        $this->generatedOtp = rand(100000, 999999);

        Mail::to($this->email)->send(new OTPMail($this->generatedOtp));

        $this->otpSent = true;
    }

    public function render()
    {
        return view('livewire.register-form', [
            'specialitiesList' => \App\Models\Specialite::all(),
        ]);
    }

    public function setUserType($type)
    {
        $this->userType = $type;
        $this->nextStep();
    }
}
