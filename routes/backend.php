<?php

use App\Models\Size;
use App\Models\Type;
use Inertia\Inertia;
use App\Models\Color;
use App\Models\Image;
use App\Models\Banner;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\ProductsInfo;
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

// 新增 & 編輯 合併
Route::get('/admin/banner/form/{id?}', function ($id = null) {
  $banner = $id ? Banner::find($id) : null;

  return Inertia::render('backend/banner/BannerForm', [
    'response' => $banner
  ]);
})->name('admin.banner.form');


// 新增頁
// Route::get('/admin/banner/create', function () {
//   $banners = Banner::all();
//   return Inertia::render('backend/banner/BannerCreate', [
//     'response' => $banners,
//   ]);
// })->name('admin.banner.create');


// 新增資料
Route::post('/admin/banner', function (Request $request) {

  try {
    $request->validate([
      'title' => 'required|string|max:255',
      'img_path' => 'required|file|mimes:jpg,jpeg,png,webp',
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
// Route::get('/admin/banner/edit/{id}', function ($id) {
//   $item = Banner::find($id);

//   return Inertia::render('backend/banner/BannerEdit', [
//     'response' => $item,
//   ]);
// })->name('admin.banner.edit');


// 更新資料
Route::put('/admin/banner/update/{id}', function (Request $request, $id) {

  try {
    $request->validate([
      'title' => 'required|string|max:255',
      // 'img_path' => 'file|mimes:jpg,jpeg,png,webp',
      'new_file' => $request->hasFile('new_file') ? 'file|mimes:jpg,jpeg,png,webp' : '',
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
  $products = Product::with('productsInfo.color', 'productsInfo.size', 'productsInfo.type', 'productsInfo.image')->get();

  $products = $products->map(function ($product) {

    $colors = $product->productsInfo
      ->filter(function ($info) {
        return $info->color_id !== null && $info->color !== null;
      })
      ->map(function ($info) {
        return [
          'id' => $info->color_id,
          'name' => $info->color->color_name,
        ];
      })
      ->unique('id')
      ->values();

    $sizes = $product->productsInfo
      ->filter(function ($info) {
        return $info->size_id !== null && $info->size !== null;
      })
      ->map(function ($info) {
        return [
          'id' => $info->size_id,
          'name' => $info->size->size_name,
        ];
      })
      ->unique('id')
      ->values();

    $types = $product->productsInfo
      ->filter(function ($info) {
        return $info->type_id !== null && $info->type !== null;
      })
      ->map(function ($info) {
        return [
          'id' => $info->type_id,
          'name' => $info->type->type_name,
        ];
      })
      ->unique('id')
      ->values();

    $images = $product->productsInfo
      ->filter(function ($info) {
        return $info->image_id !== null && $info->image !== null;
      })
      ->map(function ($info) {
        return [
          'id' => $info->image_id,
          'img_path' => $info->image->img_path,
          'isMain' => $info->image->isMain,
        ];
      })
      ->unique('id')
      ->values();

    $first_img = $images->first(function ($image) {
      return $image['isMain'] === 1;
    });
    return [
      'id' => $product->id,
      'name' => $product->name,
      'price' => $product->price,
      'introduction' => $product->introduction,
      'first_img' => $first_img,
      'images' => $images,
      'colors' => $colors,
      'sizes' => $sizes,
      'types' => $types,
    ];
  });

  return Inertia::render('backend/product/ProductList', [
    'response' => $products,
  ]);
})->name('admin.product.list');

// 新增頁
Route::get('/admin/product/create', function () {
  $colors = Color::all();
  $types = Type::all();
  $sizes = Size::all();

  $products = Product::all();

  return Inertia::render('backend/product/ProductCreate', [
    'colors' => $colors,
    'types' => $types,
    'sizes' => $sizes,
    'response' => $products,
  ]);
})->name('admin.product.create');


// 新增資料
Route::post('/admin/product', function (Request $request) {
  // dd($request->all());

  try {
    $request->validate([
      'name' => 'required|string|max:255',
      'price' =>  'string|max:255',
      'colors' =>  'array',
      'types' =>  'array',
      'sizes' =>  'array',
      'mainImg_file' => 'file|mimes:jpg,jpeg,png,webp',
      'subImg_files' =>  'array|max:4',
      'subImg_files.*' => 'file|mimes:jpg,jpeg,png,webp',
      'introduction' =>  'string',
    ]);

    $imageIds = [];
    // 首圖處理
    $mainfile = $request->mainImg_file;
    $mainFileName = $mainfile->getClientOriginalName();
    if (!is_dir('upload/')) {
      mkdir('upload/');
    };
    if (!is_dir('upload/product')) {
      mkdir('upload/product');
    };
    $mainHashName = $mainfile->hashName();
    $main_path = '/upload/' . 'product' . '/' . $mainHashName;
    move_uploaded_file($mainfile, public_path() . $main_path);

    $mainImage = Image::create([
      'img_name' => $mainFileName,
      'img_path' => $main_path,
      'isMain' => 1,
    ]);

    $imageIds[] = $mainImage->id;


    // 輔助圖處理
    $subfiles = $request->subImg_files;
    foreach ($subfiles as $subfile) {
      $subFileName = $subfile->getClientOriginalName();
      if (!is_dir('upload/')) {
        mkdir('upload/');
      };
      if (!is_dir('upload/product')) {
        mkdir('upload/product');
      };
      $subHashName = $subfile->hashName();
      $sub_path = '/upload/' . 'product' . '/' . $subHashName;
      move_uploaded_file($subfile, public_path() . $sub_path);

      // images 資料表新增
      $subImage = Image::create([
        'img_name' => $subFileName,
        'img_path' => $sub_path,
        'isMain' => 0,
      ]);

      $imageIds[] = $subImage->id;
    };

    $res = 'success';
    $message = '儲存成功';

    // products 資料表新增
    $product = Product::create([
      'name' =>  $request->name,
      'price' =>  $request->price,
      'introduction' =>  $request->introduction,
    ]);

    // productsinfo 資料表新增

    $imageIndex = 0;
    // color
    foreach ($request->colors as $colorId) {
      ProductsInfo::create([
        'product_id' => $product->id,
        'color_id' => $colorId,
        'size_id' => null,
        'type_id' => null,
        'image_id' => $imageIds[$imageIndex++] ?? null,
      ]);
    }

    // size
    foreach ($request->sizes as $sizeId) {
      ProductsInfo::create([
        'product_id' => $product->id,
        'color_id' => null,
        'size_id' => $sizeId,
        'type_id' => null,
        'image_id' => $imageIds[$imageIndex++] ?? null,
      ]);
    }

    // type
    foreach ($request->types as $typeId) {
      ProductsInfo::create([
        'product_id' => $product->id,
        'color_id' => null,
        'size_id' => null,
        'type_id' => $typeId,
        'image_id' => $imageIds[$imageIndex++] ?? null,
      ]);
    }

    // 圖片數量 > 顏色.款式.尺寸相加
    for (; $imageIndex < count($imageIds); $imageIndex++) {
      ProductsInfo::create([
          'product_id' => $product->id,
          'color_id' => null,
          'size_id' => null,
          'type_id' => null,
          'image_id' => $imageIds[$imageIndex],
      ]);
  }


  } catch (\Throwable $th) {
    Log::info($th->getMessage());
    $res = 'fail';
    $message = $th->getMessage();
  };

  return back()->with(['message' => [
    'res' => $res,
    'msg' => $message,
  ]]);
})->name('admin.product.store');



// 編輯頁
Route::get('/admin/product/edit/{id}', function ($id) {
  $item = Product::find($id);

  return Inertia::render('backend/product/ProductEdit', [
    'response' => $item,
  ]);
})->name('admin.product.edit');


// 更新資料
Route::put('/admin/product/update/{id}', function (Request $request, $id) {
  try {
    $request->validate([
      'name' => 'required|string|max:255',
      // 'price' =>  $request->price,
      // 'introduction' =>  $request->content,
      // 'img_path' => 'file|mimes:jpg,jpeg,png,webp',
      // 'new_file' => $request->hasFile('new_file') ? 'file|mimes:jpg,jpeg,png,webp' : '',
    ]);

    $product = Product::find($id);
    if (!$product) {
      return back()->with(['message' => [
        'res' => 'fail',
        'msg' => '查無此消息',
      ]]);
    };

    $res = 'success';
    $message = '儲存成功';

    // if ($request->hasFile('new_file')) {
    //   $file = $request->new_file;
    //   $fileName = $file->getClientOriginalName();
    //   if (!is_dir('upload/')) {
    //     mkdir('upload/');
    //   };
    //   if (!is_dir('upload/product')) {
    //     mkdir('upload/product');
    //   };
    //   $hashName = $file->hashName();
    //   $path = '/upload/' . 'product' . '/' . $hashName;
    //   move_uploaded_file($file, public_path() . $path);
    //   // $file->move(public_path('upload/banner'), $hashName);

    //   // 刪除舊照片
    //   $oldFile = $product->img_path;
    //   if (file_exists(public_path() . $oldFile)) {
    //     File::delete(public_path() . $oldFile);
    //   };

    //   $product->update([
    //     'img_path' => $path,
    //     'img_name' => $fileName,
    //   ]);
    // };

    $product->update([
      'name' =>  $request->name,
      'price' =>  $request->price,
      'introduction' =>  $request->content,
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
})->name('admin.product.update');


// 刪除資料
Route::delete('/admin/product/delete/{id}', function ($id) {

  $product = Product::find($id);
  if (!$product) {
    return back()->with(['message' => [
      'res' => 'fail',
      'msg' => '查無此消息',
    ]]);
  };

  // 刪除該筆照片
  // $oldFile = $banner->img_path;
  // if (file_exists(public_path() . $oldFile)) {
  //   File::delete(public_path() . $oldFile);
  // };

  $product->delete();

  return back()->with(['message' => [
    'res' => 'success',
    'msg' => '刪除成功',
  ]]);
})->name('admin.product.delete');






// Inquire 相關操作
Route::get('/admin/inquiry', function () {
  // $products = Product::all();
  $inquiries = Inquiry::with('product')->get();

  return Inertia::render('backend/inquiry/InquiryList', [
    'response' => $inquiries,
  ]);
})->name('admin.inquiry.list');


// 儲存前端送來的資料
Route::post('/admin/inquiry', function (Request $request) {
  try {
    $request->validate([
      'username' => 'required|string',
      // 'birthday' => 'required|date',
      'phone' => 'required|string',
      'email' => 'required|email',
      // 'address' => 'nullable|string',
      'remark' => 'nullable|string',
    ]);

    $res = 'success';
    $message = '詢價單已成功送出！';

    Inquiry::create([
      'name' =>  $request->username,
      'phone' =>  $request->phone,
      'email' =>  $request->email,
      'product_id' => $request->product_id,
      'remark' =>  $request->remark,
    ]);
  } catch (\Throwable $th) {
    Log::info($th->getMessage());
    $res = 'fail';
    $message = $th->getMessage() ?? '送出失敗，請稍後再試！';
  };

  return back()->with(['message' => [
    'res' => $res,
    'msg' => $message,
  ]]);
})->name('admin.inquiry.store');



// 刪除資料
Route::delete('/admin/inquiry/delete/{id}', function ($id) {

  $inquiry = Inquiry::find($id);
  if (!$inquiry) {
    return back()->with(['message' => [
      'res' => 'fail',
      'msg' => '查無此消息',
    ]]);
  };

  $inquiry->delete();

  return back()->with(['message' => [
    'res' => 'success',
    'msg' => '刪除成功',
  ]]);
})->name('admin.inquiry.delete');
