<?php

use App\Http\Controllers\LkeController;
use Illuminate\Support\Facades\Route;

Route::controller(LkeController::class)->group(function () {
    Route::get('/lke', 'index');

    Route::get('/predikat', 'predikat');
});