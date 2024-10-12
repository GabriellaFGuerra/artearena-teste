<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\UserRole;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/bills', BillController::class);
});

require __DIR__ . '/auth.php';
