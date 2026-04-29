<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('my-profile', [HomeController::class, 'myProfile'])->name('my-profile');

    // Admin Only Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        // Route::get('/members', [AdminController::class, 'members'])->name('admin.members');
        // Route::get('/approvals', [AdminController::class, 'approvals'])->name('admin.approvals');
        // Member Management
        Route::get('/members', [MemberController::class, 'index'])->name('members.index');
        Route::post('/members', [MemberController::class, 'store'])->name('members.store');
        Route::post('/members/import', [MemberController::class, 'import'])->name('members.import');
        Route::get('/members/export-errors/{id}', [MemberController::class, 'downloadErrors'])->name('members.export-errors');
        Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');


        // Transaction Management
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    });
});
