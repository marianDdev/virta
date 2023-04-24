<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(
    ['prefix' => '/companies'],
    function () {
        Route::get('/', [CompanyController::class, 'index']);
        Route::get('/{id}', [CompanyController::class, 'getOne']);
        Route::post('/', [CompanyController::class, 'create']);
        Route::patch('/{id}', [CompanyController::class, 'update']);
        Route::delete('/{id}', [CompanyController::class, 'delete']);
    }
);

Route::group(
    ['prefix' => '/stations'],
    function () {
        Route::get('/', [StationController::class, 'index']);
        Route::get('/{id}', [StationController::class, 'getOne']);
        Route::post('/', [StationController::class, 'create']);
        Route::patch('/{id}', [StationController::class, 'update']);
        Route::delete('/{id}', [StationController::class, 'delete']);
    }
);
