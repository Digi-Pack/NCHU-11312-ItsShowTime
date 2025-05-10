<?php

namespace App\Http\Controllers\Backend;


use App\Models\User;
use App\Models\UsersInfo;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function myProfile()
    {
        $user = User::with('usersInfo')->findOrFail(Auth::id());

        return Inertia::render('frontend/myProfile', [
            'response' => $user,
        ]);
    }



    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        // 驗證資料
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'birthday' => 'nullable|date',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 更新用戶基本資料
        $user->update([
            'name' => $validated['username'],
            'email' => $validated['email'],
        ]);

        // 更新用戶額外資料
        $userInfo = $user->usersInfo;
        if ($userInfo) {
            $userInfo->update([
                'phonenumber' => $validated['phone'] ?? $userInfo->phonenumber,
                'birthday' => $validated['birthday'] ?? $userInfo->birthday,
            ]);
        } else {
            UsersInfo::create([
                'user_id' => $user->id,
                'phonenumber' => $validated['phone'],
                'birthday' => $validated['birthday'],
            ]);
        }

        // 如果有上傳圖片
        if ($request->hasFile('img_path')) {
            $imagePath = $request->file('img_path')->store('avatars', 'public');
            $userInfo->update(['img_path' => $imagePath]);

            return response()->json([
                'res' => 'success',
                'msg' => '資料更新成功',
                'img_url' => asset('storage/' . $imagePath),
            ]);
        }

        // 返回成功訊息
        return response()->json([
            'res' => 'success',
            'msg' => '資料更新成功',
        ]);
    }






    // public function updateProfileImage(Request $request)
    // {
    //     // 驗證圖片
    //     $validated = $request->validate([
    //         'img_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 圖片驗證
    //     ]);

    //     // 儲存圖片並獲取圖片路徑
    //     $imagePath = $request->file('img_path')->store('avatars', 'public');

    //     // 更新用戶資料庫中的圖片路徑
    //     $user = Auth::user();
    //     $user->usersInfo()->update(['img_path' => $imagePath]);

    //     // 返回圖片的完整 URL
    //     return response()->json([
    //         'success' => true,
    //         'img_url' => asset('storage/' . $imagePath), // 返回圖片的 URL
    //     ]);
    // }
}
