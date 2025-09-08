<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

Route::get('/produkty/create', [ProductController::class, 'create'])->name('produkty.create');
Route::post('/produkty', [ProductController::class, 'store'])->name('produkty.store');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/produkty', function () {
    return redirect()->route('home');
})->name('produkty');

Route::get('/raporty', function () {
    return redirect()->route('home');
})->name('raporty');

Route::get('/ustawienia', function () {
    return redirect()->route('home');
})->name('ustawienia');
