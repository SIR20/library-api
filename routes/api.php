<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('user')->controller(UserController::class)->group(function () {
    Route::post('create', 'create');
    Route::post('login', 'login');
    Route::patch('rename','rename')->middleware('auth:sanctum');
});

// Route::prefix('book')->group(['middleware' => ['auth:sanctum']],function () {
//     Route::post('create', [BookController::class, 'create']);
// });