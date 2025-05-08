<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return Inertia::render('backend/banner/BannerList', [
            'response' => $banners,
        ]);
    }

    public function create()
    {
        $banners = Banner::all();
        return Inertia::render('backend/banner/BannerCreate', [
            'response' => $banners,
        ]);
    }

    public function store(Request $request)
    {
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
    }

    public function edit($id)
    {
        $item = Banner::find($id);

        return Inertia::render('backend/banner/BannerEdit', [
            'response' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
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
    }

    public function delete($id)
    {
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
    }
}
