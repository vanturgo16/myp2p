<?php

use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [LoginController::class, 'login']);
Route::post('/postLogin', [LoginController::class, 'postLogin']);
Route::get('/logout', [LoginController::class, 'logout']);

//Users Internal
Route::get('/users/internal', [UserController::class, 'indexInternal']);
Route::post('/users/internal/store', [UserController::class, 'store']);
Route::put('/users/internal/update/{id}', [UserController::class, 'update']);
Route::delete('/users/internal/delete/{id}', [UserController::class, 'destroy']);
Route::patch('/users/internal/active/{id}', [UserController::class, 'active']);

//Users Borrower
Route::get('/users/borrower', [UserController::class, 'indexBorrower']);
Route::get('/users/borrower/{id}', [UserController::class, 'showBorrower']);
Route::patch('/users/borrower/eligible/{id}', [UserController::class, 'eligibleBorrower']);

//Borrower
Route::get('/borrower/regist', [BorrowerController::class, 'indexRegist']);
Route::post('/borrower/regist/store', [BorrowerController::class, 'store']);
Route::patch('/borrower/regist/update/{id}', [BorrowerController::class, 'update']);
Route::patch('/borrower/regist/bank/update/{id}', [BorrowerController::class, 'updateBank']);
Route::get('/borrower/profile/{id}', [BorrowerController::class, 'viewProfile']);
Route::get('/borrower/loan/create/{id}', [BorrowerController::class, 'createLoan']);
Route::post('/borrower/loan/store', [BorrowerController::class, 'storeLoan']);
Route::get('/borrower/loan/confirm/{id}', [BorrowerController::class, 'confirmLoan']);

