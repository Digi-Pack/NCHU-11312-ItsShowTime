<?php

use Inertia\Inertia;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;


// Banner 相關操作
Route::get('/admin/banner', function () {
  $banners = Banner::all();
  return Inertia::render('backend/banner/BannerList', [
    'response' => $banners,
  ]);
})->name('admin.banner.list');


// 新增頁
Route::get('/admin/banner/create', function () {
  $banners = Banner::all();
  return Inertia::render('backend/banner/BannerCreate', [
    'response' => $banners,
  ]);
})->name('admin.banner.create');


// 新增資料
Route::post('/admin/banner', function (Request $request) {

  try {
    $request->validate([
      'title' => 'required|string|max:255',
      'img_path' => 'file|mimes:jpg,jpeg,png,webp',
    ]);

    $file = $request->img_path;

    $fileName = $file->getClientOriginalName();

    if (!is_dir('upload/')) {
      mkdir('upload/');
    };
    if (!is_dir('upload/banner')) {
      mkdir('upload/banner');
    };

    $hashName = $file->hashName();
    $path = '/upload/' . 'banner' . '/' . $hashName;

    move_uploaded_file($file, public_path() . $path);

    $res = 'success';
    $message = '儲存成功';

    Banner::create([
      'title' =>  $request->title,
      'img_name' => $fileName,
      'img_path' => $path,
    ]);
  } catch (\Throwable $th) {
    Log::info($th->getMessage());
    $res = 'fail';
    $message = $th->getMessage();
  };

  return back()->with(['message' => [
    'res' => $res,
    'msg' => $message,
  ]]);
})->name('admin.banner.store');



// 編輯頁
Route::get('/admin/banner/edit/{id}', function ($id) {
  $item = Banner::find($id);

  return Inertia::render('backend/banner/BannerEdit', [
    'response' => $item,
  ]);
})->name('admin.banner.edit');


// 更新資料
Route::put('/admin/banner/update/{id}', function (Request $request, $id) {

  try {
    $request->validate([
      'title' => 'required|string|max:255',
      // 'img_path' => 'file|mimes:jpg,jpeg,png,webp',
      'new_file' => 'file|mimes:jpg,jpeg,png,webp',
    ]);

    $banner = Banner::find($id);
    if (!$banner) {
      return back()->with(['message' => [
        'res' => 'fail',
        'msg' => '查無此消息',
      ]]);
    };

    $res = 'success';
    $message = '儲存成功';

    if ($request->hasFile('new_file')) {
      $file = $request->new_file;
      $fileName = $file->getClientOriginalName();
      if (!is_dir('upload/')) {
        mkdir('upload/');
      };
      if (!is_dir('upload/banner')) {
        mkdir('upload/banner');
      };
      $hashName = $file->hashName();
      $path = '/upload/' . 'banner' . '/' . $hashName;
      move_uploaded_file($file, public_path() . $path);
      // $file->move(public_path('upload/banner'), $hashName);

      // 刪除舊照片
      $oldFile = $banner->img_path;
      if (file_exists(public_path() . $oldFile)) {
        File::delete(public_path() . $oldFile);
      };

      $banner->update([
        'img_path' => $path,
        'img_name' => $fileName,
      ]);
    };

    $banner->update([
      'title' =>  $request->title,
    ]);
  } catch (\Throwable $th) {
    Log::info($th->getMessage());
    $res = 'fail';
    $message = $th->getMessage();
  };

  return back()->with(['message' => [
    'res' => $res,
    'msg' => $message,
  ]]);
})->name('admin.banner.update');


// 刪除資料
Route::delete('/admin/banner/delete/{id}', function ($id) {
  $banner = Banner::find($id);
  if (!$banner) {
    return back()->with(['message' => [
      'res' => 'fail',
      'msg' => '查無此消息',
    ]]);
  };

  // 刪除該筆照片
  $oldFile = $banner->img_path;
  if (file_exists(public_path() . $oldFile)) {
    File::delete(public_path() . $oldFile);
  };

  $banner->delete();

  return back()->with(['message' => [
    'res' => 'success',
    'msg' => '刪除成功',
  ]]);
})->name('admin.banner.delete');



// Product 相關操作
Route::get('/admin/product', function () {
  $products = Product::all();
  return Inertia::render('backend/product/ProductList', [
    'response' => $products,
  ]);
})->name('admin.product.list');

// 新增頁
Route::get('/admin/product/create', function () {
  $products = Product::all();
  return Inertia::render('backend/product/ProductCreate', [
    'response' => $products,
  ]);
})->name('admin.product.create');


// 新增資料
Route::post('/admin/product', function (Request $request) {

  Product::create([
    // 'name' =>  $request->name,
    // 'price' =>  $request->price,
    'introduction' =>  $request->content,
    // 'img_name' => $fileName,
    // 'img_path' => $path,
  ]);

  return redirect(route('admin.product.list'));
  // try {
    // $request->validate([
    //   'title' => 'required|string|max:255',
    //   'img_path' => 'file|mimes:jpg,jpeg,png,webp',
    // ]);

    // $file = $request->img_path;

    // $fileName = $file->getClientOriginalName();

    // if (!is_dir('upload/')) {
    //   mkdir('upload/');
    // };
    // if (!is_dir('upload/product')) {
    //   mkdir('upload/product');
    // };

    // $hashName = $file->hashName();
    // $path = '/upload/' . 'product' . '/' . $hashName;

    // move_uploaded_file($file, public_path() . $path);

    // $res = 'success';
    // $message = '儲存成功';

  //   Product::create([
  //     // 'name' =>  $request->name,
  //     // 'price' =>  $request->price,
  //     'introduction' =>  $request->content,
  //     // 'img_name' => $fileName,
  //     // 'img_path' => $path,
  //   ]);
  // } catch (\Throwable $th) {
  //   Log::info($th->getMessage());
  //   $res = 'fail';
  //   $message = $th->getMessage();
  // };

  // return back()->with(['message' => [
  //   'res' => $res,
  //   'msg' => $message,
  // ]]);

})->name('admin.product.store');



// 編輯頁
Route::get('/admin/product/edit/{id}', function ($id) {})->name('admin.product.edit');


// 更新資料
Route::put('/admin/product/update/{id}', function (Request $request, $id) {})->name('admin.product.update');


// 刪除資料
Route::delete('/admin/product/delete/{id}', function ($id) {})->name('admin.product.delete');
