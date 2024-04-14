<?php

use App\Http\Controllers\Products\CreateProductController;
use App\Http\Controllers\Products\DeleteProductController;
use App\Http\Controllers\Products\ListProductController;
use App\Http\Controllers\Products\ReadProductController;
use App\Http\Controllers\Products\UpdateProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('product')->group(function () {
    Route::post('/', CreateProductController::class);
    Route::get('/{id}', ReadProductController::class);
    Route::put('/{id}', UpdateProductController::class);
    Route::delete('/{id}', DeleteProductController::class);
    Route::get('/', ListProductController::class);
});




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
