<?php

use App\Http\Controllers\grupos\GruposController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('guardar-grupo',[GruposController::class,'guardarGrupo']);