<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->middleware('api');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});
Route::middleware('jwt.auth')->post('/sendForm', [\App\Http\Controllers\Api\FormController::class,'submitForm']);


Route::post('/payment', [PaymentController::class, 'payment'])->name('payment');
Route::post('/payment-verify', [PaymentController::class, 'paymentVerify'])->name('paymentVerify');
