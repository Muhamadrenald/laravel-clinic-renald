<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\DoctorScheduleController;
use App\Http\Controllers\Api\ServiceMedicinesController;
use App\Http\Controllers\Api\PatientScheduleController;
use App\Http\Controllers\Api\SatuSehatTokenController;
use App\Http\Controllers\Api\MedicalRecordController;
use App\Http\Controllers\Api\PaymentDetailController;

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

//login
Route::post('/login', [AuthController::class, 'login']);

//logout
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

//doctors
Route::apiResource('/api-doctors', DoctorController::class)->middleware('auth:sanctum');

//patients
Route::apiResource('/api-patients', PatientController::class)->middleware('auth:sanctum');

//doctor schedules
Route::apiResource('/api-doctor-schedules', DoctorScheduleController::class)->middleware('auth:sanctum');

//service medicines
Route::apiResource('/api-service-medicines', ServiceMedicinesController::class)->middleware('auth:sanctum');

//patient schedules
Route::apiResource('/api-patient-schedules', PatientScheduleController::class)->middleware('auth:sanctum');

//token
Route::get('/satusehat-token', [SatuSehatTokenController::class, 'token']);

//medical records
Route::apiResource('/api-medical-records', MedicalRecordController::class)->middleware('auth:sanctum');

//get service by patient schedule id
Route::get('/api-medical-records/services/{id}', [MedicalRecordController::class, 'getServicesByScheduleId'])->middleware('auth:sanctum');

//payment details
Route::apiResource('/api-payment-details', PaymentDetailController::class)->middleware('auth:sanctum');
