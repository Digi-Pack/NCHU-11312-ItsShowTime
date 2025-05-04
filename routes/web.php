<?php

use Inertia\Inertia;
use App\Mail\TestMail;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ItsshowtimeController;

Route::get('/animate', function () {
    return Inertia::render('settings/animate');
})->name('animate');

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('home');


// Route::get('/', function () {
//     return redirect('/home');
// });

// 首頁
// Route::get('/home', function () {
//     $products = Product::all();
//     return Inertia::render('frontend/homePage', [
//         'response' => $products,
//     ]);
// });

Route::get('/', [ItsshowtimeController::class, 'index'])->name('home');

// Route::get('/', function () {
//     $products = Product::all();
//     return Inertia::render('frontend/homePage', [
//         'response' => $products,
//     ]);
// })->name('home');



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
require __DIR__.'/backend.php';



// 寄信測試
Route::get('/sendEmail', function () {
    $testData = [
        'name'=>'測試成功',
    ];
    // dd($testData);
    Mail::to('babyangelababy0405@gmail.com')->send(new TestMail($testData));
});


// 測試頁testSwiper
Route::get('/test', function () {
    $products = Product::all();
    return Inertia::render('frontend/testSwiper', [
        'response' => $products,
    ]);
})->name('test');