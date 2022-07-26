<?php

use App\Http\Controllers\Api\BucApiController;
use App\Http\Controllers\Api\PayreqApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/bucs', BucApiController::class);
Route::post('/bucs/search', [BucApiController::class, 'search']);
Route::apiResource('/payreqs', PayreqApiController::class);
Route::post('/payreqs/search', [PayreqApiController::class, 'search']);