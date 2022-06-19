<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\Api\MiniwalletController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return response()->json([
            'message' => 'Welcome to the miniwallet API!',
            'status' => 'success',
            'version' => 'v1',
        ]);
    });

    Route::controller(MiniwalletController::class)->group(function () {
        Route::post('/init', 'init');
    });

    Route::middleware('auth.token')->group(function () {
        Route::controller(MiniwalletController::class)->group(function () {
            Route::post('/wallet', 'enableWallet');
            Route::get('/wallet', 'getWallet');
        });
    });
});
