<?php

use App\Http\Controllers\StockPredictionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
|
| Here is where the public API routes for the Stock Predictor API.
|
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/stockpredictions', [StockPredictionController::class, 'index']);
Route::get('/stockpredictions/{ticker_symbol}', [StockPredictionController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Protected API Routes
|--------------------------------------------------------------------------
|
| Here is where the protected API routes for the Stock Predictor API.
|
*/
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/stockpredictions', [StockPredictionController::class, 'store']);
    Route::patch('/stockpredictions/{ticker_symbol}', [StockPredictionController::class, 'update']);
    Route::delete('/stockpredictions/{ticker_symbol}', [StockPredictionController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});