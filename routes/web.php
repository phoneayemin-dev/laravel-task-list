<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Authentication Routes
Route::prefix('auth')->group(function(){
    Route::get('/login', [AuthController::class, "getLogin"]);
    Route::post('/login', [AuthController::class, "postLogin"]);
    Route::get('/logout', [AuthController::class, "getLogout"]);
    
    // //Registration Routes
    Route::get('/register', [AuthController::class, "getRegister"]);
    Route::post('/register', [AuthController::class, "postRegister"]);
});



Route::get('task', [TaskController::class, "index"]);
Route::post('task', [ TaskController::class, "store"]);
Route::delete('task/{id}', [ TaskController::class, "destroy"]);