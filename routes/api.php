<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);


Route::prefix('task')->middleware(['auth:sanctum'])->group(function () {
    Route::post('create', [TaskController::class, 'create']);
    Route::post('update/{task_id}', [TaskController::class, 'update']);
    Route::post('delete', [TaskController::class, 'delete']);
    Route::get('list', [TaskController::class, 'list']);
    Route::get('single/{id}', [TaskController::class, 'get']);
    Route::get('count', [TaskController::class, 'count']);
    Route::get('latest', [TaskController::class, 'getLatest']);
    Route::get('list/assigned', [TaskController::class, 'assignedList']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
