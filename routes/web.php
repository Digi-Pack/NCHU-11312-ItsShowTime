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


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/backend.php';

Route::middleware(['auth', 'allUser'])->get('admin', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::prefix('/')->group(function () {

    Route::get('/', [ItsshowtimeController::class, 'index'])->name('home');

    Route::get('/animate', [ItsshowtimeController::class, 'animate'])->name('animate');

    Route::get('/inquire', [ItsshowtimeController::class, 'inquire'])->name('inquirePage');
});


// Route::middleware(['auth'])->prefix('/')->group(function () {

//     Route::get('/myprofile', [ItsshowtimeController::class, 'myProfile'])->name('myprofile');

//     Route::put('/updateprofile', [UserController::class, 'updateProfile'])->name('updateprofile');

//     Route::get('/password', [ItsshowtimeController::class, 'password'])->name('password');

//     Route::get('/history', [ItsshowtimeController::class, 'history'])->name('history');
// });


// // 後台頁
// Route::get('/backend', function () {
//     return Inertia::render('backend/homePage');
// })->name('backend.home');