<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);

   
    Route::post('login', [AuthController::class, 'apiLogin'])
        ->middleware('throttle:5,1'); // API login with rate limiting

   
    Route::middleware('auth:api')->group(function () {
        Route::post('logout',  [AuthController::class, 'apiLogout']);
        Route::post('refresh', [AuthController::class, 'apiRefresh']);
        Route::post('me',      [AuthController::class, 'apiMe']);
        Route::get('/tasks', [AuthController::class, 'TaskApiController']);
    });
});

Route::prefix('password')->group(function () {
    // future reset routes
});

Route::get('/ping', fn () => response()->json(['message' => 'API is working']));

Route::fallback(function () {
    return response()->json([
        'message' => 'Resource not found.',
        'code'    => 404,
    ], 404);
});

