<?php

use Illuminate\Support\Facades\Route;

Route::get("/docs/guide/specialite",[\App\Http\Controllers\DocumentationController::class,'GuideSpecialite'])
    ->name("docs.guide_specialite");
