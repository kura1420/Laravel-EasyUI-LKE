<?php

use App\Http\Controllers\Rest\AppProfileController;
use App\Http\Controllers\Rest\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('app-profile')->group(function() {
    Route::controller(AppProfileController::class)->group(function() {
        Route::get('/', 'index');
        
        Route::post('/', 'store');
        Route::post('/reset-secret', 'reset_secret');
    });
});

Route::prefix('user')->group(function() {
    Route::controller(UserController::class)->group(function() {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');

        Route::post('/', 'store');
        Route::post('/lists', 'lists');
        
        Route::delete('/{id}', 'destroy'); 
    });
});