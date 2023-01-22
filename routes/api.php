<?php

use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\AppLoginController;
use App\Http\Controllers\Api\AssignmentController;
use App\Http\Controllers\Api\HomeworkController;
use App\Http\Controllers\Api\WorkdoneController;
use App\Http\Controllers\Api\CircularController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\HolidayController;
use App\Http\Controllers\Api\StudentTimetableController;
use App\Http\Controllers\Api\DocumentManagementController;
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
    Route::post('get-institution', 'getInstitutionfromUrl');
});

Route::controller(AssignmentController::class)->group(function (){
    Route::post('assignment', 'getAssignment');
    Route::post('storeAssignment', 'store');
});

Route::controller(HomeworkController::class)->group(function (){
    Route::post('homework', 'getHomework');
    Route::post('storeHomework', 'store');
});

Route::controller(WorkdoneController::class)->group(function (){
    Route::post('workdone', 'getWorkdone');
    Route::post('storeWorkdone', 'store');
});

Route::controller(AssignmentSubmissionController::class)->group(function (){

});

Route::controller(CircularController::class)->group(function (){
    Route::post('circular', 'getCircular');
    Route::post('storeCircular', 'store');
    Route::post('all-circular', 'getRecipientCircular');
});

Route::controller(EventController::class)->group(function (){
    Route::post('event', 'getEvent');
    Route::post('storeEvent', 'store');
});

Route::controller(HolidayController::class)->group(function (){
    Route::post('holiday', 'getEvent');
    Route::post('storeHoliday', 'store');
});

Route::controller(StudentTimetableController::class)->group(function (){
    Route::post('get-timetable', 'getTimetable');
});

Route::controller(DocumentManagementController::class)->group(function (){
    Route::post('get-document', 'getDocument');
});




