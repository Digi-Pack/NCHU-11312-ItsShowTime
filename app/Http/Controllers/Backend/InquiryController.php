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
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::with('product')->orderBy('id', 'desc')->get();

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

            $user = User::where('email', $request->email)->first();

            $res = 'success';
            $message = '詢價單已成功送出！';

            $inquiry = Inquiry::create([
                'user_id' => $user->id ?? null, // 如果沒有找到用戶，則設為 null
                'name' =>  $request->username,
                'phone' =>  $request->phone,
                'email' =>  $request->email,
                'address' => $request->address,
                'remark' =>  $request->remark,
            ]);
            foreach ($request->products as $product) {
                OrderList::create([
                    'product_id' => $product['id'],
                    'inquiry_id' => $inquiry->id,
                    'product' => $product['name'],  // product_name
                    // 'product' => $product['product'],  // product_name
                    'color' => $product['color'] ?? '',
                    'type' => $product['style'] ?? '',
                    'size' => $product['size'] ?? '',
                    'quantity' => $product['quantity'] ?? 1,
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

            $shouldSendMail = false;
            $content = $request->replyMailMessage;

            $updateData = [
                'status' => $request->status,
            ];

            // 狀態是「已回覆」且還沒寄
            if ($request->status == 1 && !$inquiry->reply_mail_sent) {
                $shouldSendMail = true;
                $updateData['reply_mail_sent'] = true;
                $updateData['mail_message'] = $request->replyMailMessage;
                $content = $request->replyMailMessage;
            }

            // 狀態是「已取消」且還沒寄
            elseif ($request->status == 2 && !$inquiry->cancel_mail_sent) {
                $shouldSendMail = true;
                $updateData['cancel_mail_sent'] = true;
                $updateData['mail_message'] = $request->replyMailMessage;
                $content = '您的詢價已取消，取消原因為：' . $request->replyMailMessage;
            }

            $inquiry->update($updateData);

            if ($shouldSendMail) {
                Mail::to($inquiry['email'])->send(new InquiryReply($content));
            }

            $res = 'success';
            $message = $shouldSendMail ? '信件已成功送出' : '未重新寄送信件';
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            $res = 'fail';
            $message = $th->getMessage() ?? '信件未送出';
        };

        return back()->with(['message' => [
            'res' => $res,
            'msg' => $message,
        ]]);
    }
}
