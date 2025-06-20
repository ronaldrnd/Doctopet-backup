<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log as LaravelLog;

class SMSService
{

    public function sendMessage($number, $message)
    {
        $apiKey = config('bird.access_key');
        $workspaceId = config('bird.workspace_id');
        $smsChannelId = config('bird.channels.sms');

        $apiUrl = "https://api.bird.com/workspaces/$workspaceId/channels/$smsChannelId/messages";

        $formattedPhoneNumber = self::formatPhoneNumber($number);

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
                    "text" => $message
                ]
            ]
        ];


        $response = Http::withToken($apiKey)->post($apiUrl, $payload);

        $user = Auth::user();

        if ($response->failed()) {
            $errorMessage = $response->json();
            LaravelLog::error("❌ API BIRD - Échec d'envoi du SMS");
            Log::createLog($user->id, "API BIRD", "Échec d'envoi du SMS");
        } else {
            LaravelLog::info("✅ API BIRD - SMS envoyé avec succès");
            Log::createLog($user->id, "API BIRD", "SMS envoyé avec succès");
        }

    }


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
