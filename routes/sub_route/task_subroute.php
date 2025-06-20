<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get("/task/overview",[TaskController::class,'overview'])
    ->middleware("auth")
    ->name('task.overview');

Route::get("/task/view/{id}",[TaskController::class,'view'])
    ->middleware("auth")
    ->name('task.view');
