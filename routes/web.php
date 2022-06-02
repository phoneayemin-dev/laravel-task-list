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
Route::controller(AuthController::class)->prefix('auth')->group(function(){
    
    //Registration Routes
    Route::post('/register', "postRegister");
    Route::get('/register', "getRegister");

    //Login Routes
    Route::get('/login', "getLogin");
    Route::post('/login', "postLogin");
    Route::get('/logout', "getLogout");

    
});
Route::controller(AuthController::class)->group(function() {
    Route::get('forgot-password', 'getEmail');
    Route::post('forgot-password', 'postEmail');

    Route::get('reset-password/{token}', 'getResetPassword');
    Route::post('reset-password/{token}', 'postResetPassword');
    
});



Route::controller(TaskController::class)->group(function () {
    Route::get('task', 'index');
    Route::post('task', 'store');
    Route::delete('task/{id}', 'destroy');
});
