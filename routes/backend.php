<?php

use App\Models\Size;
use App\Models\Type;
use Inertia\Inertia;
use App\Models\Color;
use App\Models\Image;
use App\Mail\TestMail;
use App\Models\Banner;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\OrderList;
use App\Models\ProductsInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\InquiryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductOptionController;

// Banner 相關操作
Route::middleware(['auth', 'allUser'])->prefix('admin/banner')->group(function () {

  Route::get('/', [BannerController::class, 'index'])->name('admin.banner.list');

  // 新增頁
  Route::get('/create', [BannerController::class, 'create'])->name('admin.banner.create');

  // 新增資料
  Route::post('/', [BannerController::class, 'store'])->name('admin.banner.store');

  // 編輯頁
  Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('admin.banner.edit');

  // 更新資料
  Route::put('/update/{id}', [BannerController::class, 'update'])->name('admin.banner.update');

  // 刪除資料
  Route::delete('/delete/{id}', [BannerController::class, 'delete'])->name('admin.banner.delete');
});



// 新增 & 編輯 合併
// Route::get('/admin/banner/form/{id?}', function ($id = null) {
//   $banner = $id ? Banner::find($id) : null;

//   return Inertia::render('backend/banner/BannerForm', [
//     'response' => $banner
//   ]);
// })->name('admin.banner.form');



// Product 相關操作
Route::middleware(['auth', 'allUser'])->prefix('admin/product')->group(function () {
  Route::get('/', [ProductController::class, 'index'])->name('admin.product.list');

  // 新增頁
  Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');

  // 新增資料
  Route::post('/', [ProductController::class, 'store'])->name('admin.product.store');

  // 編輯頁
  Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');

  // 更新資料
  Route::put('/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');

  // 刪除資料
  Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('admin.product.delete');
});


// 新增顏色 類型 尺寸
Route::middleware(['auth', 'allUser'])->prefix('admin/productSpec')->group(function () {
  
  Route::get('/id={id}', [ProductOptionController::class, 'index'])->name('admin.productSpec');

  Route::put('/update/id={id}', [ProductOptionController::class, 'update'])->name('admin.productSpec.update');
});




// Inquire 相關操作
Route::middleware(['auth', 'allUser'])->prefix('admin/inquiry')->group(function () {
  Route::get('/', [InquiryController::class, 'index'])->name('admin.inquiry.list');

  // 儲存前端送來的資料
  Route::post('/', [InquiryController::class, 'store'])->name('admin.inquiry.store');

  // 後台詢價詳細頁面
  Route::get('/edit/{id}', [InquiryController::class, 'edit'])->name('admin.inquiry.edit');

  // 傳送信件給客人
  Route::put('/update/{id}', [InquiryController::class, 'update'])->name('admin.inquiry.update');
});
