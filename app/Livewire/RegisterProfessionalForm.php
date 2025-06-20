<?php

namespace App\Livewire;

use App\Mail\OTPMail;
use App\Models\Specialite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class RegisterProfessionalForm extends Component
{
    public $currentStep = 1;

    // Informations personnelles
    public $firstName, $lastName, $email, $password, $password_confirmation;
    public $personalPhone, $personalStreet, $personalCity, $personalPostalCode;

    // Informations professionnelles
    public $siren, $professionalPhone, $professionalStreet, $professionalCity, $professionalPostalCode;
    public $selectedSpeciality, $specialities;

    // OTP
    public $otp;
    public $otpSent = false;
    public $generatedOtp;

    protected $listeners = [
        'addSpeciality' => 'handleAddSpeciality',
        'removeSpeciality' => 'handleRemoveSpeciality'
    ];

    public function mount()
    {
        App::setLocale('fr');
        $this->specialities = Specialite::all();
    }

    public function handleAddSpeciality($specialityId)
    {
        if (is_numeric($specialityId)) {
            $this->selectedSpeciality = (int) $specialityId; // Seule spécialité autorisée
        }
    }

    public function handleRemoveSpeciality()
    {
        $this->selectedSpeciality = null;
    }

    public function stepRules()
    {
        switch ($this->currentStep) {
            case 1:
                return [
                    'firstName' => 'required|string|max:255',
                    'lastName' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'personalPhone' => 'required|regex:/(0)[0-9]{9}/',
                    'personalStreet' => 'required|string|max:255',
                    'personalCity' => 'required|string|max:255',
                    'personalPostalCode' => 'required|string|max:10',
                    'password' => 'required|string|min:8|confirmed',
                ];
            case 2:
                return [
                    'selectedSpeciality' => 'required|integer',
                    'siren' => 'required|numeric|digits:9',
                    'professionalPhone' => 'required|regex:/(0)[0-9]{9}/',
                    'professionalStreet' => 'required|string|max:255',
                    'professionalCity' => 'required|string|max:255',
                    'professionalPostalCode' => 'required|string|max:10',
                ];
            case 3:
                return [
                    'otp' => 'required|numeric|digits:6',
                ];
            default:
                return [];
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function nextStep()
    {
        if ($this->currentStep < 3) {
            $this->validate($this->stepRules());
            $this->currentStep++;
        }

        if ($this->currentStep === 3 && !$this->otpSent) {
            $this->sendOtp();
        }
    }

    public function verifyOtp()
    {
        if ($this->otp == $this->generatedOtp) {
            $this->register();
        } else {
            session()->flash('error', 'Le code OTP est incorrect. Veuillez réessayer.');
        }
    }

    public function sendOtp()
    {
        $this->generatedOtp = rand(100000, 999999);
        Mail::to($this->email)->send(new OTPMail($this->generatedOtp));
        $this->otpSent = true;
    }

    public function register()
    {
        $this->personalAddress = "{$this->personalStreet}, {$this->personalPostalCode} {$this->personalCity}";
        $this->professionalAddress = "{$this->professionalStreet}, {$this->professionalPostalCode} {$this->professionalCity}";
        $defaultProfilePicture = 'profile_pictures/default_avatar.png';

        $user = User::create([
            'name' => "{$this->firstName} {$this->lastName}",
            'email' => $this->email,
            'phone_number' => $this->personalPhone,
            'address' => $this->personalAddress,
            'professional_address' => $this->professionalAddress,
            'professional_phone' => $this->professionalPhone,
            'siren' => $this->siren,
            'type' => 'S',
            'password' => Hash::make($this->password),
            'profile_picture' => $defaultProfilePicture,
            'referral_code' => Str::random(10),
            'free_trial_end' => Carbon::now()->addMonth(),
        ]);

        // Assigner la spécialité
        if ($this->selectedSpeciality) {
            $user->specialites()->attach($this->selectedSpeciality);
        }

        $user->updateCoordinatesFromAddress();

        session()->flash('success', 'Compte créé avec succès !');
        Auth::login($user);
        return redirect('/dashboard');
    }

    public function render()
    {
        return view('livewire.register-professional-form', [
            'vetSpecialities' => $this->specialities->filter(fn($s) => str_contains(strtolower($s->nom), 'vétérinaire')),
            'otherSpecialities' => $this->specialities->filter(fn($s) => !str_contains(strtolower($s->nom), 'vétérinaire')),
        ]);
    }
}
