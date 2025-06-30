<?php

use Illuminate\Support\Facades\Route;

/* C06: Ruta Admin */
Route::get('/', function(){
    return "hola";
})->name('home');
