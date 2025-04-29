<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItsshowtimeController extends Controller

{
    


public function inquire($id)
    {
        $product = Product::select()->find($id);

        return Inertia::render('frontend/inquirePage', [
            'response' => $product,
        ]);
    }


    
}


