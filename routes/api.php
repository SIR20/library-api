<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LibrarianController;

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
    Route::post('/user/create', 'addUser')->middleware('auth:sanctum');

    Route::delete('user/delete','deleteUser')->middleware('auth:sanctum');

    Route::patch('/user/changePassword','changePassword')->middleware('auth:sanctum');
});

Route::prefix('librarian')->controller(LibrarianController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('book/create', 'addBook')->middleware('auth:sanctum');
    Route::post('user/unDelete', 'unDeleteUser')->middleware('auth:sanctum');
    Route::post('book/send','sendBook')->middleware('auth:sanctum');
    Route::post('book/receive','sendBook')->middleware('auth:sanctum');

    Route::delete('book/deleteBook', 'deleteBook')->middleware('auth:sanctum');
});

Route::get('book/books', [UserController::class, 'getBooks']);
