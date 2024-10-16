<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/bills');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/bills', BillController::class);
    Route::get('/search-users', [UserController::class, 'searchUsers'])->name('users.search');
    Route::get('/admin/reports/bills', [ReportController::class, 'generateReport'])->name('bills.report');
});

require __DIR__ . '/auth.php';
