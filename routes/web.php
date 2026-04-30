<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MemberStatusHistoryController;
use Illuminate\Support\Facades\Auth;



use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('can:view dashboard');
    Route::get('my-profile', [HomeController::class, 'myProfile'])->name('my-profile')->middleware('can:view profile');

    // Admin Only Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        // Member Management
        Route::get('/members', [MemberController::class, 'index'])->name('members.index')->middleware('can:view members');
        Route::post('/members', [MemberController::class, 'store'])->name('members.store')->middleware('can:manage members');
        Route::post('/members/import', [MemberController::class, 'import'])->name('members.import')->middleware('can:manage members');
        Route::get('/members/export-errors/{id}', [MemberController::class, 'downloadErrors'])->name('members.export-errors')->middleware('can:manage members');
        Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.destroy')->middleware('can:manage members');

        // Transaction Management
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index')->middleware('can:view transactions');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store')->middleware('can:manage transactions');

        // Approval & History
        Route::get('/approval-history', [MemberStatusHistoryController::class, 'index'])->name('approval.index')->middleware('can:view approvals');
        Route::post('/members/{id}/status', [MemberStatusHistoryController::class, 'updateStatus'])->name('members.update-status')->middleware('can:manage approvals');
    });
});


