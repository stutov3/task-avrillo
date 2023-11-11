<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
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

Route::get('projects/statistics', [ProjectController::class, 'projectStatistics']);
Route::apiResource('projects', ProjectController::class);

Route::apiResource('tasks', TaskController::class);
Route::post('tasks/{task}/assign/{assignedUser?}', [TaskController::class, 'assignTask'])->middleware('auth:api');
