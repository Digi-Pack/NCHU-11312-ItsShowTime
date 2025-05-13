<?php

namespace App\Http\Controllers\Frontend;


use App\Models\Type;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Color;
use App\Models\Banner;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
                        'img_name' => $info->image->img_name,
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
            'auth' => [
                'user' => Auth::user(),
            ]
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
                        'img_name' => $info->image->img_name,
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
            'auth' => [
                'user' => Auth::user(),
                ]
        ]);
    }


    public function animate()
    {
        return Inertia::render('settings/animate', []);
    }


    public function myProfile()
    {
        $user = User::with('usersInfo')->findOrFail(Auth::id());

        return Inertia::render('frontend/myProfile', [
            'response' => $user,
        ]);
    }


    public function password()
    {
        $user = User::with('usersInfo')->findOrFail(Auth::id());

        return Inertia::render('frontend/passwordChange', [
            'response' => $user,

        ]);
    }


    public function history()
    {
        $user = User::with('usersInfo')->findOrFail(Auth::id());

        $inquiries = Inquiry::with('orderLists')->where('user_id', $user->id)->get();
    
        $productId = $inquiries->pluck('orderLists')
            ->flatten()
            ->pluck('product_id')
            ->unique()
            ->filter()
            ->values();

        $product = Product::with('productsInfo.image')->find($productId);
        
        $productImg = $product->map(function ($product) {
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
                'first_img' => $first_img,
            ];
        });


        $response = [
            'user' => $user,
            'inquiries' => $inquiries,
            'productImg' => $productImg,
        ];

        return Inertia::render('frontend/inquireHistory', [
            'response' => $response,
        ]);
    }
}
