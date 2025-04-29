<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItsshowtimeController extends Controller

{
    


public function inquire(Request $request)
    {

       $id_array = $request->id;

        $product = Product::whereIn('id', $id_array)->get();
        // dd($product);
        return Inertia::render('frontend/inquirePage', [
            'response' => $product,
        ]);
    }


    
}


