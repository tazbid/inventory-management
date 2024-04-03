<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryDetailsController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [LoginController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);

    //prefix for inventory
    Route::prefix('inventory')->group(function () {
        Route::get('/', [InventoryController::class, 'get']);
        Route::get('/{inventoryId}', [InventoryController::class, 'getById']);
        Route::post('/', [InventoryController::class, 'create']);
        Route::put('/{inventoryId}', [InventoryController::class, 'update']);
        Route::delete('/{inventoryId}', [InventoryController::class, 'delete']);

        Route::prefix('{inventoryId}')->group(function () {
        //prefix for inventory details
            Route::prefix('details')->group(function () {
                Route::get('/', [InventoryDetailsController::class, 'get']);
                Route::get('/{inventoryDetailsId}', [InventoryDetailsController::class, 'getById']);
                Route::post('/', [InventoryDetailsController::class, 'create']);
                Route::put('/{inventoryDetailsId}', [InventoryDetailsController::class, 'update']);
                Route::delete('/{inventoryDetailsId}', [InventoryDetailsController::class, 'delete']);
            });
        });
    });
});
