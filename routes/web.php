<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

// Strona startowa (login) dla niezalogowanych
Route::get('/', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');

// Logowanie
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');

// Wylogowanie
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rejestracja
Route::get('/register', [AuthController::class, 'showRegister'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Wszystkie poniższe trasy wymagają zalogowania
Route::middleware('auth')->group(function () {
    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/produkty/create', [ProductController::class, 'create'])->name('produkty.create');
    Route::post('/produkty', [ProductController::class, 'store'])->name('produkty.store');

    Route::get('/produkty', [ProductController::class, 'showAll'])->name('produkty');

    Route::get('/raporty', [ProductController::class, 'raport'])->name('raporty');

    Route::get('/ustawienia', function () {
        return redirect()->route('welcome');
    })->name('ustawienia');
});