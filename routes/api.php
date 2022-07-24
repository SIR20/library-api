<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\LoginController;

Route::post('login', [LoginController::class, 'login']);
Route::post('create', [LoginController::class, 'create']);

Route::middleware('auth:sanctum')->prefix('user')->controller(UserController::class)->group(function () {
    Route::post('book/reservation', 'reservation');

    Route::delete('book/delete', 'canselReservation');
});

Route::middleware('auth:sanctum')->prefix('admin')->controller(AdminController::class)->group(function () {
    Route::post('/user/create', 'addUser');

    Route::delete('user/delete', 'deleteUser');

    Route::patch('/user/changePassword', 'changePassword');
});

Route::middleware('auth:sanctum')->prefix('librarian')->controller(LibrarianController::class)->group(function () {
    Route::post('book/create', 'addBook');
    Route::post('user/unDelete', 'unDeleteUser');
    Route::post('book/send', 'sendBook');
    Route::post('book/receive', 'receiveBook');

    Route::delete('book/deleteBook', 'deleteBook');
});


Route::prefix('book')->controller(BookController::class)->group(function () {
    Route::get('books', 'getBooks');
    Route::get('byAuthor', 'getBookByAuthor');
    Route::get('byGenre', 'getBookByGenre');
});
