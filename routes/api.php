<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScholarshipProgramController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\RequirementController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/register', [AuthController::class, 'apiRegister']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'apiLogout']);

// Scholarship Programs
Route::apiResource('scholarship-programs', ScholarshipProgramController::class);
Route::get('scholarship-programs/open', [ScholarshipProgramController::class, 'openPrograms']);
Route::patch('scholarship-programs/{id}/status', [ScholarshipProgramController::class, 'changeStatus']);

// Applicants
Route::apiResource('applicants', ApplicantController::class);
Route::get('applicants/{id}/applications', [ApplicantController::class, 'applications']);

// Applications
Route::apiResource('applications', ApplicationController::class);
Route::get('applications/status/{status}', [ApplicationController::class, 'byStatus']);
Route::get('applications/applicant/{id}', [ApplicationController::class, 'byApplicant']);
Route::get('applications/program/{id}', [ApplicationController::class, 'byProgram']);

// Update Application Status
Route::patch('applications/{id}/status', [ApplicationController::class, 'updateStatus']);

// Requirements
Route::apiResource('requirements', RequirementController::class);