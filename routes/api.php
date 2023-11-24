<?php

use App\Http\Controllers\API\AUTH\AuthenticateController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', [AuthenticateController::class, 'login']);
    // Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthenticateController::class, 'logout']);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('categories', ProductController::class);
    // });
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
