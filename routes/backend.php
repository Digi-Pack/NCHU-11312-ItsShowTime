<?php

use Inertia\Inertia;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


// Banner 相關操作
Route::get('/admin/banner', function () {
  $banners = Banner::all();
  return Inertia::render('backend/banner/BannerList', [
    'response' => $banners,
  ]);
})->name('admin.banner.list');


// 新增頁
Route::get('/admin/create', function () {
  $banners = Banner::all();
  return Inertia::render('backend/banner/BannerCreate', [
    'response' => $banners,
  ]);
})->name('admin.banner.create');


// 新增資料
Route::post('/admin/banner', function (Request $request) {

  try {
    $request->validate([
      // 之後再添加
      'title' => 'required|string|max:255',
    ]);

    $res = 'success';
    $message = '儲存成功';

    Banner::create([
      'title' =>  $request->title,
      'img_path' => $request->img_path,
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
  // if($item == null) return redirect('/admin/banner');

  return Inertia::render('backend/banner/BannerEdit', [
    'response' => $item,
  ]);
})->name('admin.banner.edit');


// 更新資料
Route::put('/admin/banner/update/{id}', function (Request $request, $id) {

  try {
    $request->validate([
      // 之後再添加
      'title' => 'required|string|max:255',
    ]);

    $banner = Banner::find($id);

    $res = 'success';
    $message = '儲存成功';

    $banner->update([
      'title' =>  $request->title,
      'img_path' => $request->img_path,
    ]);
    if (!$banner) {
      return back()->with(['message' => [
        'res' => 'fail',
        'msg' => '查無此消息',
      ]]);
    };

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

  $banner->delete();

  return back()->with(['message' => [
    'res' => 'success',
    'msg' => '刪除成功',
  ]]);
})->name('admin.banner.delete');
