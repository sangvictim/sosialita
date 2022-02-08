<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
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

/**
 * Route ini untuk landing page
 */
Route::domain('localhost')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

/**
 * Route ini untuk client area
 */
Route::domain('client.localhost.com')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('auth/{provider}', [LoginController::class,'redirectToProvider'])->name('authSocials');

Route::get('auth/{provider}/callback',[LoginController::class,'handleProviderCallback']);
