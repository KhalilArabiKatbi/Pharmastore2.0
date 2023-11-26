<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MedicineController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Android
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Web
Route::post('/weblogin', [UserController::class, 'weblogin']);

// Both
Route::get('/logout', [UserController::class, 'logout']);

// Functions
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('medicines', MedicineController::class);
    Route::post('/place-order', [OrderController::class, 'placeOrder']);
    Route::get('/vieworders', [OrderController::class, 'viewOrders']);
    Route::get('/viewallorders', [MedicineController::class, 'viewAllOrders']);
    Route::put('/updateorderstatus/{orderId}/{status}', [OrderController::class, 'updateOrderStatus']);
    Route::put('/updatebillingstatus/{orderId}/{status}', [OrderController::class, 'updateBillingStatus']);
    Route::post('/medicines/{medicineId}/add-to-favorites', [MedicineController::class, 'addToFavorites']);
});
