<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function specialites()
    {
        return $this->belongsToMany(Specialite::class);
    }

    public function firstSpecialite()
    {
        return $this->belongsToMany(Specialite::class, 'specialite_user')
            ->orderBy('specialite_user.created_at', 'asc')
            ->first();
    }



    public function animaux()
    {
        return $this->hasMany(Animal::class, 'proprietaire_id');
    }



    public function services()
    {
        return $this->hasMany(Service::class, 'user_id');
    }

    public function estSpecialiste()
    {
        return $this->type === 'S';
    }


    public function warnings()
    {
        return $this->hasMany(UserWarning::class, 'user_target_id');
    }


    /**
     * Relation avec les rendez-vous où l'utilisateur est le propriétaire de l'animal.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    /**
     * Relation avec les rendez-vous où l'utilisateur est le spécialiste assigné.
     */
    public function assignedAppointments()
    {
        return $this->hasMany(Appointment::class, 'assign_specialist_id');
    }

    public function specialistAppointments()
    {
        return $this->hasMany(Appointment::class, 'user_id')
            ->where('assign_specialist_id', Auth::id())
            ->with(['animal', 'service', 'specializedService']);
    }



    public function externalAppointmentsForSpecialist()
    {
        return $this->hasMany(ExternalAppointment::class, 'client_id')
            ->where('user_id', Auth::id())
            ->orderBy('date', 'desc');
    }


    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function logStocks()
    {
        return $this->hasMany(LogStock::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function fournisseurs()
    {
        return $this->hasMany(Fournisseur::class);
    }


    public function serviceRequests()
    {
        return $this->hasMany(\App\Models\ServiceRequest::class);
    }


    protected static function boot()
    {
        parent::boot();

        // Générer un code de parrainage unique lors de la création de l'utilisateur
        static::creating(function ($user) {
            $user->referral_code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 10));
        });
    }

    public function vouchReceiver()
    {
        return $this->belongsTo(User::class, 'vouch_receiver_id');
    }

    public function isAmbassador()
    {
        return $this->is_ambassador;
    }

    public function isVerified()
    {
        return $this->is_verified;
    }

    public function hasReferralBonus()
    {
        return $this->vouch_amount > 0;
    }


    public function hasActiveSubscription()
    {
        return $this->is_subscribed && $this->next_billing_date >= now();
    }

    /**
     * Met à jour automatiquement les coordonnées GPS depuis l'adresse.
     */
    public function updateCoordinatesFromAddress()
    {

        if ($this->address) {
            $geoResponse = Http::withHeaders([
                'User-Agent' => 'DoctoPet/1.0 (contact@doctopet.com)',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $this->address,
                'format' => 'json',
                'limit' => 1,
            ]);
            if ($geoResponse->successful() && count($geoResponse->json()) > 0) {
                $geoData = $geoResponse->json()[0];
                $this->latitude = $geoData['lat'];
                $this->longitude = $geoData['lon'];
                $this->save();
            }
        }
    }

    /**
     * Met à jour l'adresse et récupère les nouvelles coordonnées.
     */
    public function updateAddress(string $newAddress)
    {
        $this->address = $newAddress;
        $this->updateCoordinatesFromAddress();
        $this->save();
    }


    public function reviews()
    {
        return $this->hasMany(Review::class, 'specialist_id');
    }


    public function acceptsAutoRDV()
    {
        return $this->accept_auto_rdv;
    }


    // Vérifie si l'utilisateur est en période d'essai
    public function hasActiveTrial()
    {
        return $this->free_trial_end && Carbon::now()->lt($this->free_trial_end);
    }


    public function clinics()
    {
        return $this->belongsToMany(Clinic::class);
    }

    public function ownedClinics()
    {
        return $this->hasMany(Clinic::class, 'owner_id');
    }

    public function clinicSchedules()
    {
        return $this->hasMany(ClinicSchedule::class);
    }

    public function clinicJoinRequests()
    {
        return $this->hasMany(ClinicJoinRequest::class);
    }



}
