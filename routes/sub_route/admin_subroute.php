<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/admin/panel/', function () {
    return view('admin.dashboard');
})
    ->middleware('role:Administrateur')
    ->name('admin.panel');



Route::get("/admin/panel/users_manage",[\App\Http\Controllers\AdminController::class,'ManageUsers'])
    ->middleware("role:Administrateur")
    ->name("admin.users");


Route::get("/admin/panel/logs_manage",[\App\Http\Controllers\AdminController::class,'ManageLogs'])
    ->middleware("role:Administrateur")
    ->name("admin.logs");

Route::get("/admin/panel/reports_manage",[\App\Http\Controllers\AdminController::class,'ManageReports'])
    ->middleware("role:Administrateur")
    ->name("admin.reports");


Route::get("/admin/panel/ambassadeurs_manage",[\App\Http\Controllers\AdminController::class,'ManageAmbassadeur'])
    ->middleware("role:Administrateur")
    ->name("admin.ambassadors");


Route::get("/admin/panel/veterinaires_ext_manage",[\App\Http\Controllers\AdminController::class,'ManageVeterinaryExt'])
    ->middleware("role:Administrateur")
    ->name("admin.veterinaires");


Route::get("/admin/panel/view/veterinaire_ext/{id}",[\App\Http\Controllers\AdminController::class,'ViewVeterinaryExt'])
    ->middleware("role:Administrateur")
    ->name("admin.view_veterinary");


Route::get("/admin/cabinets/",[\App\Http\Controllers\AdminController::class,'ManageCabinets'])
    ->middleware("role:Administrateur")
    ->name("admin.cabinets");

Route::get("/admin/cabinet/edit/{id}",[\App\Http\Controllers\AdminController::class,'EditCabinet'])
    ->middleware("role:Administrateur")
    ->name("admin.edit_cabinet");


Route::get('/admin/panel/review_avis', [\App\Http\Controllers\AdminController::class,'ReviewAvis'])->name('admin.reviews');


Route::get("/admin/users/edit/{id}",[\App\Http\Controllers\AdminController::class,'EditUser'])
    ->middleware("role:Administrateur")
    ->name("admin.edit_user");



Route::get("/admin/errors_prevent",[\App\Http\Controllers\AdminController::class,'ErrorFixPrevent'])
    ->middleware("role:Administrateur")
    ->name("admin.error_prevent");

Route::get("/admin/stripe_stats",[\App\Http\Controllers\AdminController::class,'StripeStats'])
    ->middleware("role:Administrateur")
    ->name("admin.stripe_stats");

Route::get("/admin/users/map",[\App\Http\Controllers\AdminController::class,'UserMap'])
    ->middleware("role:Administrateur")
    ->name("admin.user_map");
