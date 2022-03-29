<?php

use App\Http\Controllers\Admin\SenderController;
use App\Http\Controllers\Admin\TravelerController;
use App\Http\Controllers\Auth\CodeCheckController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Flight\FlightController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Request\RequestController;
use App\Http\Controllers\Request\PackageController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserImageController;
use Illuminate\Support\Facades\Route;

// Route group for guests only
Route::post('register', [RegisterController::class, 'register']);
Route::post('verification/verify/traveler/{user}', [VerificationController::class, 'verifyTraveler'])->name('verification.verifyT');
Route::post('verification/verify/sender/{user}', [VerificationController::class, 'verifySender'])->name('verification.verifyS');
Route::post('verification/resend', [VerificationController::class, 'resend']);
Route::post('login', [LoginController::class, 'login']);
Route::post('password/email', [ForgetPasswordController::class, 'sendResetLink']);
Route::post('password/code/check', [CodeCheckController::class, 'check']);

// admin Route group
Route::group(['middleware' => ['auth.guard:admin', 'protected']], function() {
    Route::post('/logout', [LogoutController::class, 'logout']);

    // flights
    Route::get('/admin/getFlights', [FlightController::class, 'index']);
    Route::get('/admin/filterFlights', [FlightController::class, 'applyFilters']);
    Route::delete('/admin/deleteFlight/{id}', [\App\Http\Controllers\Admin\FlightController::class, 'destroy']);

    // requests
    Route::get('/admin/getRequests', [RequestController::class, 'index']);
    Route::get('/admin/filterRequests', [RequestController::class, 'applyFilters']);
    Route::delete('/admin/deleteRequest/{id}', [\App\Http\Controllers\Admin\RequestController::class, 'destroy']);
    Route::post('/admin/changeStatus/{id}', [\App\Http\Controllers\Admin\RequestController::class, 'changeStatus']);

    // travelers
    Route::get('/admin/travelers', [TravelerController::class, 'index']);

    // senders
    Route::get('/admin/senders', [SenderController::class, 'index']);
});

// traveler Route group
Route::group(['middleware' => ['auth.guard:traveler', 'protected']], function() {
    Route::post('/traveler/updateProfileImage', [UserImageController::class, 'create']);
    Route::get('/traveler/getProfile', [UserController::class, 'getMyInfo']);

    // flights
    Route::get('/traveler/getFlights', [FlightController::class, 'getMyFlights']);
    Route::get('/traveler/getFlight/{id}', [FlightController::class, 'getFlight']);
    Route::post('/traveler/addFlight', [FlightController::class, 'create']);
    Route::patch('/traveler/updateFlight/{id}', [FlightController::class, 'update']);
    Route::delete('/traveler/deleteFlight/{id}', [FlightController::class, 'destroy']);

    // requests
    Route::get('traveler/requests/{id}', [RequestController::class, 'getMyFlightRequests']);
    Route::post('traveler/changeRequestStatus/{id}', [RequestController::class, 'changeRequestStatusTraveler']);
    Route::get('traveler/request/{id}', [RequestController::class, 'getRequestTraveler']);

    // notifications
    Route::get('traveler/notifications', [NotificationController::class, 'getNotifications']);
});

// sender Route group
Route::group(['middleware' => ['auth.guard:sender', 'protected']], function() {
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::post('/sender/updateProfileImage', [UserImageController::class, 'create']);
    Route::get('sender/getProfile', [UserController::class, 'getMyInfo']);

    // Requests
    Route::get('/sender/getRequest/{id}', [RequestController::class, 'getRequestSender']);
    Route::get('/sender/getRequests', [RequestController::class, 'getMyRequests']);
    Route::post('/sender/addRequest/{id}', [RequestController::class, 'create']);
    Route::delete('/sender/deleteRequest/{id}', [RequestController::class, 'destroy']);
    Route::post('/sender/changeRequestStatus/{id}', [RequestController::class, 'changeRequestStatusSender']);

    // packages
    Route::post('/sender/addPackage/{id}', [PackageController::class, 'create']);

    // flights
    Route::get('/sender/getFlights', [FlightController::class, 'index']);
    Route::get('/sender/filterFlights', [FlightController::class, 'applyFilters']);

    // notifications
    Route::get('sender/notifications', [NotificationController::class, 'getNotifications']);
});

// logout for sender and traveler
Route::group(['middleware' => ['auth.guard:sender', 'auth.guard:sender']], function() {
    Route::post('/logout', [LogoutController::class, 'logout']);
});
