<?php

use Illuminate\Support\Facades\Route;

Route::get("/stock/",[\App\Http\Controllers\StockManagerController::class,"index"])
    ->middleware("auth")
    ->name("stock.index");
