<?php

namespace App\Http\Controllers\Backend;


use App\Models\User;
use Inertia\Inertia;
use App\Models\UsersInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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

        try {

            $user = User::findOrFail(Auth::id());

            $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:15',
                'birthday' => 'nullable|date',
                'img_path' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            ]);

            $res = 'success';
            $message = '儲存成功';

            $user->update([
                'name' => $request->username,
                'email' => $request->email,
            ]);

            $userInfo = $user->usersInfo;

            if ($userInfo) {
                $userInfo->update([
                    'phonenumber' => $request->phone,
                    'birthday' => $request->birthday,
                ]);
            } else {
                UsersInfo::create([
                    'user_id' => $user->id,
                    'phonenumber' => $request->phone,
                    'birthday' => $request->birthday,
                ]);
            }


            if ($request->hasFile('img_path')) {
                $file = $request->img_path;
                $fileName = $file->getClientOriginalName();
                if (!is_dir('upload/')) {
                    mkdir('upload/');
                };
                if (!is_dir('upload/avatars')) {
                    mkdir('upload/avatars');
                };
                $hashName = $file->hashName();
                $path = '/upload/' . 'avatars' . '/' . $hashName;

                if ($userInfo && $userInfo->img_path && $userInfo->img_path !== $path) {
                    $oldPath = public_path() . $userInfo->img_path;
                    if (file_exists($oldPath)) {
                        File::delete(public_path() . $oldPath);
                    }
                }

                move_uploaded_file($file, public_path() . $path);

                // // 刪除舊照片
                // $oldFile = $userInfo->img_path;
                // if (file_exists(public_path() . $oldFile)) {
                //     File::delete(public_path() . $oldFile);
                // };

                if ($userInfo) {
                    $userInfo->update(['img_path' => $path]);
                } else {
                    UsersInfo::create([
                        'user_id' => $user->id,
                        'img_path' => $path,
                    ]);
                }
            };
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
