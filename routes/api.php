<?php

use App\Http\Controllers\Products\CreateProductController;
use App\Http\Controllers\Products\DeleteProductController;
use App\Http\Controllers\Products\ListProductController;
use App\Http\Controllers\Products\ReadProductController;
use App\Http\Controllers\Products\UpdateProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('product')->name('product.')
    ->group(function () {
        Route::post('/', CreateProductController::class)->name('create');
        Route::get('/{id}', ReadProductController::class)->name('read');
        Route::put('/{id}', UpdateProductController::class)->name('update');
        Route::delete('/{id}', DeleteProductController::class)->name('delete');
        Route::get('/', ListProductController::class)->name('list');
    });



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
