<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('visitors.ui.list');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index');
    Route::get('/visitors/{code}', [VisitorController::class, 'show'])->name('visitors.show');
    Route::get('/search/{query}', [VisitorController::class, 'search'])->name('visitors.search');

    Route::get('/ui/visitors/{code}', [VisitorController::class, 'validate'])->name('visitors.ui.validate');
    Route::get('/ui/search', [VisitorController::class, 'list'])->name('visitors.ui.list');
    Route::get('/ui/all', [VisitorController::class, 'all'])->name('visitors.ui.all');
});

Route::post('/visitors', [VisitorController::class, 'store'])->name('visitors.store');
Route::post('/visitors/{id}', [VisitorController::class, 'update'])->name('visitors.update');
Route::delete('/visitors/{id}', [VisitorController::class, 'delete'])->name('visitors.delete');

require __DIR__.'/auth.php';
