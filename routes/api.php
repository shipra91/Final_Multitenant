<?php

use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\AppLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::apiResource('module', ModuleController::class);
// Route::apiResource('login', AppLoginController::class);

Route::controller(AppLoginController::class)->group(function (){
    Route::post('generate-otp', 'getOtp');
    Route::post('verify-otp', 'verifyOTP');
    Route::post('create-mPIN', 'createmPIN');
    Route::post('login', 'login');
    Route::post('refresh-login', 'refreshLogin');
    Route::post('logout', 'logout');
});


