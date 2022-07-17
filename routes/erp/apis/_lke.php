<?php

use App\Http\Controllers\Rest\LkeController;
use App\Http\Controllers\Rest\PredikatController;
use Illuminate\Support\Facades\Route;

Route::prefix('predikat')->group(function () {
    Route::controller(PredikatController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    
        Route::post('/', 'store');
        Route::post('/lists', 'lists');
        Route::post('/usulan', 'usulan');
        
        Route::delete('/{id}', 'destroy'); 
    });
});

Route::prefix('lke')->group(function () {
    Route::controller(LkeController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::get('/predikat/{id}', 'predikatList');
    
        Route::post('/', 'store');
        Route::post('/lists', 'lists');
        
        Route::delete('/{id}', 'destroy'); 
        Route::delete('/predikat/{id}', 'predikatDestroy');
    });
});