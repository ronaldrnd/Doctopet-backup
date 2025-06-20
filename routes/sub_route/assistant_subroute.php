<?php

use Illuminate\Support\Facades\Route;


Route::get("/assistant",[\App\Http\Controllers\AssistantController::class,'index'])
    ->name('assistant');
