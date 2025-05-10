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
        // 获取当前登录用户
        $user = User::findOrFail(Auth::id());

        // 验证请求的数据
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'birthday' => 'nullable|date',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 图片验证
        ]);

        // 更新用户基本资料
        $user->update([
            'name' => $validated['username'],
            'email' => $validated['email'],
        ]);

        // 如果有提供图片，进行处理并上传
        if ($request->hasFile('img_path')) {
            // 存儲圖片並更新其路徑
            $imagePath = $request->file('img_path')->store('avatars', 'public');
            $validated['img_path'] = $imagePath; // 更新用户资料中的图片路径
        }

        // 更新用户详细信息，如果没有则创建
        $userInfo = $user->usersInfo;

        if ($userInfo) {
            // 如果用户信息已经存在，更新相关数据
            $userInfo->update([
                'phonenumber' => $validated['phone'] ?? $userInfo->phonenumber,
                'birthday' => $validated['birthday'] ?? $userInfo->birthday,
                'img_path' => $validated['img_path'] ?? $userInfo->img_path, // 使用新的圖片路徑
            ]);
        } else {
            // 如果用户信息不存在，创建新记录
            UsersInfo::create([
                'user_id' => $user->id,
                'phonenumber' => $validated['phone'],
                'birthday' => $validated['birthday'],
                'img_path' => $validated['img_path'],
            ]);
        }

        // 返回成功信息
        return redirect()->route('myprofile')->with('success', '資料更新成功');
    }
}
