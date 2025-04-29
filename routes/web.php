<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Product;
use App\Http\Controllers\Frontend\ItsshowtimeController;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


// Route::get('/', function () {
//     return redirect('/home');
// });

// 首頁
Route::get('/home', function () {
    $products = Product::all();
    return Inertia::render('frontend/homePage', [
        'response' => $products,
    ]);
});


// 詢價頁
// Route::get('/inquire', function () {
//     return Inertia::render('frontend/inquirePage');
// })->name('inquire');


Route::get('/inquire', [ItsshowtimeController::class, 'inquire'])->name('inquirePage');


// 後台頁
Route::get('/backend', function () {
    return Inertia::render('backend/homePage');
})->name('backend.home');



Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
// require __DIR__.'/frontend.php';
// require __DIR__.'/backend.php';