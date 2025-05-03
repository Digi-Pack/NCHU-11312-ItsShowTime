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
        $products = Product::with(['color', 'size', 'type', 'image'])->get();
    
        return Inertia::render('frontend/homePage', [
            'banners' => $banners,
            'response' => $products,
        ]);
    }
    


public function inquire(Request $request)
    {
       $id_array = $request->id;
       $color = Color::get();
       $type = Type::get();

        $product = Product::whereIn('id', $id_array)->get();
        // dd($product);
        return Inertia::render('frontend/inquirePage', [
            'response' => $product,
            'color' => $color,
            'type' => $type,
        ]);
    }

    

    
}


