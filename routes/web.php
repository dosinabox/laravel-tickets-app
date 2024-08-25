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

    Route::get('/ui/visitors/{code}', [VisitorUIController::class, 'show'])->name('visitors.ui.show');
    Route::get('/ui/search', [VisitorUIController::class, 'search'])->name('visitors.ui.search');
    Route::get('/ui/manage', [VisitorUIController::class, 'manage'])->name('visitors.ui.manage');
});

Route::get('/visitors/{code}', [VisitorAPIController::class, 'show'])->name('visitors.show');
Route::get('/search/{query}', [VisitorAPIController::class, 'search'])->name('visitors.search');
Route::get('/visitors', [VisitorAPIController::class, 'index'])->name('visitors.index');
Route::post('/visitors', [VisitorAPIController::class, 'store'])->name('visitors.store');
Route::post('/visitors/{id}', [VisitorAPIController::class, 'update'])->name('visitors.update');
Route::delete('/visitors/{id}', [VisitorAPIController::class, 'delete'])->name('visitors.delete');

require __DIR__.'/auth.php';
