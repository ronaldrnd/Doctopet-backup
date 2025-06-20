<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();





// Mis à jour des rendez vous
app()->singleton(\Illuminate\Support\Facades\Schedule::class, function ($app) {
    return tap(new \Illuminate\Support\Facades\Schedule(), function ($schedule) {
        $schedule->command('appointments:update-completed')->hourly();
    });
});


// Mis à jour des abonnements
app()->singleton(\Illuminate\Support\Facades\Schedule::class, function ($app) {
    return tap(new \Illuminate\Support\Facades\Schedule(), function ($schedule) {
        $schedule->command('subscriptions:update')->hourly();
    });
});


// lancement des SMS si rendez vous dans 1h
//app()->singleton(\Illuminate\Support\Facades\Schedule::class, function ($app) {
//    return tap(new \Illuminate\Support\Facades\Schedule(), function ($schedule) {
//        $schedule->command('sms:send-reminders')->everyMinute();
//    });
//});





