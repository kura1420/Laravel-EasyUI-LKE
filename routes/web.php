<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('layouts.base');
});

Route::prefix('auth')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::get('/reset/{token}', 'reset');
    });
});

Route::middleware('authApp')->group(function() {

    require_once 'erp/pages/_core.php';
    require_once 'erp/pages/_instansi.php';
    require_once 'erp/pages/_lke.php';
    
});
