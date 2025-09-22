<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\AuthenticationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register',[AuthenticationController::class,'signUp'])->name('register');
Route::post('/login',[AuthenticationController::class,'signIn'])->name('login');

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[AuthenticationController::class,'signOut'])->name('logout');
    Route::resource('leave', LeaveController::class);

});