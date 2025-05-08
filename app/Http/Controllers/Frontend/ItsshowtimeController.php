<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Type;
use Inertia\Inertia;
use App\Models\Color;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItsshowtimeController extends Controller

{

    public function index()
    {
        $banners = Banner::all();
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

        return Inertia::render('frontend/homePage', [
            'banners' => $banners,
            'response' => $products,
        ]);
    }



    public function inquire(Request $request)
    {
        $id_array = $request->id;

        $product = Product::with('productsInfo.color', 'productsInfo.size', 'productsInfo.type', 'productsInfo.image')
            ->whereIn('id', $id_array)->get();
        $product = $product->map(function ($product) {

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

        return Inertia::render('frontend/inquirePage', [
            'response' => $product,
        ]);


        // return Inertia::render('settings/animate', [
        //     'response' => $product,
        // ]);
    }


    public function animate()
    {
        return Inertia::render('settings/animate', [
            
        ]);
    }


    public function myProfile()
    {
        return Inertia::render('frontend/myProfile', [
    
        ]);
    }

    public function password()
    {
        return Inertia::render('frontend/passwordChange', [
    
        ]);
    }

    public function history()
    {
        return Inertia::render('frontend/inquireHistory', [
    
        ]);
    }


    public function login()
    {
        return Inertia::render('auth/Login.vue', [
    
        ]);
    }

}
