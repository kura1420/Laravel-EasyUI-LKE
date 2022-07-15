<?php

use App\Http\Controllers\Rest\SatkerController;
use Illuminate\Support\Facades\Route;

Route::prefix('satker')->group(function () {
    Route::controller(SatkerController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    
        Route::post('/', 'store');
        Route::post('/lists', 'lists');
        Route::post('/provinsi', 'provinsi');
        Route::post('/kota', 'kota');
        
        Route::delete('/{id}', 'destroy'); 
    });
});