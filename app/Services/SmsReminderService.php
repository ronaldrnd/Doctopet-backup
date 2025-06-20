<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log as LaravelLog;
use Illuminate\Support\Facades\Config;

class SmsReminderService
{
    public static function sendReminders()
    {
        // 🔹 Configuration API
        $apiKey = config('bird.access_key');
        $workspaceId = config('bird.workspace_id');
        $smsChannelId = config('bird.channels.sms');


        if (!$apiKey || !$workspaceId || !$smsChannelId) {
            LaravelLog::error("🔴 API BIRD - Clé API, workspace ou channel ID manquants.");
            return;
        }

        $apiUrl = "https://api.bird.com/workspaces/$workspaceId/channels/$smsChannelId/messages";

        // 🔹 Définition de la plage horaire pour les rappels
        $now = Carbon::now('Europe/Paris')->addDay();
        $oneHourLater = $now->copy()->addHour();

        // 🔹 Recherche des rendez-vous confirmés
        LaravelLog::info("📅 Recherche des rendez-vous confirmés pour l'envoi de SMS.");
        $appointments = Appointment::where('status', 'confirmed')
            ->whereDate('date', $oneHourLater->toDateString())
            ->with(['user', 'assignedSpecialist', 'service'])
            ->get();

        LaravelLog::info("📋 Nombre de rendez-vous trouvés : " . count($appointments));

        foreach ($appointments as $appointment) {
            $user = $appointment->user;
            $specialist = $appointment->assignedSpecialist;
            $service = $appointment->service;

            // 🔹 Vérifications obligatoires
            if (!$user || !$specialist || !$service) {
                LaravelLog::error("⚠️ API BIRD - RDV #{$appointment->id} : Informations manquantes.");
                Log::createLog($appointment->user_id, "API BIRD", "Informations manquantes pour le RDV #{$appointment->id}");
                continue;
            }

            if (empty($user->phone_number)) {
                LaravelLog::error("⚠️ API BIRD - RDV #{$appointment->id} : Numéro de téléphone manquant.");
                Log::createLog($appointment->user_id, "API BIRD", "Numéro de téléphone manquant pour l'utilisateur ID {$user->id}");
                continue;
            }

            if (empty($specialist->address)) {
                LaravelLog::error("⚠️ API BIRD - RDV #{$appointment->id} : Adresse du cabinet manquante.");
                Log::createLog($specialist->id, "API BIRD", "Adresse du cabinet manquante pour le spécialiste ID {$specialist->id}");
                continue;
            }

            // 🔹 Conversion du numéro au format international
            $formattedPhoneNumber = self::formatPhoneNumber($user->phone_number);
            LaravelLog::info("📞 Numéro formaté : {$formattedPhoneNumber}");

            // 🔹 Conversion et formatage de la date du RDV
            $appointmentDate = Carbon::parse($appointment->date)->locale('fr_FR')->timezone('Europe/Paris')->translatedFormat('l j F Y');
            $appointmentTime = Carbon::parse($appointment->start_time)->timezone('Europe/Paris')->format('H:i');

            // 🔹 Construction du message
            $messageText = "📅 Rappel Doctopet :\n".
                "🩺 RDV avec {$specialist->name} le {$appointmentDate} à {$appointmentTime}\n".
                "💼 Service : {$service->name}\n".
                "📍 Adresse : {$specialist->address}\n".
                "☎️ Contact : {$specialist->phone_number}";

            LaravelLog::info("📩 Message généré pour RDV #{$appointment->id} : {$messageText}");

            // 🔹 Création du payload conforme à Bird API
            $payload = [
                "receiver" => [
                    "contacts" => [
                        [
                            "identifierKey" => "phonenumber",
                            "identifierValue" => $formattedPhoneNumber
                        ]
                    ]
                ],
                "body" => [
                    "type" => "text",
                    "text" => [
                        "text" => $messageText
                    ]
                ]
            ];

            LaravelLog::debug("📡 Payload envoyé à l'API BIRD : ", $payload);

            // 🔹 Envoi de la requête API
            $response = Http::withToken($apiKey)->post($apiUrl, $payload);

            if ($response->failed()) {
                $errorMessage = $response->json();
                LaravelLog::error("❌ API BIRD - Échec d'envoi du SMS pour RDV #{$appointment->id} : ", $errorMessage);
                Log::createLog($user->id, "API BIRD", "Échec d'envoi du SMS pour RDV #{$appointment->id}");
            } else {
                LaravelLog::info("✅ API BIRD - SMS envoyé avec succès à {$formattedPhoneNumber} pour RDV #{$appointment->id}");
                Log::createLog($user->id, "API BIRD", "SMS envoyé avec succès au {$formattedPhoneNumber} pour RDV #{$appointment->id}");
            }
        }
    }

    /**
     * Convertit un numéro de téléphone français au format international
     *
     * @param string $phoneNumber
     * @return string
     */
    private static function formatPhoneNumber($phoneNumber)
    {
        // Supprime les espaces et caractères non numériques
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        if (preg_match('/^0[6-7]\d{8}$/', $phoneNumber)) {
            return '+33' . substr($phoneNumber, 1);
        }

        if (preg_match('/^\+33\d{9}$/', $phoneNumber)) {
            return $phoneNumber;
        }

        LaravelLog::error("⚠️ Numéro invalide détecté : {$phoneNumber}");
        return $phoneNumber;
    }
}
