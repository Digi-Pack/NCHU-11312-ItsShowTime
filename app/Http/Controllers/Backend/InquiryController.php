<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Mail\TestMail;
use App\Models\Inquiry;
use App\Models\OrderList;
use App\Mail\InquiryReply;
use Illuminate\Http\Request;
use App\Mail\InquiryConfirmation;
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
            Mail::to($inquiry['email'])->send(new InquiryConfirmation());
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

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required',
                'replyMailMessage' => 'nullable|string',
            ]);

            $inquiry = Inquiry::find($id);
            if (!$inquiry) {
                return back()->with(['message' => [
                    'res' => 'fail',
                    'msg' => '查無此消息',
                ]]);
            };


            if ($request->status == 0 && !empty($request->replyMailMessage)) {
                return back()->with(['message' => [
                    'res' => 'fail',
                    'msg' => '狀態為「未回覆」時不能填寫回覆訊息',
                ]]);
            };

            if (in_array($request->status, [1, 2]) && empty($request->replyMailMessage)) {
                return back()->with(['message' => [
                    'res' => 'fail',
                    'msg' => '狀態為「已回覆」或「取消」時必須填寫回覆訊息',
                ]]);
            };

            $shouldSendMail = in_array($request->status, [1, 2]) && empty($inquiry->mail_message);
        
            $inquiry->update([
                'status'=>  $request->status,
                'mail_message' =>  $request->replyMailMessage,
            ]);

            if ($shouldSendMail) {
                Mail::to($inquiry['email'])->send(new InquiryReply($request->replyMailMessage));
            };


            $res = 'success';
            $message = $shouldSendMail ? '儲存成功（信件已送出）' : '儲存成功（未重新寄送信件）';


        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            $res = 'fail';
            $message = $th->getMessage() ?? '儲存失敗(信件未送出)';
        };

        return back()->with(['message' => [
            'res' => $res,
            'msg' => $message,
        ]]);
    }
}
