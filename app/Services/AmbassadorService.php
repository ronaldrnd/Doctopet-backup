<?php

namespace App\Services;

use App\Models\AmbassadorAccessCode;
use App\Models\User;

class AmbassadorService
{
    public static function generateAccessCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 12));
        } while (AmbassadorAccessCode::where('code', $code)->exists());

        AmbassadorAccessCode::create(['code' => $code]);

        return $code;
    }

    public static function redeemAccessCode(string $code, User $user): bool
    {
        $accessCode = AmbassadorAccessCode::where('code', $code)->where('used', false)->first();

        if ($accessCode) {
            $user->update(['is_ambassador' => true, 'is_verified' => true]);
            $accessCode->update(['used' => true]);

            return true;
        }

        return false;
    }


    public static function applyReferralCode(string $referralCode, User $newUser): bool
    {
        $referrer = User::where('referral_code', $referralCode)->first();

        if (!$referrer) {
            return false;
        }

        // Déterminer le montant du vouch en fonction du type de parrain
        $voucherAmount = $referrer->is_ambassador ? 20 : 10;

        // Appliquer le bonus au parrainé
        $newUser->update(['vouch_amount' => $newUser->vouch_amount + $voucherAmount, 'vouch_receiver_id' => $referrer->id]);

        // Appliquer le bonus au parrain uniquement si ce n'est pas un ambassadeur
        if (!$referrer->is_ambassador) {
            $referrer->update(['vouch_amount' => $referrer->vouch_amount + 10]);
        }

        return true;
    }

}
