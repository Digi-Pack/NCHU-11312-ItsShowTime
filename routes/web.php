<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Product;



Route::get('/', function () {
    return redirect('/home');
});

// 首頁
Route::get('/home', function () {
    $products = Product::all();
    return Inertia::render('frontend/homePage', [
        'response' => $products,
    ]);
});

// 詢價頁
Route::get('/inquirePage', function () {
    return Inertia::render('frontend/inquirePage');
})->name('inquire');

// 後台頁
Route::get('/backend', function () {
    return Inertia::render('backend/homePage');
})->name('backend.home');

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



// 找單一商品詳細資料
Route::get('/more/products/{id}', function ($id) {
    $product = Product::find($id);
    
    if (!$product) {
        abort(404, 'Product Not Found');
    }
    
    return response()->json($product);
});

// 購物車樣式選擇彈窗路徑
Route::get('/shoppingcart', function () {
    return Inertia::render('ShoppingCart');
})->name('shoppingcart.page');