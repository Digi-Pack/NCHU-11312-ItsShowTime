<?php

namespace App\Http\Controllers\Backend;

use App\Models\Size;
use App\Models\Type;
use Inertia\Inertia;
use App\Models\Color;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductsInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
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
                        'sort_order' => $info->color->sort_order,
                    ];
                })
                ->unique('id')
                ->sortBy('sort_order')
                ->values();

            $sizes = $product->productsInfo
                ->filter(function ($info) {
                    return $info->size_id !== null && $info->size !== null;
                })
                ->map(function ($info) {
                    return [
                        'id' => $info->size_id,
                        'name' => $info->size->size_name,
                        'sort_order' => $info->size->sort_order,
                    ];
                })
                ->unique('id')
                ->sortBy('sort_order')
                ->values();

            $types = $product->productsInfo
                ->filter(function ($info) {
                    return $info->type_id !== null && $info->type !== null;
                })
                ->map(function ($info) {
                    return [
                        'id' => $info->type_id,
                        'name' => $info->type->type_name,
                        'sort_order' => $info->type->sort_order,
                    ];
                })
                ->unique('id')
                ->sortBy('sort_order')
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
    }

    public function create()
    {
        $colors = Color::orderBy('sort_order')->get();
        $types = Type::orderBy('sort_order')->get();
        $sizes = Size::orderBy('sort_order')->get();

        $products = Product::all();

        return Inertia::render('backend/product/ProductCreate', [
            'colors' => $colors,
            'types' => $types,
            'sizes' => $sizes,
            'response' => $products,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' =>  'string|max:255',
                'colors' =>  'array',
                'types' =>  'array',
                'sizes' =>  'array',
                'mainImg_file' => 'file|mimes:jpg,jpeg,png,webp',
                'subImg_files' => 'array|max:4',
                'subImg_files.*' => 'file|mimes:jpg,jpeg,png,webp',
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
            if (!empty($request->colors)) {
                foreach ($request->colors as $colorId) {
                    ProductsInfo::create([
                        'product_id' => $product->id,
                        'color_id' => $colorId,
                        'size_id' => null,
                        'type_id' => null,
                        'image_id' => $imageIds[$imageIndex++] ?? null,
                    ]);
                };
            };

            // size
            if (!empty($request->sizes)) {
                foreach ($request->sizes as $sizeId) {
                    ProductsInfo::create([
                        'product_id' => $product->id,
                        'color_id' => null,
                        'size_id' => $sizeId,
                        'type_id' => null,
                        'image_id' => $imageIds[$imageIndex++] ?? null,
                    ]);
                };
            };
            // type
            if (!empty($request->types)) {
                foreach ($request->types as $typeId) {
                    ProductsInfo::create([
                        'product_id' => $product->id,
                        'color_id' => null,
                        'size_id' => null,
                        'type_id' => $typeId,
                        'image_id' => $imageIds[$imageIndex++] ?? null,
                    ]);
                };
            };

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
    }

    public function edit($id)
    {
        $colors = Color::orderBy('sort_order')->get();
        $types = Type::orderBy('sort_order')->get();
        $sizes = Size::orderBy('sort_order')->get();

        $product = Product::with('productsInfo.color', 'productsInfo.size', 'productsInfo.type', 'productsInfo.image')->find($id);

        $pColors = $product->productsInfo
            ->filter(fn($info) => $info->color_id !== null && $info->color !== null)
            ->map(fn($info) => [
                'id' => $info->color_id,
                'name' => $info->color->color_name,
            ])
            ->unique('id')
            ->values();

        $pSizes = $product->productsInfo
            ->filter(fn($info) => $info->size_id !== null && $info->size !== null)
            ->map(fn($info) => [
                'id' => $info->size_id,
                'name' => $info->size->size_name,
            ])
            ->unique('id')
            ->values();

        $pTypes = $product->productsInfo
            ->filter(fn($info) => $info->type_id !== null && $info->type !== null)
            ->map(fn($info) => [
                'id' => $info->type_id,
                'name' => $info->type->type_name,
            ])
            ->unique('id')
            ->values();

        $pImages = $product->productsInfo
            ->filter(fn($info) => $info->image_id !== null && $info->image !== null)
            ->map(fn($info) => [
                'id' => $info->image_id,
                'img_path' => $info->image->img_path,
                'isMain' => $info->image->isMain,
            ])
            ->unique('id')
            ->values();

        $first_img = $pImages->first(fn($image) => $image['isMain'] === 1);

        $subImgs = $pImages->filter(fn($image) => $image['isMain'] === 0)->values();

        return Inertia::render('backend/product/ProductEdit', [
            'colors' => $colors,
            'types' => $types,
            'sizes' => $sizes,
            'response' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'introduction' => $product->introduction,
                'first_img' => $first_img,
                'colors' => $pColors,
                'sizes' => $pSizes,
                'types' => $pTypes,
                'subImgs' => $subImgs,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' =>  'string|max:255',
                'colors' =>  'array',
                'types' =>  'array',
                'sizes' =>  'array',

                'new_mainFile' => $request->hasFile('new_mainFile') ? 'file|mimes:jpg,jpeg,png,webp' : '',
                'new_subFiles' => $request->hasFile('new_subFiles') ? 'array|max:4' : '',
                'new_subFiles.*' => $request->hasFile('new_subFiles') ? 'file|mimes:jpg,jpeg,png,webp' : '',
            ]);

            $product = Product::with('productsInfo.color', 'productsInfo.size', 'productsInfo.type', 'productsInfo.image')->find($id);
            if (!$product) {
                return back()->with(['message' => [
                    'res' => 'fail',
                    'msg' => '查無此消息',
                ]]);
            };

            $res = 'success';
            $message = '儲存成功';

            // 首圖處理
            if ($request->hasFile('new_mainFile')) {
                $mainFile = $request->new_mainFile;
                $mainFileName = $mainFile->getClientOriginalName();
                if (!is_dir('upload/')) {
                    mkdir('upload/');
                };
                if (!is_dir('upload/product')) {
                    mkdir('upload/product');
                };
                $mainHashName = $mainFile->hashName();
                $mainPath = '/upload/' . 'product' . '/' . $mainHashName;
                move_uploaded_file($mainFile, public_path() . $mainPath);
                // $file->move(public_path('upload/banner'), $mainHashName);

                // 刪除舊照片
                $mainImg = $product->productsInfo->first(fn($info) => $info->image && $info->image->isMain === 1);

                $oldMainFile = $mainImg->image->img_path;

                if (file_exists(public_path() . $oldMainFile)) {
                    File::delete(public_path() . $oldMainFile);
                };

                $mainImg->image->update([
                    'img_path' => $mainPath,
                    'img_name' => $mainFileName,
                ]);
            };

            // 輔助圖處理
            if ($request->hasFile('new_subFiles')) {
                $subFiles = $request->new_subFiles;

                // 拿出舊圖片
                $oldSubFiles = $product->productsInfo
                    ->filter(fn($info) => $info->image && $info->image->isMain === 0)
                    ->pluck('image')
                    ->unique('id')
                    ->values();
                // dd($oldSubFiles);

                foreach ($subFiles as $index => $subFile) {
                    $subFileName = $subFile->getClientOriginalName();
                    if (!is_dir('upload/')) {
                        mkdir('upload/');
                    };
                    if (!is_dir('upload/product')) {
                        mkdir('upload/product');
                    };

                    $subHashName = $subFile->hashName();
                    $subPath = '/upload/' . 'product' . '/' . $subHashName;
                    move_uploaded_file($subFile, public_path() . $subPath);


                    if (isset($oldSubFiles[$index])) {

                        // 舊圖數量 = 新圖數量
                        $oldImage = $oldSubFiles[$index];

                        if (file_exists(public_path() . $oldImage->img_path)) {
                            File::delete(public_path() . $oldImage->img_path);
                        };

                        $oldImage->update([
                            'img_path' => $subPath,
                            'img_name' => $subFileName,
                        ]);
                    } else {

                        // 舊圖數量 < 新圖數量
                        // 找出 image_id 為 null 的 ProductsInfo
                        $emptyInfo = $product->productsInfo->first(fn($info) => is_null($info->image_id));

                        $newSubImage = Image::create([
                            'img_path' => $subPath,
                            'img_name' => $subFileName,
                            'isMain' => 0,
                        ]);

                        if ($emptyInfo) {
                            $emptyInfo->update([
                                'image_id' => $newSubImage->id,
                            ]);
                        } else {
                            ProductsInfo::create([
                                'product_id' => $product->id,
                                'image_id' => $newSubImage->id,
                            ]);
                        }
                    };
                };

                // 舊圖數量 > 新圖數量
                if (count($oldSubFiles) > count($subFiles)) {
                    $extraOlds = $oldSubFiles->slice(count($subFiles));

                    foreach ($extraOlds as $image) {
                        if (file_exists(public_path() . $image->img_path)) {
                            File::delete(public_path() . $image->img_path);
                        }

                        $image->delete();
                    };
                }
            };

            // ProductsInfo 資料表更新
            // color 部分
            $newColors = (array) $request->colors;
            // 找出舊color
            $oldColors = $product->productsInfo
                ->filter(fn($info) => $info->color_id !== null)
                ->pluck('color_id')
                ->unique()
                ->values()
                ->toArray();

            if ($newColors || $oldColors) {
                // 要把舊的資料(沒有在新的color裡面)刪掉
                $removedOldColors = array_diff($oldColors, $newColors);
                foreach ($removedOldColors as $removedOldColor) {
                    ProductsInfo::where('product_id', $product->id)
                        ->where('color_id', $removedOldColor)
                        ->update(['color_id' => null]);
                }

                // 找出新增的 color
                $AddNewColors = array_diff($newColors, $oldColors);
                foreach ($AddNewColors as $AddNewColor) {
                    $nullInfo = $product->productsInfo
                        ->filter(
                            fn($info) => is_null($info->color_id) && is_null($info->type_id) && is_null($info->size_id)
                        )
                        ->first();

                    if ($nullInfo) {
                        $nullInfo->update([
                            'color_id' => $AddNewColor,
                        ]);
                    } else {
                        ProductsInfo::create([
                            'product_id' => $product->id,
                            'color_id' => $AddNewColor,
                        ]);
                    }
                };
            };

            // type 部分
            $newTypes = (array) $request->types;
            // 找出舊 type
            $oldTypes = $product->productsInfo
                ->filter(fn($info) => $info->type_id !== null)
                ->pluck('type_id')
                ->unique()
                ->values()
                ->toArray();

            if ($newTypes || $oldTypes) {
                // 要把舊的資料(沒有在新的type裡面)刪掉
                $removedOldTypes = array_diff($oldTypes, $newTypes);
                foreach ($removedOldTypes as $removedOldType) {
                    ProductsInfo::where('product_id', $product->id)
                        ->where('type_id', $removedOldType)
                        ->update(['type_id' => null]);
                }

                // 找出新增的 type
                $AddNewTypes = array_diff($newTypes, $oldTypes);
                foreach ($AddNewTypes as $AddNewType) {
                    $nullInfo = $product->productsInfo
                        ->filter(
                            fn($info) => is_null($info->color_id) && is_null($info->type_id) && is_null($info->size_id)
                        )
                        ->first();

                    if ($nullInfo) {
                        $nullInfo->update([
                            'type_id' => $AddNewType,
                        ]);
                    } else {
                        ProductsInfo::create([
                            'product_id' => $product->id,
                            'type_id' => $AddNewType,
                        ]);
                    }
                };
            };

            // size 部分
            $newSizes = (array) $request->sizes;
            // 找出舊 type
            $oldSizes = $product->productsInfo
                ->filter(fn($info) => $info->size_id !== null)
                ->pluck('size_id')
                ->unique()
                ->values()
                ->toArray();

            if ($newSizes || $oldSizes) {
                // 要把舊的資料(沒有在新的size裡面)刪掉
                $removedOldSizes = array_diff($oldSizes, $newSizes);
                foreach ($removedOldSizes as $removedOldSize) {
                    ProductsInfo::where('product_id', $product->id)
                        ->where('size_id', $removedOldSize)
                        ->update(['size_id' => null]);
                }

                // 找出新增的 size
                $AddNewSizes = array_diff($newSizes, $oldSizes);
                foreach ($AddNewSizes as $AddNewSize) {
                    $nullInfo = $product->productsInfo
                        ->filter(
                            fn($info) => is_null($info->color_id) && is_null($info->type_id) && is_null($info->size_id)
                        )
                        ->first();

                    if ($nullInfo) {
                        $nullInfo->update([
                            'size_id' => $AddNewSize,
                        ]);
                    } else {
                        ProductsInfo::create([
                            'product_id' => $product->id,
                            'size_id' => $AddNewSize,
                        ]);
                    }
                };
            };

            $product->update([
                'name' =>  $request->name,
                'price' =>  $request->price,
                'introduction' =>  $request->introduction,
            ]);

            ProductsInfo::whereNull('color_id')
                ->whereNull('type_id')
                ->whereNull('size_id')
                ->whereNull('image_id')
                ->delete();
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            $res = 'fail';
            $message = $th->getMessage();
        };

        return back()->with(['message' => [
            'res' => $res,
            'msg' => $message,
        ]]);
    }

    public function delete($id)
    {
        $product = Product::with('productsInfo.image')->find($id);

        if (!$product) {
            return back()->with(['message' => [
                'res' => 'fail',
                'msg' => '查無此消息',
            ]]);
        };

        $imageIds = $product->productsInfo->pluck('image_id')->filter();
        $images = Image::whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            $oldFile = $image->img_path;

            if (file_exists(public_path() . $oldFile)) {
                File::delete(public_path() . $oldFile);
            };

            $image->delete();
        }

        $product->delete();

        return back()->with(['message' => [
            'res' => 'success',
            'msg' => '刪除成功',
        ]]);
    }
}
