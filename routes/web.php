<?php

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

Route::get('/', [\App\Http\Controllers\IndexController::class, 'homePage']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index']);
Route::get('/user/{id}', [\App\Http\Controllers\UserController::class, 'profile']);

Route::middleware(['auth'])->group(function (){
//    Route::get('/result', [\App\Http\Controllers\SearchController::class, 'index']);
    Route::post('/saveUser', [\App\Http\Controllers\UserController::class, 'saveUser'])->name('save-user');
    Route::post('/uploadAvatar', [\App\Http\Controllers\UserController::class, 'uploadAvatar'])->name('upload-avatar');

});
