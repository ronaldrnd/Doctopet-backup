<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;



Route::get("/rdv/manage",[\App\Http\Controllers\AppointmentController::class,'ManageSpecialist'])
    ->middleware(['auth', 'verified'])
    ->name('apointment.manager_specialist');



Route::get("/rdv/create/{id}",[\App\Http\Controllers\AppointmentController::class,'create'])
    ->middleware(['auth', 'verified'])
    ->name('appointment.create');


Route::get("/rdv/list",[\App\Http\Controllers\AppointmentController::class,'overview'])
    ->middleware(['auth', 'verified'])
    ->name('appointments.overview');


Route::get("/appointments",[\App\Http\Controllers\AppointmentController::class,'ManageClient'])
    ->middleware(['auth', 'verified'])
    ->name('appointments.index');


Route::get("/appointments/confirm",[\App\Http\Controllers\AppointmentController::class,'confirm'])
    ->middleware(['auth', 'verified'])
    ->name('appointments.confirm');


Route::post('/rdv/confirm', [\App\Http\Controllers\AppointmentController::class,'confirm'])
    ->name('rdv.confirm');



Route::middleware(['auth'])->group(function () {
    Route::get('/appointment/{appointment}/accept', [\App\Http\Controllers\AppointmentController::class, 'accept'])
        ->name('appointment.accept');

    Route::get('/appointment/{appointment}/decline', [\App\Http\Controllers\AppointmentController::class, 'decline'])
        ->name('appointment.decline');
});


Route::get('/appointments/{id}', [\App\Http\Controllers\AppointmentController::class, 'show'])->name('appointments.show');



Route::get('/rendez-vous/{id}', [\App\Http\Controllers\AppointmentController::class, 'showPatient'])->name('appointments.showPatient');



Route::get("/agenda/rdv",[\App\Http\Controllers\AppointmentController::class,'calendar'])
    ->middleware("auth")
    ->name('appointments.calendar');


Route::get('/service/{service}', [AppointmentController::class,'SingleRDVRequest'])->name('service.appointment');
