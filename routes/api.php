<?php

use App\Http\Controllers\Auth\CodeCheckController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Route;

// Route group for guests only
Route::post('register/{type}', [RegisterController::class, 'register']);
Route::post('verification/verify/traveler/{user}', [VerificationController::class, 'verifyTraveler'])->name('verification.verifyT');
Route::post('verification/verify/sender/{user}', [VerificationController::class, 'verifySender'])->name('verification.verifyS');
Route::post('verification/resend/{type}', [VerificationController::class, 'resend']);
Route::post('login/{type}', [LoginController::class, 'login']);
Route::post('password/email/{type}',  [ForgetPasswordController::class, 'sendResetLink']);
Route::post('password/code/check', [CodeCheckController::class, 'check']);


Route::group(['middleware' => ['auth.guard:traveler', 'protected']], function() {
    Route::post('/logout', [LogoutController::class, 'logout']);
});

// user & admin logout
//Route::group(['middleware' => ['auth.guard:traveler', 'auth.guard:sender']], function () {
//    Route::post('/logout', [LogoutController::class, 'logout']);
//});
