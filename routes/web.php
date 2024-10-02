<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Visitor\APIController as VisitorAPIController;
use App\Http\Controllers\Visitor\UIController as VisitorUIController;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return redirect()->route('visitors.ui.search');
});

Route::get('/dashboard', static function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/visitor/{code}', [VisitorUIController::class, 'show'])->name('visitors.ui.show');
    Route::get('/search', [VisitorUIController::class, 'search'])->name('visitors.ui.search');
    Route::get('/manage', [VisitorUIController::class, 'manage'])->name('visitors.ui.manage');
    Route::get('/import', [VisitorUIController::class, 'import'])->name('visitors.ui.import');
    Route::post('/import', [VisitorUIController::class, 'import'])->name('visitors.ui.import');
});

Route::prefix('api/v1')->group(function () {
    Route::get('/visitor/{code}', [VisitorAPIController::class, 'show'])->name('visitors.api.show');
    Route::get('/search/{query}', [VisitorAPIController::class, 'search'])->name('visitors.api.search');
    Route::get('/visitors', [VisitorAPIController::class, 'index'])->name('visitors.api.index');
    Route::post('/visitors', [VisitorAPIController::class, 'store'])->name('visitors.api.store');
    Route::post('/visitors/{id}', [VisitorAPIController::class, 'update'])->name('visitors.api.update');
    Route::delete('/visitors/{id}', [VisitorAPIController::class, 'delete'])->name('visitors.api.delete');
});

require __DIR__.'/auth.php';
