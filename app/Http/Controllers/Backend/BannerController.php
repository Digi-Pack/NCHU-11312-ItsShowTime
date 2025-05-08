<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function index() {
        $banners = Banner::all();
        return Inertia::render('backend/banner/BannerList', [
            'response' => $banners,
        ]);
    }
}
