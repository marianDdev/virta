<?php

use App\Http\Controllers\CompanyController;
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
        Route::get('/', [CompanyController::class, 'index'])->name('companies.index');
        Route::get('/{id}', [CompanyController::class, 'getOne'])->name('companies.getOne');
        Route::post('/', [CompanyController::class, 'create'])->name('companies.create');
        Route::patch('/{id}', [CompanyController::class, 'update'])->name('companies.update');
        Route::delete('/{id}', [CompanyController::class, 'delete'])->name('companies.delete');
    }
);
