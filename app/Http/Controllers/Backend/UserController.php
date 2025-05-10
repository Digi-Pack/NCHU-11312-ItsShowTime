<?php

namespace App\Http\Controllers\Backend;


use App\Models\User;
use App\Models\UserInfo;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 顯示使用者資料
    public function myProfile()
    {
        // 根據當前登入用戶的 ID 取得用戶資料及其相關的 usersInfo
        $user = User::with('usersInfo')->findOrFail(Auth::id());

        // 將資料傳遞給前端視圖
        return Inertia::render('frontend/myProfile', [
            'response' => $user,
        ]);
    }

    // 更新使用者資料
    public function updateProfile(Request $request)
    {
        // 取得當前登入用戶的資料
        $user = User::findOrFail(Auth::id());

        // 驗證傳入的資料
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // 排除當前用戶的 email 驗證
            'phonenumber' => 'nullable|string|max:15',
            'img_path' => 'nullable|string',
        ]);

        // 更新用戶的基本資料
        $user->update([
            'name' => $validatedData['username'],
            'email' => $validatedData['email'],
        ]);

        // 取得用戶的附加資料 (usersInfo)
        $userInfo = $user->usersInfo;

        // 如果用戶有填寫過 usersInfo 資料，則更新它
        if ($userInfo) {
            $userInfo->update([
                'name' => $validatedData['username'],
                'phonenumber' => $validatedData['phonenumber'] ?? $userInfo->phonenumber,
                'email' => $validatedData['email'],
                'img_path' => $validatedData['img_path'] ?? $userInfo->img_path,
            ]);
        } else {
            // 如果沒有用戶的附加資料，則創建新的 UserInfo 資料
            UserInfo::create([  // 這裡應該是 UserInfo 而不是 userInfo
                'user_id' => $user->id,  // 使用 $user->id，而不是 $request->id
                'name' => $validatedData['username'],
                'phonenumber' => $validatedData['phonenumber'],
                'email' => $validatedData['email'],
                'img_path' => $validatedData['img_path'],
            ]);
        }

        // 可以加一個重定向回到資料更新頁面，並回傳成功訊息
        return redirect()->route('myprofile')->with('success', '資料更新成功!');
    }
}
