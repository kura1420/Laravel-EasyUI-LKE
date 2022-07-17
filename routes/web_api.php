<?php

use App\Http\Controllers\Rest\AppController;
use App\Http\Controllers\Rest\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::post('/login', 'login');
        Route::post('/forgot', 'forgot');
    });
});

Route::middleware('authApp')->group(function() {

    require_once 'erp/apis/_core.php';
    require_once 'erp/apis/_employee.php';
    require_once 'erp/apis/_instansi.php';
    require_once 'erp/apis/_lke.php';

    Route::prefix('app')->group(function() {
        Route::controller(AppController::class)->group(function() {
            Route::post('/menu', 'menu');
        });
    });
});