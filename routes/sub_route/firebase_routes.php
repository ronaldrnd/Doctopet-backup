<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\FcmController;

Route::put('update-device-token', [FcmController::class, 'updateDeviceToken']);
Route::post('send-fcm-notification', [FcmController::class, 'sendFcmNotification']);
