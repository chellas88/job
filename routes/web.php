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
Route::group([
    'prefix' => \App\Http\Middleware\Localization::getLocale()
],
    function() {
        Route::get('/', [\App\Http\Controllers\IndexController::class, 'homePage']);
//        Route::get('/setLocale/{lang}', [\App\Http\Controllers\setLocaleController::class, 'setLocale'])->name('setLocale');
        Auth::routes();

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index']);
        Route::get('/profile/{id}', [\App\Http\Controllers\UserController::class, 'profile']);
        Route::get('/auth/google', [\App\Http\Controllers\GoogleController::class, 'googleRedirect'])->name('auth.google');
        Route::get('/auth/google/callback', [\App\Http\Controllers\GoogleController::class, 'loginWithGoogle']);

        Route::middleware(['auth'])->group(function () {
            Route::post('/saveUser', [\App\Http\Controllers\UserController::class, 'saveUser'])->name('save-user');
            Route::post('/uploadAvatar', [\App\Http\Controllers\UserController::class, 'uploadAvatar'])->name('upload-avatar');
            Route::post('/saveAddress', [\App\Http\Controllers\UserController::class, 'saveAddress']);
            Route::resource('/languser', \App\Http\Controllers\LanguageUserController::class);


            Route::group([
                'middleware' => ['auth', 'admin'],
                'prefix' => 'admin'
            ], function () {
                Route::resource('/', \App\Http\Controllers\Admin\AdminController::class);
                Route::resource('category', \App\Http\Controllers\Admin\CategoryController::class);
                Route::resource('subcategory', \App\Http\Controllers\Admin\SubcategoryController::class);
            });
        });

    });
