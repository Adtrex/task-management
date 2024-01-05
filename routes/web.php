<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/{any}', function () {
//     return view('welcome');
// })->where('any', '.*');



Route::prefix('dashboard')->group(function () {
    Route::get('{view}', [DashboardController::class, 'view'])->where('view', '.*');
});

Route::get('{any}', [AuthController::class, 'auth'])->where('any', '.*');




