<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
    //return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('accounts/create', [AccountController::class, 'create'])->name('accounts.create')->middleware(['auth', 'verified']);
//Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store')->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/accounts', AccountController::class,
        ['except' => ['edit', 'update', 'destroy']]);
    Route::resource('/transactions', TransactionController::class);
//    ['only' => ['show']]
});

require __DIR__ . '/auth.php';
