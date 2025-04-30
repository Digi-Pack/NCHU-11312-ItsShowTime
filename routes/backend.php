<?php

use Inertia\Inertia;
use App\Models\Banner;
use Illuminate\Http\Request;
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

  Banner::create([
    'title' =>  $request->title,
    'img_path' => $request->img_path,
  ]);
  return redirect(route('admin.banner.create'))->with(['message' => '成功']);

})->name('admin.banner.store');

// 編輯頁
Route::get('/admin/banner/edit/{id}', function ($id) {
  $item = Banner::find($id);
  // if($item == null) return redirect('/admin/banner');

  return Inertia::render('backend/banner/BannerEdit', [
    'response' => $item,
  ]);
})->name('admin.banner.edit');


// 編輯資料
Route::post('/admin/banner/update/{id}', function (Request $request, $id) {
  $banner = Banner::find($id);

  $banner->update([
    'title' =>  $request->title,
    'img_path' => $request->img_path,
  ]);
  return redirect(route('admin.banner.list'));
})->name('admin.banner.update');

// 刪除資料
Route::get('/admin/banner/delete/{id}', function ($id) {
  $item = Banner::find($id);
  $item->delete();
  return redirect(route('admin.banner.list'));
})->name('admin.banner.delete');
