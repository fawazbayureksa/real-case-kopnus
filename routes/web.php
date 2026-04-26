<?php

use App\Http\Controllers\HomeController;
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
    });
});


