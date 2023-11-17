<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PassportAuthController;

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


Route::prefix('v1')->group(function(){
    Route::post('register', [PassportAuthController::class, 'register']);
    Route::post('login', [PassportAuthController::class, 'login']);
    
    Route::middleware('auth:api')->group(function(){
        Route::post('logout', [PassportAuthController::class, 'logout']);
        Route::post('refresh/token', [PassportAuthController::class, 'refresh']);
        Route::resource('customer', CustomerController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
        Route::resource('item', ItemController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
        Route::resource('invoice', InvoiceController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    });
});