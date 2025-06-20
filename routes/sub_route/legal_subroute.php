<?php

use \Illuminate\Support\Facades\Route;

Route::get('/legal/cgu', function () {
    return view('legal.cgu');
})->name('legal.cgu');

Route::get('/legal/mentions-legales', function () {
    return view('legal.mentions-legales');
})->name('legal.mentions-legales');

Route::get('/legal/contrat-souscription', function () {
    return view('legal.contrat-souscription');
})->name('legal.contrat-souscription');
