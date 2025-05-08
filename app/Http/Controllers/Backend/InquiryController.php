<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Mail\TestMail;
use App\Models\Inquiry;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::with('product')->get();

        return Inertia::render('backend/inquiry/InquiryList', [
            'response' => $inquiries,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email',
                'address' => 'nullable|string',
                'remark' => 'nullable|string',
                'products' => 'required|array',
            ]);

            // dd($request->all());

            $res = 'success';
            $message = '詢價單已成功送出！';

            $inquiry = Inquiry::create([
                'name' =>  $request->username,
                'phone' =>  $request->phone,
                'email' =>  $request->email,
                'address' => $request->address,
                'remark' =>  $request->remark,
            ]);

            foreach ($request->products as $product) {
                // dd($product);
                OrderList::create([
                    'inquiry_id' => $inquiry->id,
                    'product' => $product['product'],  // product_name
                    'color' => $product['color'],
                    'type' => $product['style'],
                    'size' => $product['size'],
                    'quantity' => $product['quantity'],
                ]);
            };

            // 寄信功能
            $testData = [
                'name' => '詢價單送出測試成功',
            ];
            Mail::to($inquiry['email'])->send(new TestMail($testData));
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            $res = 'fail';
            $message = $th->getMessage() ?? '送出失敗，請稍後再試！';
        };

        return back()->with(['message' => [
            'res' => $res,
            'msg' => $message,
        ]]);
    }

    public function edit($id)
    {
        $inquiries = Inquiry::with('orderLists')->find($id);

        return Inertia::render('backend/inquiry/InquiryDetail', [
            'response' => $inquiries,
        ]);
    }
}
