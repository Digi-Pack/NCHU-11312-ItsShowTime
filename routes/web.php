<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('frontend/homePage');
})->name('home.page');

Route::get('/backend', function () {
    return Inertia::render('backend/homePage');
})->name('backend.home.page');

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
// require __DIR__.'/frontend.php';
// require __DIR__.'/backend.php';
