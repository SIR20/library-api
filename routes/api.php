<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ModerController;
use App\Http\Controllers\UserBookController;

Route::prefix('user')->controller(UserController::class)->group(function () {
    Route::post('create', 'create');
    Route::post('login', 'login');
    Route::post('book/addBook')->middleware('auth:sanctum');
    Route::delete('book/deleteBook')->middleware('auth:sanctum');

    Route::patch('rename', 'rename')->middleware('auth:sanctum');
    Route::patch('changeEmail', 'changeEmail')->middleware('auth:sanctum');
    Route::patch('changePassword', 'changePassword')->middleware('auth:sanctum');
});

Route::prefix('admin')->controller(AdminController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('/user/addUser', 'addUser');

    Route::delete('user/deleteUser','deleteUser');
    
    Route::patch('/user/changePassword','changePassword');
});

Route::prefix('moder')->controller(ModerController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('book/addBook', 'addBook')->middleware('auth:sanctum');
    Route::post('user/unDelete', 'unDeleteUser')->middleware('auth:sanctum');

    Route::delete('book/deleteBook', 'deleteBook')->middleware('auth:sanctum');
    Route::delete('user/delete', 'deleteUser')->middleware('auth:sanctum');
});

Route::prefix('book')->controller(Book::class)->group(function () {
    Route::post('addBook', 'addBook')->middleware('auth:sanctum');
    Route::post('deleteBook', 'deleteBook')->middleware('auth:sanctum');
});
