<?php

use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => \App\Http\Middleware\Localization::getLocale()
],
    function() {
        Route::get('/', [\App\Http\Controllers\IndexController::class, 'homePage']);
        Route::get('/policy', [\App\Http\Controllers\IndexController::class, 'policyPage'])->name('policy');
        Route::get('/rules', [\App\Http\Controllers\IndexController::class, 'rulesPage']);
        Route::post('/getLocation', [\App\Http\Controllers\GoogleController::class, 'getLocation']);

        Route::get('new_user/{link}', [\App\Http\Controllers\UserController::class, 'privacy']);
        Route::post('new_user/accept', [\App\Http\Controllers\UserController::class, 'accept'])->name('accept_policy');
        Route::resource('/review', \App\Http\Controllers\ReviewController::class);
//        Route::get('/setLocale/{lang}', [\App\Http\Controllers\setLocaleController::class, 'setLocale'])->name('setLocale');
        Auth::routes();

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('reg');
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

            Route::get('/register/step_2', [\App\Http\Controllers\FullRegisterController::class, 'step_2'])->name('step_2');
            Route::post('/register/step_2', [\App\Http\Controllers\UserController::class, 'Step2'])->name('step_2_save');
            Route::get('/register/step_3', [\App\Http\Controllers\FullRegisterController::class, 'step_3'])->name('step_3');
            Route::post('/register/step_3', [\App\Http\Controllers\UserController::class, 'Step3'])->name('step_3_save');
            Route::get('/register/step_4', [\App\Http\Controllers\FullRegisterController::class, 'step_4'])->name('step_4');
            Route::post('/register/step_4', [\App\Http\Controllers\UserController::class, 'Step4'])->name('step_4_save');
            Route::get('/register/step_5', [\App\Http\Controllers\FullRegisterController::class, 'step_5'])->name('step_5');
            Route::post('/register/step_5', [\App\Http\Controllers\UserController::class, 'Step5'])->name('step_5_save');

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
