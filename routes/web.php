<?php

use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LenderBalanceTransactionController;
use App\Http\Controllers\LenderController;
use App\Http\Controllers\LoanProductController;
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
Route::get('/users/borrower/not-eligible/{id}', [UserController::class, 'notEligibleBorrower']);

//Users Lender
Route::get('/users/lender', [UserController::class, 'indexLender']);
Route::get('/users/lender/{id}', [UserController::class, 'showLender']);
Route::patch('/users/lender/eligible/{id}', [UserController::class, 'eligibleLender']);
Route::get('/users/lender/not-eligible/{id}', [UserController::class, 'notEligibleLender']);

//Borrower
Route::get('/borrower/regist', [BorrowerController::class, 'indexRegist']);
Route::post('/borrower/regist/store', [BorrowerController::class, 'store']);
Route::patch('/borrower/regist/update/{id}', [BorrowerController::class, 'update']);
Route::patch('/borrower/regist/bank/update/{id}', [BorrowerController::class, 'updateBank']);
Route::get('/borrower/profile/{id}', [BorrowerController::class, 'viewProfile']);
Route::get('/borrower/loan/create/{id}', [BorrowerController::class, 'createLoan']);
Route::post('/borrower/loan/store', [BorrowerController::class, 'storeLoan']);
Route::get('/borrower/loan/confirm/{id}', [BorrowerController::class, 'confirmLoan']);
Route::post('/borrower/loan/confirm-submit/{id}', [BorrowerController::class, 'confirmSubmitLoan']);
Route::get('/borrower/loan/history/{id}', [BorrowerController::class, 'historyLoan']);
Route::patch('/borrower/loan/approved/{id}', [BorrowerController::class, 'approvedLoan']);
Route::patch('/borrower/loan/rejected/{id}', [BorrowerController::class, 'rejectedLoan']);

//Lender
Route::get('/lender/regist', [LenderController::class, 'indexRegist']);
Route::post('/lender/regist/store', [LenderController::class, 'store']);
Route::patch('/lender/regist/update/{id}', [LenderController::class, 'update']);
Route::patch('/lender/regist/bank/update/{id}', [LenderController::class, 'updateBank']);
Route::get('/lender/profile/{id}', [LenderController::class, 'viewProfile']);
Route::get('/lender/balance/history/{id}', [LenderBalanceTransactionController::class, 'historyBalance']);
Route::post('/lender/balance/cashin/{id}', [LenderBalanceTransactionController::class, 'cashinBalance']);
Route::post('/lender/balance/cashout/{id}', [LenderBalanceTransactionController::class, 'cashoutBalance']);
Route::patch('/lender/balance/approved/{id}', [LenderBalanceTransactionController::class, 'approvedBalance']);
Route::patch('/lender/balance/rejected/{id}', [LenderBalanceTransactionController::class, 'rejectedBalance']);

//AJAX
Route::get('/loan-product-details/{id}', [LoanProductController::class, 'getProduct'])->name('getProduct');

