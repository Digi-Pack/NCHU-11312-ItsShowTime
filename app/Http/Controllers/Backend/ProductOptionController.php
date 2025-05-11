<?php

namespace App\Http\Controllers\Backend;

use App\Models\Size;
use App\Models\Type;
use Inertia\Inertia;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ProductOptionController extends Controller
{
    public function index($id)
    {
        if ($id == 1) {
            $colors = Color::orderBy('sort_order')->get();
            return Inertia::render('backend/product/ProductOptionColor', [
                'response' => $colors,
            ]);
        } elseif ($id == 2) {
            $types = Type::orderBy('sort_order')->get();
            return Inertia::render('backend/product/ProductOptionType', [
                'response' => $types,
            ]);
        } elseif ($id == 3) {
            $sizes = Size::orderBy('sort_order')->get();
            return Inertia::render('backend/product/ProductOptionSize', [
                'response' => $sizes,
            ]);
        } else {
            abort(404);
        };
    }

    public function update(Request $request, $id)
    {
        if ($id == 1) {
            // dd($request->all());
            try {
                $request->validate([
                    'newItem' => 'required|array',
                    'newItem.*.color_name' => 'required|string|max:255',
                    'newItem.*.sort' => 'required|integer',
                ]);

                $newItems = $request->input('newItem');
                $keepIds = collect($newItems)->pluck('id')->filter()->toArray();

                Color::whereNotIn('id', $keepIds)->delete();

                foreach ($newItems as $item) {
                    // 資料庫中是否有該 id
                    $color = Color::find($item['id']);
                    if ($color) {
                        $color->update([
                            'sort_order' => $item['sort'],
                        ]);
                    } else {
                        // 沒找到 -> 新增
                        Color::create([
                            'id' => $item['id'],
                            'color_name' => $item['color_name'],
                            'sort_order' => $item['sort'],
                        ]);
                    }
                };

                $res = 'success';
                $message = '儲存成功';
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
                $res = 'fail';
                $message = $th->getMessage();
            };
        } elseif ($id == 2) {

            try {
            // dd($request->all());

                $request->validate([
                    'newItem' => 'required|array',
                    'newItem.*.type_name' => 'required|string|max:255',
                    'newItem.*.sort' => 'required|integer',
                ]);

                $newItems = $request->input('newItem');


                $keepIds = collect($newItems)->pluck('id')->filter()->toArray();
                Type::whereNotIn('id', $keepIds)->delete();

                foreach ($newItems as $item) {
                    $type = Type::find($item['id']);

                    if ($type) {
                        $type->update([
                            'sort_order' => $item['sort'],
                        ]);

                    } else {
                        Type::create([
                            'id' => $item['id'],
                            'type_name' => $item['type_name'],
                            'sort_order' => $item['sort'],
                        ]);
                    }
                };

                $res = 'success';
                $message = '儲存成功';
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
                $res = 'fail';
                $message = $th->getMessage();
            };
        } elseif ($id == 3) {
            try {
                $request->validate([
                    'newItem' => 'required|array',
                    'newItem.*.size_name' => 'required|string|max:255',
                    'newItem.*.sort' => 'required|integer',
                ]);

                $newItems = $request->input('newItem');
                $keepIds = collect($newItems)->pluck('id')->filter()->toArray();

                Size::whereNotIn('id', $keepIds)->delete();

                foreach ($newItems as $item) {
                    // 資料庫中是否有該 id
                    $size = Size::find($item['id']);
                    if ($size) {
                        $size->update([
                            'sort_order' => $item['sort'],
                        ]);
                    } else {
                        // 沒找到 -> 新增
                        Size::create([
                            'id' => $item['id'],
                            'size_name' => $item['size_name'],
                            'sort_order' => $item['sort'],
                        ]);
                    }
                };

                $res = 'success';
                $message = '儲存成功';
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
                $res = 'fail';
                $message = $th->getMessage();
            };
        } else {
            abort(404);
        };


        return back()->with(['message' => [
            'res' => $res,
            'msg' => $message,
        ]]);
    }
}
