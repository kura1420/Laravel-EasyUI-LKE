<?php

use App\Http\Controllers\Rest\LkeController;
use App\Http\Controllers\Rest\LkeIndikatorController;
use App\Http\Controllers\Rest\LkeIndikatorFormulaController;
use App\Http\Controllers\Rest\LkeIndikatorJawabanController;
use App\Http\Controllers\Rest\LkeIndikatorNilaiController;
use App\Http\Controllers\Rest\LkeJawabanController;
use App\Http\Controllers\Rest\LkePengusulanSatkerController;
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
        Route::post('/lists-total-indikator', 'listTotalIndikator');
        
        Route::delete('/{id}', 'destroy'); 
        Route::delete('/predikat/{id}', 'predikatDestroy');
    });
});

Route::prefix('lke-indikator')->group(function () {
    Route::controller(LkeIndikatorController::class)->group(function() {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    
        Route::post('/', 'store');
        Route::post('/lists', 'lists');
        Route::get('/parent/{id}', 'parent');
        
        Route::delete('/{id}', 'destroy'); 
    });
});

Route::prefix('lke-indikator-nilai')->group(function () {
    Route::controller(LkeIndikatorNilaiController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    
        Route::post('/', 'store');
        
        Route::delete('/{id}', 'destroy'); 
    });
});

Route::prefix('lke-indikator-formula')->group(function () {
    Route::controller(LkeIndikatorFormulaController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    
        Route::post('/', 'store');
        
        Route::delete('/{id}', 'destroy');        
    });
});

Route::prefix('lke-indikator-jawaban')->group(function () {
    Route::controller(LkeIndikatorJawabanController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    
        Route::post('/', 'store');
        
        Route::delete('/{id}', 'destroy');
    });
});

Route::prefix('lke-pengusulan')->group(function () {
    Route::controller(LkePengusulanSatkerController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::get('/list-pengisian/{id}', 'listPengisianLke');
    
        Route::post('/', 'store');
        
        Route::delete('/{id}', 'destroy');
    });
});

Route::prefix('lke-jawaban')->group(function () {
    Route::controller(LkeJawabanController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    
        Route::post('/', 'store');
    });
});