<?php

use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/visitors', [VisitorController::class, 'index']);
Route::get('/visitors/{code}', [VisitorController::class, 'show']);
Route::post('/visitors', [VisitorController::class, 'store']);
