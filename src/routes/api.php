<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReminderController;
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

Route::prefix('session')->group(function () {
    Route::post('/',[AuthController::class,'login']);
    Route::put('/',[AuthController::class,'refresh_token']);
});

Route::resource('reminders', ReminderController::class)->middleware('auth:api');