<?php

use App\Http\Controllers\Auth\CodeCheckController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Sender\PackageController;
use App\Http\Controllers\Sender\RequestController;
use App\Http\Controllers\Traveler\FlightController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserImageController;
use Illuminate\Support\Facades\Route;

// Route group for guests only
Route::post('register/{type}', [RegisterController::class, 'register']);
Route::post('verification/verify/traveler/{user}', [VerificationController::class, 'verifyTraveler'])->name('verification.verifyT');
Route::post('verification/verify/sender/{user}', [VerificationController::class, 'verifySender'])->name('verification.verifyS');
Route::post('verification/resend/{type}', [VerificationController::class, 'resend']);
Route::post('login/{type}', [LoginController::class, 'login']);
Route::post('password/email/{type}',  [ForgetPasswordController::class, 'sendResetLink']);
Route::post('password/code/check/{type}', [CodeCheckController::class, 'check']);


// traveler Route group
Route::group(['middleware' => ['auth.guard:traveler', 'protected']], function() {
    Route::post('/updateProfileImage/traveler', [UserImageController::class, 'create']);
    Route::get('/getProfile/traveler', [UserController::class, 'getMyInfo']);

    // flights
    Route::get('/traveler/getFlights', [FlightController::class, 'getMyFlights']);
    Route::post('/traveler/addFlight', [FlightController::class, 'create']);
    Route::patch('/traveler/updateFlight/{id}', [FlightController::class, 'update']);
    Route::delete('/traveler/deleteFlight/{id}', [FlightController::class, 'destroy']);

    // requests
    Route::get('traveler/requests/{id}', [\App\Http\Controllers\Traveler\RequestController::class, 'getMyFlightRequests']);
    Route::post('traveler/changeRequestStatus/{id}', [\App\Http\Controllers\Traveler\RequestController::class, 'changeRequestStatus']);
    Route::get('traveler/request/{id}', [\App\Http\Controllers\Traveler\RequestController::class, 'getRequest']);
});

// sender Route group
Route::group(['middleware' => ['auth.guard:sender', 'protected']], function() {
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::post('/updateProfileImage/sender', [UserImageController::class, 'create']);
    Route::get('/getProfile/sender', [UserController::class, 'getMyInfo']);

    // Requests
    Route::get('/sender/getRequest/{id}', [RequestController::class, 'getRequest']);
    Route::get('/sender/getRequests', [RequestController::class, 'getMyRequests']);
    Route::post('/sender/addRequest/{id}', [RequestController::class, 'create']);
    Route::delete('/sender/deleteRequest/{id}', [RequestController::class, 'destroy']);

    // packages
    Route::post('/sender/addPackage/{id}', [PackageController::class, 'create']);

    // flights
    Route::get('/sender/getFlights', [FlightController::class, 'index']);
});

// logout for sender and traveler
Route::group(['middleware' => ['auth.guard:sender', 'auth.guard:sender']], function() {
    Route::post('/logout', [LogoutController::class, 'logout']);
});
