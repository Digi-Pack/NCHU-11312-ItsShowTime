<?php

use Inertia\Inertia;
use App\Mail\TestMail;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\ItsshowtimeController;


Route::middleware(['auth', 'allUser'])->get('dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::prefix('/')->group(function () {

    Route::get('/', [ItsshowtimeController::class, 'index'])->name('home');

    Route::get('/animate', [ItsshowtimeController::class, 'animate'])->name('animate');

    Route::get('/inquire', [ItsshowtimeController::class, 'inquire'])->name('inquirePage');
});

// , 'user.name'
Route::middleware(['auth'])->prefix('/')->group(function () {

    Route::get('/myprofile', [ItsshowtimeController::class, 'myProfile'])->name('myprofile');

    Route::put('/updateprofile', [UserController::class, 'updateProfile'])->name('updateprofile');

    Route::get('/password', [ItsshowtimeController::class, 'password'])->name('password');

    // Route::get('/history', [ItsshowtimeController::class, 'history'])->name('history');
   Route::get('/history', [ItsshowtimeController::class, 'history'])->name('history');


});





// 會員登入測試
// Route::get('/home', function () {
//     return Inertia::render('settings/Welcome');
// })->name('home');



// 後台頁
Route::get('/backend', function () {
    return Inertia::render('backend/homePage');
})->name('backend.home');




require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
// require __DIR__.'/frontend.php';
require __DIR__ . '/backend.php';



// 寄信測試
Route::get('/sendEmail', function () {
    $testData = [
        'name' => '測試成功',
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
