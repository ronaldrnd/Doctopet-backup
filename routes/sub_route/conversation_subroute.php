<?php
use Illuminate\Support\Facades\Route;


Route::get("/conversations/",[\App\Http\Controllers\ConversationController::class,'Overview'])
    ->middleware("auth")
    ->name('conversations.overview');

Route::get("/conversations/pro/",[\App\Http\Controllers\ConversationController::class,'ConversationProToClient'])
    ->middleware("auth")
    ->name('conversations.pro.to.client');
