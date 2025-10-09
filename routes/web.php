<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Leave Routes
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave');
    Route::get('/leave/create', [LeaveController::class, 'show'])->name('leave.create');
    Route::post('/leave', [LeaveController::class, 'store'])->name('leave.store');
    Route::get('/leave/{id}/edit', [LeaveController::class, 'edit'])->name('leave.edit');
    Route::patch('/leave', [LeaveController::class, 'update'])->name('leave.update');
    Route::delete('/leave', [LeaveController::class, 'destroy'])->name('leave.destroy');
});

require __DIR__.'/auth.php';
