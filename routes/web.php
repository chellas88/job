<?php

use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => \App\Http\Middleware\Localization::getLocale()
],
    function() {
        Route::get('/', [\App\Http\Controllers\IndexController::class, 'homePage']);
        Route::get('/policy', [\App\Http\Controllers\IndexController::class, 'policyPage']);
        Route::get('/rules', [\App\Http\Controllers\IndexController::class, 'rulesPage']);

        Route::get('new_user/{link}', [\App\Http\Controllers\UserController::class, 'privacy']);
        Route::post('new_user/accept', [\App\Http\Controllers\UserController::class, 'accept'])->name('accept_policy');
        Route::resource('/review', \App\Http\Controllers\ReviewController::class);
//        Route::get('/setLocale/{lang}', [\App\Http\Controllers\setLocaleController::class, 'setLocale'])->name('setLocale');
        Auth::routes();

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');
        Route::get('/profile/{id}', [\App\Http\Controllers\UserController::class, 'profile']);
        Route::get('/auth/google', [\App\Http\Controllers\GoogleController::class, 'googleRedirect'])->name('auth.google');
        Route::get('/auth/google/callback', [\App\Http\Controllers\GoogleController::class, 'loginWithGoogle']);

        Route::middleware(['auth'])->group(function () {
            Route::post('/saveUser', [\App\Http\Controllers\UserController::class, 'saveUser'])->name('save-user');
            Route::post('/uploadAvatar', [\App\Http\Controllers\UserController::class, 'uploadAvatar'])->name('upload-avatar');
            Route::post('/saveAddress', [\App\Http\Controllers\UserController::class, 'saveAddress'])->name('save-address');
            Route::post('/saveContacts', [\App\Http\Controllers\UserController::class, 'saveContacts'])->name('save-contacts');
            Route::resource('/languser', \App\Http\Controllers\LanguageUserController::class);
            Route::resource('/service', \App\Http\Controllers\ServiceController::class);

            Route::group([
                'middleware' => ['auth', 'admin'],
                'prefix' => 'admin'
            ], function () {
                Route::resource('/', \App\Http\Controllers\Admin\DashboardController::class);
                Route::resource('category', \App\Http\Controllers\Admin\CategoryController::class);
                Route::resource('subcategory', \App\Http\Controllers\Admin\SubcategoryController::class);
                Route::resource('country', \App\Http\Controllers\Admin\CountryController::class);
                Route::resource('language', \App\Http\Controllers\Admin\LanguageController::class);
                Route::resource('user', \App\Http\Controllers\Admin\UsersController::class);
            });
        });

    });
