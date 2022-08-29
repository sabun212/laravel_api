<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\AUTH\AuthController;
use App\Models\Attedance;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('user', [UserController::class, 'index']);


//auth
Route::post('login', [AuthController::class, 'login']);
Route::post('registrasi', [AuthController::class, 'register']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//kegiatan
// Route::post('kegiatan', [AuthController::class, 'login']);

//activity
Route::resource('activity', ActivitiesController::class)->middleware('auth:sanctum');

//absen
Route::resource('absen', AttendanceController::class)->middleware('auth:sanctum');





