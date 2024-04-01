<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

Route::get('auth/google/url', [LoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [LoginController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::get('user/jobs', [JobController::class, 'getJobsByAuthUser']);
    Route::get('job/{id}', [JobController::class, 'getJobById']);
    Route::get('jobs', [JobController::class, 'getJobs']);
    Route::post('job/apply/{id}', [JobController::class, 'applyForJob']);
    Route::get('job/{id}/applications', [JobController::class, 'getJobApplicants']);
    Route::get('application/{id}', [JobController::class, 'getApplicationDetails']);
    Route::get('application/{id}/resume', [JobController::class, 'downloadResume']);
    Route::get('generate/comparison/{jobId}', [JobController::class, 'generateComparison']);
    Route::get('job/check/timer', [JobController::class, 'checkTimer']);
});
