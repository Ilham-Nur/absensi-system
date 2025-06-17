<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaktuController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.show');

    // user
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/list', [UserController::class, 'list'])->name('user.list');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
        Route::post('/reset-password/{id}', [UserController::class, 'resetPassword'])->name('user.resetPassword');
    });

    // role
    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/list', [RoleController::class, 'list'])->name('roles.list');
        Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    //waktu
    Route::prefix('waktu')->middleware(['auth'])->group(function () {
        Route::get('/', [WaktuController::class, 'index'])->name('waktu.index');
        Route::post('/store', [WaktuController::class, 'store'])->name('waktu.store');
        Route::get('/edit/{id}', [WaktuController::class, 'edit'])->name('waktu.edit');
        Route::post('/update/{id}', [WaktuController::class, 'update'])->name('waktu.update');
        Route::delete('/delete/{id}', [WaktuController::class, 'destroy'])->name('waktu.delete');
        Route::get('/list', [WaktuController::class, 'list'])->name('waktu.list');
    });

});

//scanner
Route::get('/scanner', [ScannerController::class, 'index'])->name('scanner.index');
Route::post('/scanner/scan', [ScannerController::class, 'scan'])->name('scanner.scan');
