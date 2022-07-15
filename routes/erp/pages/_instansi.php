<?php

use App\Http\Controllers\InstansiController;
use Illuminate\Support\Facades\Route;

Route::controller(InstansiController::class)->group(function () {
    Route::get('/satker', 'satker');
});